<?php $seleccion='Contactanos'; include('head.php')?>
<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="inicio.php">Inicio</a></li>
									<li class="active">Contactanos</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>Contactanos</h1>
							</div>
						</div>
					</div>
				</section>
<div id="googlemaps" class="google-map"></div>

				<div class="container">

					<div class="row">
						<div class="col-md-6">
						<img style='padding-left:150px;padding-top:150px;' src='img/telefono.jpg'/>
						</div>
						<div class="col-md-6">

							<h4 class="heading-primary mt-lg">Da con <strong>Nosotros</strong></h4>
							<p>Somos una pequeña empresa que se dedica ha varios años a desarrollar aplicaciones a medida, dando como resultado un sistema ya testeado y utilizado por varias empresas.</p>

							<hr>

							<h4 class="heading-primary">La <strong>Oficina</strong></h4>
							<ul class="list list-icons list-icons-style-3 mt-xlg">
								<li><i class="fa fa-map-marker"></i> <strong>Dirección:</strong> Velez Sarfield 1352 - 1 D</li>
								<li><i class="fa fa-phone"></i> <strong>Telefono:</strong> (0297) 156 257155</li>
								<li><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:alejandro@softer.com.ar">alejandro@softer.com.ar</a></li>
							</ul>

							<hr>

							<h4 class="heading-primary">Horarios de <strong>Atención</strong></h4>
							<ul class="list list-icons list-dark mt-xlg">
								<li><i class="fa fa-clock-o"></i> Lunes a Viernes - de 9 a 16 hrs</li>
								<li><i class="fa fa-clock-o"></i> Sábados - de 9 a 12 hrs</li>
								<li><i class="fa fa-clock-o"></i> Domingos - Cerrado</li>
							</ul>

						</div>

					</div>

				</div>

			</div>


<?php include('footer.php')?>
<script>

			/*
			Map Settings

				Find the Latitude and Longitude of your address:
					- http://universimmedia.pagesperso-orange.fr/geo/loc.htm
					- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

			*/

			// Map Markers
			var mapMarkers = [{
				address: "Comodoro Rivadavia, Velez Sarfield 1352",
				html: "<strong>Comodoro Rivadavia</strong><br>Velez Sarfield 1352",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				},
				popup: true
			}];

			// Map Initial Location
			var initLatitude = 0;
			var initLongitude = 0;

			// Map Extended Settings
			var mapSettings = {
				controls: {
					draggable: (($.browser.mobile) ? false : true),
					panControl: true,
					zoomControl: true,
					mapTypeControl: true,
					scaleControl: true,
					streetViewControl: true,
					overviewMapControl: true
				},
				scrollwheel: false,
				markers: mapMarkers,
				latitude: initLatitude,
				longitude: initLongitude,
				zoom: 15
			};

			var map = $("#googlemaps").gMap(mapSettings);

			// Map Center At
			var mapCenterAt = function(options, e) {
				e.preventDefault();
				$("#googlemaps").gMap("centerAt", options);
			}

		</script>