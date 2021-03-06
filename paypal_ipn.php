<?php
include_once( "./classes/IPNProcess.php" );
$my_ipn_process = new IPNProcess();
// STEP 1: read POST data
// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
// Instead, read raw POST data from the input stream. 
$raw_post_data = file_get_contents( 'php://input' );
$raw_post_array = explode( '&', $raw_post_data );
$myPost = array();
foreach ( $raw_post_array as $keyval ){
    $keyval = explode( '=', $keyval );
    if ( count( $keyval ) == 2 ){
        $myPost[ $keyval[ 0 ] ] = urldecode( $keyval[ 1 ] );
    }
}
// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
$req = 'cmd=_notify-validate';
if ( function_exists( 'get_magic_quotes_gpc' ) ){
    $get_magic_quotes_exists = true;
}
foreach ( $myPost as $key => $value ){
    if ( $get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1 ){
        $value = urlencode( stripslashes( $value ) );
    } else{
        $value = urlencode( $value );
    }
    $req .= "&$key=$value";
}

// STEP 2: POST IPN data back to PayPal to validate
$ch = curl_init( 'https://www.paypal.com/cgi-bin/webscr' );
//$ch = curl_init( 'https://www.sandbox.paypal.com/cgi-bin/webscr' );
curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $req );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
curl_setopt( $ch, CURLOPT_FORBID_REUSE, 1 );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Connection: Close' ) );
// In wamp-like environments that do not come bundled with root authority certificates,
// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
// the directory path of the certificate as shown below:
// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
if ( !($res = curl_exec( $ch )) ){
    // error_log("Got " . curl_error($ch) . " when processing IPN data");
    curl_close( $ch );
    exit;
}
curl_close( $ch );

// STEP 3: Inspect IPN validation result and act accordingly
if ( strcmp( $res, "VERIFIED" ) == 0 ){
    /* The IPN is verified, process it:
      1 check whether the payment_status is Completed
      2 check that txn_id has not been previously processed
      3 check that receiver_email is your Primary PayPal email
      4 check that payment_amount/payment_currency are correct
     */
    $payment_status = $_POST[ 'payment_status' ];
    $order_number = $_POST[ 'custom' ];
    $txn_id = $_POST[ 'txn_id' ];
    $address_zip = $_POST[ 'address_zip' ];
    $address_state = $_POST[ 'address_state' ];
    $address_city = $_POST[ 'address_city' ];
    $address_street = $_POST[ 'address_street' ];
    $full_address = $address_street . " " . $address_city . " " . $address_state . " " . $address_zip;
    $payment_amount = $_POST[ 'mc_gross' ];
    $payment_currency = $_POST[ 'mc_currency' ];
    $receiver_email = $_POST[ 'receiver_email' ];
    $ipn_result = $my_ipn_process->processIPN( $order_number, $payment_status, $txn_id, $full_address );
    if ( strcmp( $ipn_result, "Completed" ) == 0 ){
        // process the notification
        // assign posted variables to local variables
        //$item_name = $_POST[ 'item_name' ];
        //$item_number = $_POST[ 'item_number' ];
        $payer_email = $_POST[ 'payer_email' ];
        $result = "";
        // IPN message values depend upon the type of notification sent.
        // To loop through the &_POST array and print the NV pairs to the screen:
        foreach ( $_POST as $key => $value ){
            $result .= $key . " = " . $value . "<br>";
        }
        require_once "./PHPMailer-master/PHPMailerAutoload.php";
        //PHPMailer Object
        $mail = new PHPMailer;
        //From email address and name
        $mail->From = "orders@mcbrg.com";
        $mail->FromName = "MCBRG.com Orders";
        //To address and name
        $mail->addAddress( "magneticartmaster@gmail.com", "Mario Carrizales" );
        //$mail->addAddress( "recepient1@example.com" ); //Recipient name is optional
        //Address to which recipient will reply
        //$mail->addReplyTo( "reply@yourdomain.com", "Reply" );
        //CC and BCC
        //$mail->addCC( "cc@example.com" );
        //$mail->addBCC( "bcc@example.com" );
        //Send HTML or Plain Text email
        $mail->isHTML( true );
        $mail->Subject = "Paypal IPN";
        $mail->Body = $payment_status . " " . $payment_amount . " " . $payment_currency . " " . $txn_id . " " . $receiver_email . " " . $payer_email . "<br>" . $result;
        $mail->AltBody = "This is the plain text version of the email content";
        if ( !$mail->send() ){
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else{
            echo "Message has been sent successfully";
        }
    }
} else if ( strcmp( $res, "INVALID" ) == 0 ){
    // IPN invalid, log for manual investigation
    echo "The response from IPN was: <b>" . $res . "</b>";
}