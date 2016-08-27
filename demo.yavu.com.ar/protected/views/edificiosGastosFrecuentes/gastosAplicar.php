<table class='table table-condensed'>
<tr><th>Tipo Gasto</th><th>Entidad</th><th>Tipo Comprobante</th><th>Estado Pago</th><th>Nro Comp.</th><th>Detalle</th><th>Importe</th></tr>
<?php
$total=0;
$i=0;
foreach($items as $item){
$total+=(float)$item->importe+0;
	?>
<tr><td><?=$item->tipoGasto->nombreTipoGasto?></td>
<td><?=$item->entidad->razonSocial;?></td>
<td><?=$item->tipoComprobante->nombreTipoComprobante;?></td>
<td><?php echo CHtml::dropDownList('gastos['.$i.'][estado]',0,Comprobantes::model()->getEstados(),array ('style'=>'width:150px')); ?></td>
<td><input type='text' class='span1' value='' name='gastos[<?=$i?>][nroComprobante]'></input></td>
<td><input type='text' class='span4' value='<?=$item->detalle;?>' name='gastos[<?=$i?>][detalle]'></input></td>
<td>$ <input type='text' class='span1' value='<?=$item->importe;?>' name='gastos[<?=$i?>][importe]'></input></td></tr>
<input type='hidden' name='gastos[<?=$i?>][idGasto]' value='<?=$item->id?>'</input>
<?php 
$i++;
}?>
</table>
<script>

</script>