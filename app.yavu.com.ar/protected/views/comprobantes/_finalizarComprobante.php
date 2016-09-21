<script>

function calcularFinal()
{
	facturaSolicitudesServicio();
	setEmailEntidad();
	tipoComprobante();
	$('#labelGuarda').hide();
	setPaga();
	setImportes();
}
	function facturaSolicitudesServicio()
	{
		if(facturaSolicitudes)$("#facturaSolicitudes").html('<span style="" class="label label-info">FACTURANDO SOLICITUDES</span>');
		else $("#facturaSolicitudes").html("");
	}
	function setImportes()
{
	var importe=getImporteTotal();
	$('#importePago').val((importe));
	$('#labelTotal').html(format_number(importe,'$'));
}
function setPaga()
{
	
}
function hayErrores(resultados)
{
	return resultados.FeDetResp.FECAEDetResponse.Resultado=='R';
	
}
function imprimeErrores(err)
{
	var arr=new Array();
	var cad='';
	try {
	arr=err.Errors.Err;
	}catch(err) {

	}
	var obs="";
	try {
	obs=err.FeDetResp.FECAEDetResponse.Observaciones.Obs.Msg;
	
	}catch(err) {

	}
	//var obs='Se han encontrado errores, por favor chequea la información del cuit del cliente.<br>';
	var nroError=1;
	cad+=obs;
	if($.isArray(arr))
	arr.forEach(function(item) {
		cad+="<b>"+nroError+"</b>: "+item.Msg+'<br>';
		nroError++;
	});else{
		cad+="<b>"+nroError+"</b>: "+arr.Msg+'<br>';
	}
	swal({   title: "Opss..",  text:  cad,  html: true,  type: "error"});
}
function ingresarComprobante()
{
	var pagos={1:$('#importePago').val(),2:$('#importePagoDebito').val(),3:$('#importePagoTransf').val(),4:$('#importePagoCheques').val()  }
	var mai=$('#enviaMail').attr('checked')?' y enviando mail <img src="images/iconos/glyphicons/glyphicons_010_envelope.png"/>.':'.';
	$.blockUI({ message: '<h3><img src="img/ajax_loader.gif" /> Espere un momento, ingresando comprobante '+mai+'</h3>' });
	$.getJSON( "index.php?r=comprobantes/ingresarComprobante",{facturaSolicitudesServicio:facturaSolicitudes,pago:pagos,items:items,email:$('#inputEmail').val(),imprimeCompro:$('#imprimeCompro').val(),guardarMail:$('#guardarMail').attr('checked'),enviaMail:$('#enviaMail').attr('checked'),datosComprobante:dataComprobante}, function( data ) {
		$.unblockUI();
		console.log("LLEGA:");
		console.log(data);
		if(dataComprobante.esElectronica && dataComprobante.puedeElectronica){
			if(hayErrores(data.resElectronico))imprimeErrores(data.resElectronico);
				else  rtaIngresa(data,$('#imprimeCompro').attr('checked'));
		
		}else{
			rtaIngresa(data,$('#imprimeCompro').attr('checked'));
		}
		
		
		//rtaIngresa(data,$('#imprimeCompro').attr('checked'));
	});
}
function rtaIngresa(data,imprime)
{
	if(data.id!=null){
		
			if(imprime)imprimir(data.id);
			else {
				 swal({   title: "Genial!",   text: "El comprobante se ha ingresado correctamente!",   type: "success",   showCancelButton: false,   confirmButtonColor: "#2EFEF7",   confirmButtonText: "Genial!",   closeOnConfirm: true },function(){   location.reload() });
				
				//document.location.reload();
			}
		}else{
			swal({   title: "Opss..",  text:  "hay un error en el ingreso: "+data.resElectronico.FeDetResp.FECAEDetResponse.Observaciones.Obs.Msg,  html: true,  type: "error"});
		}
		
}
function imprimir(id)
{
	$.fancybox({
			'afterClose': function() {
            	window.location.reload();
            },
            'width': '600px',
            'height': '80%',
            'autoScale': true,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'type': 'iframe',
            'href': 'index.php?r=Comprobantes/imprimir&id='+id,
            
        });
}
function cambiaImportePago()
{
	var final=dataComprobante.importeTotal;
	var dif=final-($('#importePago').val()*1)-($('#importePagoDebito').val()*1)-($('#importePagoTransf').val()*1)-($('#importePagoCheques').val()*1);
	if(dif<0){
		$('#imgPagado').show();
		$('#labelPaga').html('Quedarán $ '+(-dif).toFixed(2)+' a <span class="label label-success">cuenta</span>!');
	};
	
	if(dif>0){
		$('#imgPagado').hide();
		$('#labelPaga').html('Quedarán $ '+dif.toFixed(2)+' <span class="label label-warning">a pagar</span>!');
	};
	
	if(dif==0){
		$('#labelPaga').html('');
			$('#imgPagado').show();
		}
}
function cambiaMail()
{

	
	if( validarEmail()){
		$('#addEmail').html('<img class="imagenElectronica"  src="images/iconos/famfam/bullet_green.png">');
		$( "#enviaMail" ).prop( "checked", true );
		$( "#enviaMail" ).removeAttr( "disabled" );
		$('#labelGuarda').show();
	}
	else{
		$('#addEmail').html('<img class="imagenElectronica"  src="images/iconos/famfam/bullet_red.png">');
		$( "#enviaMail" ).prop( "checked", false );
		$( "#enviaMail" ).attr( "disabled", "disabled" );
		$('#labelGuarda').hide();
	} 
}
function setEmailEntidad()
{
	$('#inputEmail').val(dataComprobante.emailEntidad);
	if(dataComprobante.emailEntidad=='')$('#inputEmail').attr('placeholder','La entidad no tiene mail!');
	cambiaMail();
}
function tipoComprobante()
{
	console.log(dataComprobante);
	if(dataComprobante.esElectronica&&dataComprobante.puedeElectronica) $('#textoComprobante').html('<div id="esElectronico"><span class="label label-info">Factura Electronica</span> <img class="imagenElectronica" src="images/online.jpg"></div>');
		else $('#textoComprobante').html('<img class="imagenElectronica"  src="images/offline.jpg">');



}
function validarEmail() {
	var fld=$('#inputEmail').val();
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
    return error=='';
}
</script>
<style>

