<div class='span3'>
<table class=''>
<tr>
<td>Fecha</td>
<td><?php echo CHtml::textField('fecha',Date('d-m-Y'),array('style'=>'width:70px','onchange'=>'cambiaInteres()')); ?></td>

</tr>
<tr>
<td><b>Quien Paga...</b> </td>
<td><?php echo CHtml::dropDownList('idEntidad',0,CHtml::listData(Entidades::model()->findAll(), 'id', 'razonSocial'),array ('onchange'=>'cambiaEntidad()','prompt'=>'seleccione...','style'=>'width:250px','class'=>'chosen')); ?></td>
</tr>

<tr>
<td>Talonario </td>
<td><?php echo CHtml::dropDownList('idTalonario',$model->idTalonario,CHtml::listData(Talonarios::model()->findAll(), 'id', 'etiqueta'),array ('onchange'=>'cambiaTalonario()','prompt'=>'seleccione...','style'=>'width:250px','class'=>'chosen')); ?></td>
</tr>
<tr>
	<td>Nro de Comprobate</td>
	<td><?php echo CHtml::textField('nroComprobante',$model->nroComprobante,array('style'=>'font-color:green','class'=>'span1','onchange'=>'cambiaImporteInteres()')); ?></td>
</tr>
<tr>

</table>

</div>
<div style='float:right' class='span3'>
<table class='table table-condensed'>
<tr>
<td>Importe</td>
<td><?php echo CHtml::textField('importe',0.00,array('class'=>'span1','style'=>'text-align:right ;float:right','onchange'=>'cambiaImporte()')); ?></td>

</tr>
<tr>
	<td>Interés</td>
	<td><?php echo CHtml::textField('interes',0.00,array('class'=>'span1','style'=>'text-align:right ;float:right','onchange'=>'cambiaInteres()')); ?></td>
</tr>
<tr>
	<td>Bonificación</td>
	<td><?php echo CHtml::textField('bonificacion',0.00,array('class'=>'span1','style'=>'text-align:right ;float:right','onchange'=>'cambiaInteres()')); ?></td>
</tr>
<tr>

	<td><h4>Total</h4></td>
	<td><span style='float:right' id='labelTotal'>0.00</span></td>
</tr>
<td><b><big style='color:green'>$ Pago</big> </b></td>
<td><?php echo CHtml::textField('importePaga',0,array ('onchange'=>'cambiaImportePaga()','class'=>'span1','style'=>'text-align:right ;float:right')); ?></td>
</tr>
<tr>
<td><b><big style='color:green'>$ Usa Crédito</big> </b></td>
<td><?php echo CHtml::textField('importeCredito',0,array ('onchange'=>'cambiaImporteCredito()','class'=>'span1','style'=>'text-align:right ;float:right')); ?></td>
</tr>

<tr>

	<td><span style='color:green'>Total a PAGAR</span></td>
	<td><span style='color:green;float:right' id='labelTotalPagar'>0.00</span></td>
</tr>
<tr>

	<td><span style='color:green;' id='labelEstadoLabel'></td>
	<td><span style='color:green;' id='labelEstado'></span></td>
</tr>
</table>
</div>

