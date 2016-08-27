<table class='table table-condensed'>
<tr id='cols'><th>Vto.</th><th>Entidad</th><th>Propiedad</th><th>Detalle</th><th>Interes</th><th style="width:110px">Saldo</th></tr>
<script>
	datos=Array();
</script>
<?php
$total=0;
$i=0;

foreach($res as $item){
$total+=(float)$item->importeSaldo;
$vencido=$item->fechaVencimiento<Date("Y-m-d");
$pos=strpos($item->punitorio,'%');
$importe=str_replace('%','',$item->punitorio);
$importe=$importe==""?0:$importe;
$interes=$pos===true?(($importe/100)*$item->importeSaldo):$item->punitorio;
$dias=$item->getDiasVence()<0?-$item->getDiasVence():1;
$interes=($vencido?$interes:0)*$dias;
//$interes=$dias;
$color=$vencido?"text-error":"text-success";
?>

<script>datos.push({id:<?=$item->id?>,saldo:<?=$item->importeSaldo?>,interes:<?=$interes?>,detalle:"<?=$item->detalle?>",entidad:"<?=$item->entidad->razonSocial?>",propiedad:"<?=$item->propiedad->nombrePropiedad?>"})</script>
<tr  title='Fecha de la Deuda <?=Yii::app()->dateFormatter->format("dd/MM/yyyy",$item->fecha)?>' id='fila_<?=$i?>'>
<td><small><small class='<?=$color?>'><?=Yii::app()->dateFormatter->format("dd/MM/yyyy",$item->fechaVencimiento);?></small></small></td>
<td><small><?=$item->entidad->razonSocial;?></small></td>

<td><?=$item->propiedad->nombrePropiedad;?></td>
<td ><small><?=$item->detalle;?></small></td>
<td style='width:80px'>$ <?=number_format($interes,2);?></td>
<td style='width:70px'>$ <?=number_format($item->importeSaldo,2);?></td>
<td style='width:30px'>
	<img onclick='clickFila(<?=$i?>,<?=$item->id?>)' style='cursor:pointer' src='images/iconos/glyphicons/glyphicons_151_new_window.png'/>
</td>
</tr>

<?php
$i++;
}?>

</table>


<script>

function clickFila(id,idParaCobrar)
{
	var elem="#fila_"+id;
	$(elem).css( "background-color",'#ccc');
	importeCredito=0;
	agregar(idParaCobrar,undefined,datos[id].interes);

}
function agregaQuitaArray(elem,id,idParaCobrar)
{
	if($(elem).css( "background-color")=='transparent' || $(elem).css( "background-color")=="rgba(0, 0, 0, 0)")
		quitar(idParaCobrar);
		else agregar(id)
}

function agregar(idParaCobrar,importe,interes)
{
	if(estaDentro(idParaCobrar)){
		swal({   title: "Opss..",  text:  "Ya has ingresado ese item!",  html: true,  type: "error"});
		return;
	}
	$('#labCredito').html('');
	
	$.getJSON( "index.php?r=paraCobrar/getParaCobrar",{id:idParaCobrar}, function( data ) {
		var imp=(importe!=undefined)?importe:data.data.importeSaldo;
		importe=(importe*1).toFixed(2);
		seleccion.push({id:idParaCobrar,saldo:imp*1,importe:imp*1,interes:interes*1,detalle:data.data.detalle,entidad:data.entidad.razonSocial,propiedad:data.propiedad.nombrePropiedad});
		mostrarInfo();
	});
	
		
	
}
function estaDentro(id)
{
	for(var i=0;i<seleccion.length;i++)
		if(seleccion[i].id==id)return true;
	return false;
}
function quitar(idParaCobrar)
{
	seleccion.splice(buscarId(idParaCobrar),1);
	$('#labCredito').html('');
}
function mostrarInfo(retocaImporte)
{
	var saldoFinal=0;
	var interesFinal=0;
	var totalFinal=0;
	for(var i=0;i<seleccion.length;i++){
		saldoFinal+=(seleccion[i].saldo)*1;
		interesFinal+=(seleccion[i].interes)*1;
	}

	totalFinal+=(saldoFinal)+interesFinal;
	if(retocaImporte==undefined){
		$('#importe').val(totalFinal.toFixed(2));
		$('#interesDescuentos').val(interesFinal.toFixed(2));
	}
  	$('#labInteres').html('Interés $ '+interesFinal.toFixed(2));
  	$('#labSubTotal').html('SUB-TOTAL $ '+saldoFinal.toFixed(2));
  	$('#labTotal').html('TOTAL $ '+totalFinal.toFixed(2));
  	if(importeCredito>0)$('#labCredito').html('Crédito $ '+importeCredito);else $('#labCredito').html('');
  	mostrarItems();
}
function getImporteCreditoFavor()
{
	if(datosCreditos.length>0)return importeCredito;
	return 0;
}
function buscarId(idParaCobrar)
{
	for(var i=0;i<seleccion.length;i++)
		if(seleccion[i].id==idParaCobrar)return i;
  return null;
}
function getElemento(idParaCobrar)
{
	var dat=null;
	$.getJSON( "index.php?r=paraCobrar/getParaCobrar",{id:idParaCobrar}, function( data ) {

		dat= data;
	return dat;
	});
	console.log(dat);
	return dat;
}
function switchColor(elem,color)
{
	if($(elem).css( "background-color")=='transparent' || $(elem).css( "background-color")=="rgba(0, 0, 0, 0)")
		$(elem).css( "background-color",color);
		else $(elem).css( "background-color",'transparent');
}
</script>