.imagenElectronica{
	-webkit-transform: rotate(50deg); 
    transform: rotate(50deg);
}
</style>
<div class="modal hide fade" id="ventanaFinaliza" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"><img src='images/iconos/glyphicons/glyphicons_206_ok_2.png'/> FINALIZAR <small><div style="float:right" id='textoComprobante'></div></small></h2>
      	
      </div>
      <div class="modal-body">

       <table>
	<tr  valign="top">
		<td style='padding:20px;width:30px'><img src='images/iconos/glyphicons/glyphicons_227_usd.png'/> </td>
		<td style='padding:20px'> 
			<table>
			<tr>
			<th>Efectivo</th><th>Deb.Cred</th><th>Transf.</th><th>v.</th><th>Cheque/s</th>
			</tr>
			<tr>
				<td><input onchange='cambiaImportePago()' style='width:50px' type="text" class='number' id="importePago" placeholder="$ 0.00"/> </td>
				<td><input onchange='cambiaImportePago()' style='width:50px' type="text" class='number' id="importePagoDebito" placeholder="$ 0.00"/> </td>
				<td><input onchange='cambiaImportePago()' style='width:50px' type="text" class='number' id="importePagoTransf" placeholder="$ 0.00"/> </td>
				
				<td><input onchange='cambiaImportePago()' style='width:50px' type="text" class='number' id="importePagoTransf2" placeholder="$ 0.00"/> </td>
				<td><input onchange='cambiaImportePago()' style='width:50px' type="text" class='number' id="importePagoCheques" placeholder="$ 0.00"/> </td>
				
			</tr>
			</table>
	      	<div id='labelPaga'></div>
	    </td>
	</tr>
	
	<tr  valign="top">
		<td style='padding:20px'><img src='images/iconos/glyphicons/glyphicons_121_message_empty.png'/>  </td>
		<td style='padding:20px'> 
			<div class="input-prepend input-append">
 
  <input onchange='cambiaMail()' style='width:350px' type="text" id="inputEmail" placeholder="Email"> 
   <span id='addEmail' class="add-on"></span></div>
	      	<label class="checkbox"><input id='enviaMail' type="checkbox"> Enviar por mail?</label>
	      	<label id='labelGuarda' style='visible:none' class="checkbox">
	      	<input id='guardarMail' type="checkbox"> Guardar Nuevo email?</label>
	    </td>
	</tr>
	<tr valign="top">
		<td style='padding:20px'><img style='width:100px' src='images/iconos/glyphicons/glyphicons_449_fax.png'/> </td>
		<td style='padding:20px'> 
			
	      	<label class="checkbox"><input id='imprimeCompro' type="checkbox"> Imprimir comprobante?</label>
	    </td>
	</tr>
	
</table>
				<div id='facturaSolicitudes'></div>
<img style='padding:15px; float:left' id='imgPagado' src='images/pagado.jpg'/>
<div style='padding:15px; float:right'><h1><small>TOTAL </small><span id='labelTotal'></span></h1></div>
      </div>
      <div class="modal-footer">
        <button onclick='ingresarComprobante()' type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