<script>
var datos=Array(); var seleccion=Array();
var importeCreditos=0;
var importeTotalCalculado=0;
function cambiaInteres()
{
cambiaImporte();
cambiaImporteTotal();

}
function cambiaImporteTotal()
{
	cambiaPago = typeof cambiaPago == 'undefined' ? true : false;
	var imp=($('#importe').val()*1) + ($('#interes').val()*1) - ($('#bonificacion').val()*1) ;
	importeTotalCalculado=imp;
	var creditos=$('#importeCredito').val()*1 ;
	var importePaga=imp;
	$('#importePaga').val(importePaga);
	$('#labelTotalPagar').html("$ "+(importePaga-creditos).toFixed(2));
	$('#labelTotal').html('$ '+imp.toFixed(2));
	muestraEstadoPago();
}
function cambiaImporteCredito()
{
	if($('#importeCredito').val()*1 > importeCreditos){
		$('#importeCredito').val(importeCreditos);
		swal({   title: "Opss..",  text: 'No puede ingresar un valor mayor a la disponibilidad de crédito!',html: true,  type: "error"});
	}else importeCreditos=$('#creditos').val();
	cambiaImporteTotal();
}
function cambiaImportePaga()
{
	var creditos=$('#importeCredito').val()*1 ;
	var importePaga=$('#importePaga').val()*1;
	$('#labelTotalPagar').html("$ "+(importePaga-creditos).toFixed(2));
	muestraEstadoPago();
}
function muestraEstadoPago()
{
	var creditos=$('#importeCredito').val()*1 ;
	var importePaga=$('#importePaga').val()*1;
	var importePagar=$('#importe').val()*1;
	var interes=$('#interes').val()*1;
	var bonificacion=$('#bonificacion').val()*1;

	var diferencia=importePagar+interes-bonificacion-importePaga-creditos;
	var label=diferencia>0?"<big><b>PENDIENTE</b></big>":"<big><b>A FAVOR</b></big>";
	var color=diferencia>0?"red":"green";
	$('#labelEstado').html((diferencia<0?-diferencia:diferencia).toFixed(2));
	$('#labelEstadoLabel').html(label);
	$('#labelEstadoLabel').attr('style','color:'+color);
	$('#labelEstado').attr('style','color:'+color);
	if(diferencia==0){
		$('#labelEstadoLabel').html('');
		$('#labelEstado').html('<big><b>PAGADO!</b></big>');
	}
}
function cambiaImporte()
{
	var saldo=$('#importe').val()+0;
	//resetSeleccion();
	cambiaImporteTotal();
	//agregarSaldo();

}
function cambiaTalonario()
{
	$.get( "index.php?r=talonarios/getProximoNro",{idTalonario:$('#idTalonario').val()}, function( data ) {
	$('#nroComprobante').val(data);
	});
}
function liquidar()
{
	if(datosOk())cargarLiquidacion();
}
function datosOk()
{
	if(seleccion.length==0){
		swal({   title: "Opss..",  text:'No ha seleccionado ningún item!',html: true,  type: "error"});
		return false;
	}
	if($('#importe').val()<=0){
		swal({   title: "Opss..",  text: 'No puede ingresar un importe menor o igual a cero',html: true,  type: "error"});
		return false;
	}
	if(importeTotalCalculado<=0){
		swal({   title: "Opss..",  text: 'No puede ingresar un comprobante menor o igual a cero',html: true,  type: "error"});
		return false;
	}
	return true;

}
function cargarLiquidacion()
{
	$('#ventanaLiquidar').dialog("close");
	$.blockUI({ message: '<h3><img src="img/ajax_loader.gif" /> Espere un momento, ingresando comprobante </h3>' });
	$.getJSON( "index.php?r=liquidaciones/ingresar",{items:seleccion,credito:$('#importeCredito').val(),idEntidad:$('#idEntidad').val(),importe:$('#importe').val(),importePaga:$('#importePaga').val(),interes:$('#interes').val(),bonificacion:$('#bonificacion').val(),fecha:$('#fecha').val(),nroComprobante:$('#nroComprobante').val(),estado:"PENDIENTE",idTipoComprobante:1,idTalonario:$('#idTalonario').val()}, function( data ) {
		$.unblockUI();
		rtaIngresa(data,true);
	}).fail(function() {
		$.unblockUI();
		swal({   title: "Opss..",  text: 'Hay un error al ingresar el comprobante, consultar con el administrador del sistema',html: true,  type: "error"});
	});
}
function rtaIngresa(data,imprime)
{
	if(data.id!=null){
			if(imprime)imprimir(data.id);
			else {
				swal({   title: "Bien!",  text: 'Item Agregado!',html: true,  type: "success"});
				Location.reload();
			}
		}else{
			swal({   title: "Opss..",  text: 'No se puede ingresar el comprobante!',html: true,  type: "error"});
		}
	if(data.resElectronico.FeCabResp.Resultado=='R'){
			var tex='';
			tex+=data.resElectronico.Errors.Err.Msg;
			swal({   title: "Opss..",  text: tex,html: true,  type: "error"});
		}
		
}
function imprimir(id)
{
	$('#btnImprime').attr('href','index.php?r=comprobantes/imprimir&id='+id);
	  $("#btnImprime").trigger('click');
}
var importeCredito=0;
function getImporteItems()
{
	var total=0;
	for(var i=0;i<seleccion.length;i++)
		total+=seleccion[i].saldo;
	return total;
}
function agregarSaldo()
{
	var saldoImporte=$('#importe').val();
	if(saldoImporte<=0 || saldoImporte==''){
		swal({   title: "Opss..",  text: 'Debe ingresar un valor mayor a cero',html: true,  type: "error"});
		$('#importe').val(0);
		return;
	};
	for(var i=0;i<datos.length;i++){
		var resto=saldoImporte-(datos[i].saldo*1).toFixed(2)-(datos[i].interes*1).toFixed(2);
		var importeItem=resto>0?datos[i].saldo:saldoImporte;
		resto=resto.toFixed(2);
		if(resto>=0){
			agregar(i,importeItem);
			switchColor('#fila_'+i,'#00DD3B');
		}else{
			
			importeItem=importeItem*1;
			agregar(i,importeItem.toFixed(2),0);
			switchColor('#fila_'+i,'orange');
		}
		if(resto<0)break;
		saldoImporte=resto;
	}
	if(resto>0){
		importeCredito=resto;
	}
	else{
		importeCredito=0;
	}
	
	mostrarInfo(true);
}
function resetSeleccion()
{
	for(var i=0;i<=seleccion.length;i++){
		var elem="#fila_"+i;
		$(elem).css( "background-color",'transparent');
	}
	seleccion.splice(0,i);
}
function cambiaEntidad()
{
	buscarCreditos($('#idEntidad').val());
}
function buscarCreditos(idEntidadInquilino)
{
	$.get( "index.php?r=entidades/buscaCreditos",{idEntidad:idEntidadInquilino}, function( data ) {
		importeCreditos=data;
		$('#importeCredito').val(importeCreditos);
		cambiaImporteTotal();
	});
}
</script>