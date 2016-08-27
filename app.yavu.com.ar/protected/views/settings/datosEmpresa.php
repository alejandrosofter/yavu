 <script src="js/jquery.sticky.js"></script>
 <link href="http://hayageek.github.io/jQuery-Upload-File/4.0.8/uploadfile.css" rel="stylesheet">
 <script src="http://hayageek.github.io/jQuery-Upload-File/4.0.8/jquery.uploadfile.min.js"></script>
 <div  class="btn-group "  style='float:right;padding-top:50px' id='botones'>

<button onclick="aceptar()" id='btnAceptar' class="btn btn-success" type="button"><i class="icon-ok icon-white"> </i> GUARDAR</button>
</div>
<h1>Datos de su <small>EMPRESA</small></h1>

Es muy <b>importante</b> que complete todos los datos aquí ya que estos están <b>ligados a todas</b> las áreas del sistema.
<div style='padding-top:50px;padding-left:20px' class="tabbable tabs-left">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#lA" data-toggle="tab">Datos de Empresa</a></li>
                <li class=""><a href="#lB" data-toggle="tab">Datos Fiscales</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="lA">
                  <table>
					<tr><th style='text-align:right'>LOGO </th><td><div id='logo'><?=$params['logo']?></div><div id="singleupload"></div></td></tr>
					<tr><th style='text-align:right'>RAZÓN SOCIAL <span style='color:red'>*</span></th><td><input id='razonSocial' value='<?=$params["razonSocial"]?>' type="text" class='span6'></td></tr>
					<tr><th style='text-align:right'>LOCALIDAD <span style='color:red'>*</span></th><td><input id='localidad' type="text" value='<?=$params["localidad"]?>' class='span4'></td></tr>
					<tr><th style='text-align:right'>PROVINCIA <span style='color:red'>*</span></th><td><input id='provincia' type="text" value='<?=$params["provincia"]?>'  class='span3'></td></tr>
					<tr><th style='text-align:right'>TELEFONOS <span style='color:red'>*</span></th><td><input id='telefonos' type="text" value='<?=$params["telefonos"]?>'  class='span6'></td></tr>
					<tr><th style='text-align:right'>EMAIL </th><td><input id='email' type="text" value='<?=$params["email"]?>'  class='span6'></td></tr>
					<tr><th style='text-align:right'>RESEÑA DE SU EMPRESA </th><td><input id='resena' value='<?=$params["resena"]?>'  type="text" class='span6'></td></tr>

					</table>
                </div>
                 <div class="tab-pane" id="lB">
                   <table>
					<tr><th style='text-align:right'>CUIT <span style='color:red'>*</span></th><td><input id='cuit' value='<?=$params["cuit"]?>'  type="text" class='span2'><p class="text-warning"><b>MUY IMPORTANTE</b> sin guiones!.</p></td></tr>
					<tr><th style='text-align:right'>CONDICION DE IVA <span style='color:red'>*</span></th><td><input id='condicionIva' value='<?=$params["condicionIva"]?>'  placeholder='Monotributo, responsable inscripto, etc' type="text" class='span6'></td></tr>
					<tr><th style='text-align:right'>INICIO DE ACTIVIDADES </th><td><input id='inicioActividades' value='<?=$params["inicioActividades"]?>'  type="text" class='span2'></td></tr>
					<tr><th style='text-align:right'>INGRESOS BRUTOS </th><td><input id='ingresosBrutos' value='<?=$params["ingresosBrutos"]?>'  type="text" class='span2'></td></tr>
					<tr><th style='text-align:right'>PUNTO DE VENTA ELECTRONICO </th><td><input id='puntoVenta' value='<?=$params["puntoVenta"]?>'  type="text" class='span1'></td></tr>
					

					</table>
                </div>
                <div class="tab-pane" id="lC">
                 
                </div>
                
              </div>
</div>


<script>
iniciarStickBotonera()
iniciarDescargador();
$('#razonSocial').focus();
function iniciarStickBotonera()
{
     $("#botones").stick_in_parent();
}
function datosValidos()
{
	if($('#condicionIva').val()=='')return false;
	if($('#cuit').val()=='')return false;
	if($('#razonSocial').val()=='')return false;
	if($('#localidad').val()=='')return false;
	if($('#provincia').val()=='')return false;
	if($('#telefonos').val()=='')return false;
	return true;
}
function iniciarDescargador()
{
	$("#singleupload").uploadFile({
	url:"index.php?r=site/uploadLogo",
	fileName:"myfile",
	uploadStr:"Subir Logo",
	multiple:false,
	dragDrop:true,
	maxFileCount:1,
	onSuccess:function(files,data,xhr,pd)
	{
	   $('#razonSocial').focus();
	   $('#logo').html(data);
	}
	});
}
function aceptar()
{
	if(datosValidos()){
		var dataEmpresa={DATOS_EMPRESA_CONDICIONIVA:$('#condicionIva').val(), DATOS_EMPRESA_CUIT:$('#cuit').val(), DATOS_EMPRESA_RAZONSOCIAL:$('#razonSocial').val(), DATOS_EMPRESA_DIRECCION:$('#direccion').val(), DATOS_EMPRESA_EMAILADMIN:$('#email').val(), DATOS_EMPRESA_LOCALIDAD:$('#localidad').val(), DATOS_EMPRESA_PROVINCIA:$('#provincia').val(), DATOS_EMPRESA_TELEFONO:$('#telefonos').val() , DATOS_EMPRESA_RESENAEMPRESA:$('#resena').val(), DATOS_EMPRESA_INICIOACTIVIDAD:$('#inicioActividades').val(), DATOS_EMPRESA_INGBRUTOS:$('#ingresosBrutos').val(), DATOS_EMPRESA_PUNTOVENTA:$('#puntoVenta').val()};
		$.get('index.php?r=site/guardarDatosEmpresa',dataEmpresa,function(data){
			sweetAlert("Bien!", "Se han cambiado los datos!", "success");
		});
	}else{
		sweetAlert("Opss...", "Hay datos que estan faltando mi amigo...", "error");
	}
	
}

</script>