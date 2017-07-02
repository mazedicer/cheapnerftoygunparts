<?php
session_start();
?>
<!doctype HTML>
<html>
	<head>
        <meta charset="utf-8"/>
		<title>toy guns</title>
		<meta name="description" content="Cheap Nerf toy gun parts, Buzzbee, Boomco, Dartzone, Toy guns, used/new for modding">
		<meta name="keywords" content="cheap toy guns, cheap nerf toy gun parts,cheap nerf parts, buzzbee, boomco, dartzone, toy guns">
		<meta name="author" content="Mario Carrizales">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link rel='stylesheet' href="css/index.css" />
		<script src="jquery-1.12.2/jquery-1.12.2.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="lightbox2-master/dist/css/lightbox.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script src="js/categories.js"></script>
    </head>
    <body>
		<div id="content" class="container-fluid">
			<div class="row center-content">
				<h1>Welcome to Cheap Nerf Toy Gun Parts<br><small>For Toy Gun Modding Enthusiast</small></h1>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="main-menu">
							<button id="menus-button" type="button" class="btn btn-primary" title="MENU">
								<span class="glyphicon glyphicon-menu-hamburger"></span>
							</button>
						</div>
					</div>
					<div id="menu" class="row">
						<!-- menu will appear here -->
					</div>
					<div class="row">
						<div id="menu_results">
						<!-- item results will appear here -->
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div id="shopping_cart_div">
							<input id="shopping_cart_btn" type="button" value="Shopping Cart" onclick="Cart.toggleCartView()">
							<div id="cart_div"></div>
						</div>
					</div>
				</div>
			</div>
			<div id="footer" class="row">
				<p>For inquiries, please contact Mario,<br>
					Email. <a href="mailto:customtoyguns@gmail?subject=Custom Toy Gun Order&body=I would like to place an order.">customtoyguns@gmail.com</a><br>
					Tel. 1-619-800-2278</p>
				<p><a href="http://www.prlog.org/12479916-customtoygunscom-the-source-for-toy-gun-commissions-official-launch.html">Customtoyguns.com The Source for Toy Gun Commissions Official Launch</a></p>
			</div>
		</div>
		<div class="modal fade" id="gallery_modal" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div id="menu_gallery" >
							<!-- item gallery will appear here -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/index.js"></script>
		<script type="text/javascript" src="js/cart.js"></script>
		<script type="text/javascript" src="js/utilities.js"></script>
		<script type="text/javascript" src="lightbox2-master/dist/js/lightbox.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>

