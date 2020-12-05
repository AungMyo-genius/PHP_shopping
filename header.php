<?php
session_start();
require 'config/config.php';
require 'config/common.php';
?>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>AP Shop</title>
	<!--
            CSS
            ============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>
<body id="category">
	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><h4>AP Shopping<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php
					$cart = 0;
					if(!empty($_SESSION['cart'])) {
						foreach($_SESSION['cart'] as $qty) {
							$cart += $qty;
						}
					}
					?>
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item">
								<a href="cart.php" class="cart"><span class="ti-bag"><?php echo $cart?></span></a>
							</li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
							<?php
							if(!empty($_SESSION['logged_in'])) {
								echo "
								<li class='nav-item'>
									<a href='logout.php' type='button' class='fa fa-sign-out' style='margin-top: 30 !important;'>Logout</a>
								</li>";
							}else{
								echo "
								<li class='nav-item'>
									<a href='Login.php' type='button' class='fa fa-sign-in' style='margin-top: 30 !important;'>Login</a>
								</li>";
							}
							?>
							<?php
							if(!empty($_SESSION['user_role']) && $_SESSION['user_role'] == 1) {
								echo "
								<li class='nav-item' style='margin-top: 30 !important;'>
								<a href='admin/index.php'>Admin Panel</a>
								</li>";
							}
							?>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between" action="index.php" method="POST">
					<input type="hidden" name="_token" value="<?php echo escape($_SESSION['_token']);?>">
					<input type="text" class="form-control" name="search" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->
	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb" style="margin-bottom: 0px !important;">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Welcome <?php echo !empty($_SESSION['username']) ? ucfirst($_SESSION['username']): '';?></h1>
				<?php
				if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
				  echo "<h2>Please login to shop</h2>";
				}
				?>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
