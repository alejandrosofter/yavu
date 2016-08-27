<?php include('head.php')?>
<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="inicio.php">Inicio</a></li>
									<li class="active">Cambio de Clave</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>Cambio de Clave</h1>
							</div>
						</div>
					</div>
				</section>
				<div class="container">

					<div class="row">
				<p class="lead">
					<?php if(isset($_GET['q'])){
						
						require("php/dbConexion/Db.class.php");

							// Creates the instance
							$db = new Db();

							$query="SELECT * FROM clientes where id=".$_GET['id'];
							$res 	 =     $db->query($query);
							
							if(count($res)>0){
								$verificado=hash('ripemd160', $res[0]['nombreUsuario'].'andatealaputaquetepario');
								if($verificado==$_GET['q']){ ?>
								<table cellspacing='10' style='padding:50px'>
								<tr><td><div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-key"></i></span>
														</span>
														<input style='width:200px' class="form-control" id='pass' type="password" placeholder="CLAVE">
													</div></td></tr>
								<tr><td><div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-key"></i></span>
														</span>
														<input style='width:200px' class="form-control" id='pass2' type="password" placeholder="REPITE CLAVE">
													</div></td></tr>
													<tr><td colspan=2><button id='btnCambiar' onclick='cambiarClave()' style='width:100%' class='btn btn-3d btn-primary mr-xs mb-sm'>Cambiar</button></td></tr>
								</table>
								

								<?php }
							}
					}	
					?>
				</p>
				<script>
				function cambiarClave()
				{
					if(estanCorrectasClaves())_cambiar();
				}
				function _cambiar()
				{
					$('#btnCambiar').button('loading');
					$.get('php/cambiarClave.php',{q:'<?=$_GET["q"]?>',id:'<?=$_GET["id"]?>',clave:$('#pass').val()},function(data){
						$('#btnCambiar').button('reset');
						swal({   title: "GENIAL!",  text:  "Se ha cambiado la clave exitosamente!",  html: true,  type: "success"},function(data){window.location.href=('http://app.yavu.com.ar/index.php?r=site/login')});
						
					});
				}
				function estanCorrectasClaves()
				{
					if($('#pass').val()==''){
						
						swal({   title: "Opss..",  text:  "La clave no puede estar en blanco",  html: true,  type: "error"});
						return false;
					}
					if($('#pass2').val()==''){
						swal({   title: "Opss..",  text:  "La clave no puede estar en blanco",  html: true,  type: "error"});
						return false;
						
					}
					if($('#pass').val()!=$('#pass2').val()){
						swal({   title: "Opss..",  text:  "Las claves no coinciden",  html: true,  type: "error"});
						return false;
						
					}
					return true;
				}
				</script>
							</div></div>
<?php include('footer.php')?>