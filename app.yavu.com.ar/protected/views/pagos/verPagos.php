<table class='table table-condensed'>
<tr><th>Fecha</th><th>Forma de Pago</th><th>Importe</th><th>Saldo</th><th></th></tr>
<?php 
$saldo=$comprobante->importe;
foreach($model as $item){
$saldo-=$item->importe;
?>
<tr>
	<td><?=Yii::app()->dateFormatter->format("dd/MM/yy",$item->fecha);?></td>
	<td><?=$item->formaPago->nombreFormaPago;?></td>
	<td><?=number_format($item->importe,2);?></td>
	<td><span style="color:<?=$saldo==0?'blue':'red' ?>"?><?=number_format($saldo,2);?></td>
	<td><img style='cursor:pointer' src='images/iconos/glyphicons/glyphicons_192_circle_remove.png' onclick='quitarPago(<?=$item->id?>)'/></td>
</tr>

<?php }?>

</table>

<?php if(count($model)==0)echo "<i>No hay registro de pagos!</i>";?>
<script>
function quitarPago(id)
{
	var target='index.php?r=pagos/delete&id='+id;
	$.getJSON(target,function(data){
		console.log(data);
		refrescarSaldo(data.saldo);
      buscarPagos();
      });
}

</script>