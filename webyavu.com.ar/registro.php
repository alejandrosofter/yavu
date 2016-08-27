<?php $seleccion='Registrar'; include('head.php')?>
<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="inicio.php">Inicio</a></li>
									<li class="active">Registro</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>Registro</h1>
							</div>
						</div>
					</div>
				</section>
				<div class="container">

					<div class="row">
				<p class="lead">
							A continuación puede registrarse de forma totalmente <strong id='toolGratis'>GRATUITA</strong> para poder comenzar a usar YAVU!
	
								</p>	
		<div class='col-md-3'>	
			
		  	
		    

		  	
		</div>
		<div class='col-md-6'>	
		<div id='grupo_versionYavu' class="form-group">
		<span style='color:red'>*</span>
		  	<label class="control-label" for="radio">Versión Yavu</label> <br>
			  <label  data-toggle="tooltip" data-placement="top" title="Versión con funciones comerciales tales como clientes, FACTURACION ELECTRONICA, PROVEEDORES ETC">  
			  <input type="radio" name="versionYavu" id="comercial" value="comercial" checked> Comercial </label>   
			  <label data-toggle="tooltip" data-placement="top" title="[MOMENTANEMENTE DESABILITADA] Versión con funciones específicas para inmobiliarias como tambien con las funciones comerciales tales como expensas, contratos, facturación electronica etc">  
			  <input disabled type="radio" name="versionYavu" id="inmobiliaria" value="inmobiliaria"> Inmobiliaria </label> 
			</div>		
		  	<div id='grupo_nombreUsuario' class="form-group">
		  	<span style='color:red'>*</span>
		    <label  for="nombreUsuario">Nombre de Usuario</label>
		    <input  data-toggle="tooltip" data-placement="left" title="Este será el nombre que usará para ingresar al sistema" style='width:200px' type="text" class="form-control" id="nombreUsuario" placeholder="Usuario">
		  	</div>
		  	<div id='grupo_passUsuario' class="form-group">
		  	<span style='color:red'>*</span>
		    <label  for="passUsuario">Contraseña</label>
		    <input  data-toggle="tooltip" data-placement="left" title="Este será su clave única para ingresar al sistema" style='width:200px' type="password" class="form-control" id="passUsuario" placeholder="Contraseña">
		    <small>Ver clave <input id='verClave' onclick='verClaveTexto()' type='checkbox'></small>
		  	</div>
		  	<div id='grupo_email' class="form-group">
		  	<span style='color:red'>*</span>
			    <label for="email">Email</label>
			    <input style='width:350px' type="text" class="form-control" id="email" placeholder="Email">
		  	</div>
		  	<div id='grupo_emailRecomendado' class="form-group">
		  	
			    <label for="recomendado">RECOMENDADO POR ... (email)</label>
			    <input style='width:400px;background-color:#BAEABA;color:black' type="text" class="form-control" id="recomendado" placeholder="EMAIL">
		  	</div>
		
<span style='color:red'>*</span> <small><i>campos obligatorios</i></small> <br> <br>
			<button onclick='chequear()'  id='botonAceptar' style='width:400px' class="btn btn-success">Aceptar</button>
		
		</div>
		
			

				</div>

<?php include('footer.php')?>
<style>
.error{ background-color: red; };

</style>
<script>

init();
function verClaveTexto()
{
	var tipo=$('#verClave').prop('checked')?"text":"password";
	$('#passUsuario').attr('type',tipo);
}
 function init()
 {
 	$('#recomendado').popover({content:"<b>  DALE un <big style='color:green'> + %10 </big></b> de descuento a tu RECOMENDADOR ",html:true});
 	$('#recomendado').popover('show');
 	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
 }
