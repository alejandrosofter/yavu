<h3>Items</h3>
<script>var importes=Array();</script>
<table class='table table-condensed'>
<tr id='cols'><th>Fecha</th><th>Detalle</th><th>Tipo Gasto</th><th>%</th><th>Importe</th></tr>
<?php
$total=0;
$i=0;
foreach($items as $item){
$total+=(float)$item->comprobante->importe+0;
$porc=$item->porcentajeDepto->porcentaje.'% | '.$item->porcentajeCochera->porcentaje.'%';
if($item->idTipoGasto==4)$porc=$item->propiedadesGastoLabel;
	?>
<script>importes.push(<?=$item->comprobante->importe?>)</script>
<tr id='fila_<?=$i?>'>
<td><?=Yii::app()->dateFormatter->format("MM/yy",$item->comprobante->fecha)?></td>
<td><?=$item->comprobante->detalle;?></td>
<td><?=$item->tipo->nombreTipoGasto;?></td>
<td><?=$porc;?></td>
<td>$ <?=number_format($item->comprobante->importe,2);?></td>
<td>-</td>
<input type='hidden' name='gastos[<?=$i?>]' value='<?=$item->id?>'></input>
</tr>

<?php 
$i++;
}?>
<tr><th></th><th></th><th></th><th>TOTAL</th><th>$ <?=number_format($total,2)?></th></tr>
</table>
<script>

setImporteFinal();
function quitarItem(id)
{
	var elem="#fila_"+id;
	importes.splice(id,1);
	setImporteFinal();
	$(elem).remove();
}
function setImporteFinal()
{
	var tot=0;
	for (var i=0;i<importes.length;i++)tot+=importes[i];
	
	$("#Liquidaciones_importe").val(tot.toFixed(2));
}
</script>