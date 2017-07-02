<?php
session_start();
require( "../classes/Cart.php" );
if( isset( $_POST[ 'cart' ] ) && !isset( $_POST[ 'zip' ] ) ){
	$my_cart = new Cart();
	$cart = $_POST[ 'cart' ];
	//generate a random order number
	$cur_time = time();
	$sess = session_id();
	$part1 = substr( $sess, 0, 4 );
	$part2 = substr( $cur_time, 2, 5 );
	$order_num = $part1 . $part2;
	$results = $my_cart->returnCart( $cart, $order_num );
	echo $results;
}
if( isset( $_POST[ 'cart' ] ) && isset( $_POST[ 'zip' ] ) ){
    $my_cart = new Cart();
    $cart = $_POST[ 'cart' ];
    $zip = $_POST[ 'zip' ];
    $results = $my_cart->getTotal( $cart, $zip );
    echo $results;
}