var templateTool='<div class="tooltip error" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>';
var esValido=false;
var 	emailCheck=false;
 var	usuarioCheck=false;
 var	recomendadoCheck=false;
 function chequear()
 {
 	$.blockUI({ message: '<h1><img src="img/loader.gif" /> Espere un momento, validando datos!...</h1>' }); 
 	emailCheck=false;
 	usuarioCheck=false;
 	recomendadoCheck=false
 	var $btn = $('#botonAceptar').button('loading');
 	esValido=true;
 	//var requeridos=['nombre','apellido','domicilio'];
	//requeridos.forEach(checkRequeridos);
	
	//validarUsuarioDb();
	
	validarClave();
	if(validarEmail('email','grupo_email'))validarEmailDb('email','grupo_email');
	if(validarUsuario())validarUsuarioDb();
	if($('#recomendado').val()!=''){
		if(validarEmail('recomendado','grupo_emailRecomendado'))validarEmailDbRecomendado('recomendado','grupo_emailRecomendado');
	}else recomendadoCheck=true;
	idInter =setInterval(valoresCorrectos,1500)
	
	
	//ingresarRegistro()
	
 }
 var idInter;
 var contea=0;
 function valoresCorrectos()
 {

 	contea++;
 	if(emailCheck&&usuarioCheck&&recomendadoCheck)_ingresa();
 	if(contea==10){
 		$.unblockUI();
 		clearInterval(idInter);
 		swal({   title: "Opss...",   text: 'No podemos verificar tus datos.. intenta nuevamente en unos momentos por favor',   type: "error",   showCancelButton: false,   confirmButtonColor: "#2EFEF7",   confirmButtonText: "Genial!",   closeOnConfirm: true },function(){    });
 		contea=0;
 		
 	}
 }
 function _ingresa(){
		
   if(esValido)ingresarRegistro();else{
   	$.unblockUI();
 	clearInterval(idInter);
   	swal({   title: "Opss..",  text:  "Hay campos invalidos por favor ingrese valores correctos y vuelva a intentar...",  html: true,  type: "error"});
   
   	$('#botonAceptar').button('reset');
   }
}
 function ingresarRegistro()
 {
 	clearInterval(idInter);
 	$.blockUI({ message: '<h1><img src="img/loader.gif" /> Espere un momento, se esta creando su YAVU!...</h1>' }); 
 	$.get( "php/registrar.php",{ nombre:'',apellido: '',celular:'',domicilio:'',versionYavu:$('input:radio[name=versionYavu]:checked').val(),nombreUsuario:$('#nombreUsuario').val(),clave:$('#passUsuario').val(),email:$('#email').val(),recomendado:$('#recomendado').val() }, function( data ) {

 		setTimeout(mostrar,3000);

 	});
 }
 function mostrar()
 {
 		swal({   title: "Genial!",   text: 'Se ha creado su cuenta YAVU de forma exitosa! recibira en '+$('#email').val()+' informacion de su yavu.',   type: "success",   showCancelButton: false,   confirmButtonColor: "#2EFEF7",   confirmButtonText: "Genial!",   closeOnConfirm: true },function(){   window.location='http://app.yavu.com.ar/index.php?r=site/login' });
 		$.unblockUI();
  
 }
 function validarEmailDb(campo,field) {
	var fld=$('#'+campo).val();
	
    var error = "El email no esta disponible, por favor escriba otro";

   $.get( "php/validarEmail.php",{ email:fld }, function( data ) {
   	var valor=data*1;
   	emailCheck=true;
if(valor>0){
		$('#'+field).tooltip({"placement":"top","title":error,"template":templateTool});
		$('#'+field).attr('class','form-group has-error');
		
		esValido=esValido && false;
	}else{
		esValido=esValido && true;
	 	$('#'+field).tooltip('destroy');
	 	$('#'+field).attr('class','form-group');
	 	
 }

   });

    
}
 function validarEmailDbRecomendado(campo,field) {
	var fld=$('#'+campo).val();
	
    var error = "El email del recomendado no se encuentra en nuestra base de datos, por favor escriba otro";

   $.get( "php/validarEmail.php",{ email:fld }, function( data ) {
   	var valor=data*1;
   	recomendadoCheck=true;
if(valor==0){
		$('#'+field).tooltip({"placement":"top","title":error,"template":templateTool});
		$('#'+field).attr('class','form-group has-error');
		
		esValido=esValido && false;
	}else{
		esValido=esValido && true;
	 	$('#'+field).tooltip('destroy');
	 	$('#'+field).attr('class','form-group');
	 	
 }

   });

    
}
function validarUsuarioDb() {
	var fld=$('#nombreUsuario').val();
	
    var error = "El usuario no esta disponible, por favor escriba otro";
   $.get( "php/validarUsuario.php",{ usuario:fld }, function( data ) {
   	var valor=data*1;
   	usuarioCheck=true;
if(valor>0){
		$('#grupo_nombreUsuario').tooltip({"placement":"top","title":error,"template":templateTool});
		$('#grupo_nombreUsuario').attr('class','form-group has-error');
		esValido=esValido && false;
	}else{
		esValido=esValido && true;
	 	$('#grupo_nombreUsuario').tooltip('destroy');
	 	$('#grupo_nombreUsuario').attr('class','form-group');
	 	
 }

   });

    
}
function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
} 

