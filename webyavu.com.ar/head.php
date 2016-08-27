<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title> YAVU - Software</title>	

		<meta name="keywords" content="software yavu comodoro rivadavia chubut argentina sistema gestion comprar tarjeta de credito yavu softer rada tilly" />
		<meta name="description" content="YAVU sistemas">
		<meta name="author" content="softer.com.ar">

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
<script src="vendor/jquery/jquery.js"></script>
<script src="js/block.js"></script>
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/bootstrap.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css">
		<link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.min.css" media="screen">
		<link rel="stylesheet" href="vendor/owlcarousel/owl.theme.default.min.css" media="screen">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" media="screen">
<script src="js/sweetalert-master/dist/sweetalert.min.js"></script> <link rel="stylesheet" type="text/css" href="js/sweetalert-master/dist/sweetalert.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">
		<link rel="stylesheet" href="css/theme-animate.css">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="vendor/rs-plugin/css/settings.css" media="screen">
		<link rel="stylesheet" href="vendor/circle-flip-slideshow/css/component.css" media="screen">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.js"></script>

		<!--[if IE]>
			<link rel="stylesheet" href="css/ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="vendor/respond/respond.js"></script>
			<script src="vendor/excanvas/excanvas.js"></script>
		<![endif]-->

	</head>
	<body id='todo_'>
		<div class="body">
			<header id="header">
				<div class="container">
					<div class="logo">
						<a href="index.php">
							<img alt="Sistema de Gestión" width="111" height="54" data-sticky-width="82" data-sticky-height="40" src="img/logo.png">
						</a>
					</div>
					<nav class="nav-top">
						<ul class="nav nav-pills nav-top">
							
							
							<li>
							<small id='login'>
								<button onclick="location.href='http://app.yavu.com.ar'" style='position:relative;top:4px' class="btn btn-borders btn-primary mr-xs mb-sm"  id='botonSign'><i class="fa fa-plug"></i>LOGIN</button>
							</small>
						
							</li>
						</ul>
					</nav>
					<button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
						<i class="fa fa-bars"></i>
					</button>
				</div>
				<div class="navbar-collapse nav-main-collapse collapse">
					<div class="container">
						<ul class="social-icons">
							<li class="facebook"><a href="http://www.facebook.com/softyavu" target="_blank" title="Facebook">Facebook</a></li>
						</ul>
						<nav class="nav-main mega-menu">
							<ul class="nav nav-pills nav-main" id="mainMenu">
								<li class="dropdown <?=$seleccion=='Inicio'?'active':''?>">
									<a href="index.php">
										Inicio
										<em class="not-included">Home</em>
									</a>
									
								</li>
								<li class="dropdown <?=$seleccion=='Caracteristicas'?'active':''?>">
									<a href="caracteristicas.php">
										Caracteristicas
										<em class="not-included">Una Herramienta</em>
									</a>
								</li>
								
								<li class="dropdown <?=$seleccion=='Screenshots'?'active':''?>">
									<a  href="screenshots.php">
										Screenshots
										<em class="not-included">Tomas de Pantalla</em>
									</a>
								</li>
								
								<li class="dropdown <?=$seleccion=='Registrar'?'active':''?>">
									<a class=''  href="registro.php">
										Registrar
										<span class="tip tip-dark">Gratis</span>
										<em class="not-included">(por un mes)</em>
									</a>
								</li>
								<li class="dropdown <?=$seleccion=='Contactanos'?'active':''?>">
									<a href="contactanos.php">
										Contactanos
										<em class="not-included">Donde estamos?</em>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</header>
			<div role="main" class="main">
	
