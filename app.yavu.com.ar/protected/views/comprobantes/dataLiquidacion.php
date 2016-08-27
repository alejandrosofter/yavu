<div class='span4'>
<table>
<tr>
<td>Fecha</td>
<td><?php echo CHtml::textField('fecha',Date('Y-m-d'),array('class'=>'span2','onchange'=>'cambiaInteres()')); ?></td>

</tr>
<tr>
<td>Paga </td>
<td><?php echo CHtml::dropDownList('idEntidad',0,CHtml::listData(Entidades::model()->findAll(), 'id', 'razonSocial'),array ('onchange'=>'cambiaEntidad()','prompt'=>'seleccione...','style'=>'width:250px','class'=>'chosen')); ?></td>
</tr>
<tr>
<td>Importe</td>
<td><?php echo CHtml::textField('importe',0.00,array('class'=>'span1','onchange'=>'cambiaImporte()')); ?></td>

</tr>
<tr>
	<td>Interés/Descuentos</td>
	<td><?php echo CHtml::textField('interesDescuentos',0.00,array('class'=>'span1','onchange'=>'cambiaInteres()')); ?></td>
</tr>
<tr>
	<td>$ Usar de Crédito</td>
	<td><?php echo CHtml::textField('creditos','0',array('class'=>'span1','onchange'=>'cambiaImporteCreditos()')); ?></td>
</tr>
<tr>
	<td><h2>Total</h2></td>
	<td><h2 id='labelTotal'>0.00</h2></td>
</tr>
</table>

</div>
<div class='span3'>
<table>
	<tr>
		<td>Estado</td>
		<td><?php echo CHtml::listBox('estado','CANCELADO',ParaCobrar::model()->getEstados(),array('style'=>'height:50px')); ?></td>
	</tr>
	<tr>
		<td>Tipo de Comprobante</td>
		<td><?php echo CHtml::listBox('idTipoComprobante',$model->idTipoComprobante,CHtml::listData(ComprobantesTipos::model()->findAll(), 'id', 'nombreTipoComprobante'),array('style'=>'height:65px')); ?></td>
	</tr>
	<tr>
		<td>Talonario</td>
<td><?php echo CHtml::listBox('idTalonario',$model->idTalonario,CHtml::listData(Talonarios::model()->findAll(), 'id', 'etiqueta'),array('onchange'=>'cambiaTalonario()')); ?></td>

	</tr>
	<tr>
	<td>Nro de Comprobate</td>
	<td><?php echo CHtml::textField('nroComprobante',$model->nroComprobante,array('style'=>'font-color:green','class'=>'span1','onchange'=>'cambiaImporteInteres()')); ?></td>
</tr>
</table>
</div>
<div style='position: absolute;
 bottom: 15px;
 right: 35px;'>
	

	<h4 style='color:green'>Crédito</h4>
	<h4 style='color:green' id='labelCreditos'>0.00</h4>
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
	var imp=($('#importe').val()*1) + ($('#interesDescuentos').val()*1) -($('#creditos').val()*1);
	importeTotalCalculado=imp;
	var credito=($('#importe').val()*1)-getImporteItems();
	$('#labelTotal').html('$ '+imp.toFixed(2));
	$('#labelCreditos').html('$ '+credito.toFixed(2));
}
function cambiaImporteCreditos()
{
	if($('#creditos').val()*1 > importeCreditos){
		$('#creditos').val(importeCreditos);
		alert('No puede ingresar un valor mayor a la disponibilidad de crédito!');
	}else importeCreditos=$('#creditos').val();
	cambiaImporteTotal();
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
		alert('No ha seleccionado ningún item!');
		return false;
	}
	if($('#importe').val()<=0){
		alert('No puede ingresar un importe menor o igual a cero');
		return false;
	}
	if(importeTotalCalculado<=0){
		alert('No puede ingresar un comprobante menor o igual a cero');
		return false;
	}
	return true;

}
function cargarLiquidacion()
{
	$('#ventanaLiquidar').dialog("close");
	$.blockUI({ message: '<h3><img src="img/ajax_loader.gif" /> Espere un momento, ingresando comprobante </h3>' });
	$.getJSON( "index.php?r=liquidaciones/ingresar",{items:seleccion,credito:importeCreditos,idEntidad:$('#idEntidad').val(),importe:$('#importe').val(),interesDescuentos:$('#interesDescuentos').val(),fecha:$('#fecha').val(),nroComprobante:$('#nroComprobante').val(),estado:$('#estado').val(),idTipoComprobante:$('#idTipoComprobante').val(),idTalonario:$('#idTalonario').val()}, function( data ) {
		$.unblockUI();
		rtaIngresa(data,true);
	}).fail(function() {
		$.unblockUI();
		alert('No se puede ingresar el comprobante: 1.- es probable que no tenga conexion a internet a los servidores AFIP. 2.- Este incorrecto el certificado electronico o vencido');
	});
}
function rtaIngresa(data,imprime)
{
	if(data.id!=null){
			if(imprime)imprimir(data.id);
			else {
				alert('Agrego!');
				Location.reload();
			}
		}else{
			alert('No se puede ingresar el comprobante!');
		}
	if(data.resElectronico.FeCabResp.Resultado=='R'){
			var tex='';
			tex+=data.resElectronico.Errors.Err.Msg;
			alert(tex);
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
		alert('Debe ingresar un valor mayor que cero');
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
	buscarCreditos();
}
function buscarCreditos()
{
	$.get( "index.php?r=entidades/buscaCreditos",{idEntidad:$('#idEntidad').val()}, function( data ) {
		importeCreditos=data;
		$('#creditos').val(importeCreditos);
		cambiaImporteTotal();
	});
}
</script>