function validarClave() {
    var error = "";
    var illegalChars = /[\W_]/; // allow only letters and numbers 
 	var fld=$('#passUsuario').val();

    if (fld == "") {
        error = "Debes ingresar una clave.\n";
    } else if ((fld.length < 7) || (fld.length > 15)) {
        error = "La clave debe tener entre 7 y 15 caracteres. \n";
    } else if (illegalChars.test(fld)) {
        error = "La clave tiene caracteres incorrectos.\n";
    }
   if(error!=''){
   		esValido=esValido && false;
		$('#grupo_passUsuario').tooltip({"placement":"top","title":error,"template":templateTool});
		$('#grupo_passUsuario').attr('class','form-group has-error');
	}else{
		esValido=esValido && true;
 	$('#grupo_passUsuario').tooltip('destroy');
 	$('#grupo_passUsuario').attr('class','form-group');
 } 
}  
function validarUsuario() {
	var fld=$('#nombreUsuario').val();
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores

    if (fld == "") {
        error = "Tiene que ingresar un nombre de usuario.\n";
    } else if ((fld.length < 5) || (fld.length > 15)) {
        error = "Debe tener entre 5 y 15 caracteres.\n";
    } else if (illegalChars.test(fld)) {
        error = "El usuario tiene caracteres no válidos.\n";
    } 
    if(error!=''){
    	esValido=esValido && false;
		$('#grupo_nombreUsuario').tooltip({"placement":"top","title":error,"template":templateTool});
		$('#grupo_nombreUsuario').attr('class','form-group has-error');
		return false;
		//esValido++;
	}else{
		esValido=esValido && true;
		
		validarUsuarioDb();
	 	$('#grupo_nombreUsuario').tooltip('destroy');
	 	$('#grupo_nombreUsuario').attr('class','form-group');
	 	return true;
 } 
}

function checkRequeridos(element, index, array) {
	var templateTool='<div class="tooltip error" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>';
 
    if($('#'+element).val()==''){
    	$('#grupo_'+element).tooltip({"placement":"top","title":"Debe ingresar texto","template":templateTool});
    	$('#grupo_'+element).attr('class','form-group has-error');
    	esValido=esValido && false;

 }else{
 	esValido=esValido && true;
 	$('#grupo_'+element).tooltip('destroy');
 	$('#grupo_'+element).attr('class','form-group');
 } 

}
function validarEmail(campo,field) {
	var fld=$('#'+campo).val();
    var error="";
    var tfld = trim(fld);                        // value of field with whitespace trimmed off
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    
    if (fld == "") {
        error = "Debes ingresar una casilla de correo.\n";
    } else if (!emailFilter.test(tfld)) {   
        error = "Debe ser un correo válido.\n";
    } else if (fld.match(illegalChars)) {
        error = "La casilla de correo tiene caracteres no válidos.\n";
    } 
    if(error!=''){
    	esValido=esValido && false;
		$('#'+field).tooltip({"placement":"top","title":error,"template":templateTool});
		$('#'+field).attr('class','form-group has-error');
		return false;
	}else{
		esValido=esValido && true;
		
 	$('#'+field).tooltip('destroy');
 	$('#'+field).attr('class','form-group');
 	return true;
 } 
}
</script>