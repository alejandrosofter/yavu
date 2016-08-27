<h1>DETALLE DE <small>IMPORTE</small></h1>
<table class='table table-condensed'>
<tr><th>FECHA</th><th>COMPROBANTE</th><th>ENTIDAD</th><th>IMPORTE</th></tr>
<?php foreach($items as $item){
$comprobante=Comprobantes::model()->findByPk($item['idComprobante']);
	?>
<tr>
	<td><?=Yii::app()->dateFormatter->format("dd/MM/yy",$item['fecha'])?></th>
	<td><a href="index.php?r=comprobantes/descargaPdf&id=<?=$item['idComprobante']?>" target="_blank" ><?=$comprobante->nroComprobante?></a></td>
	<td><?=$comprobante->entidad->razonSocial?></td>
	<td>$ <?=number_format($item['importe'],2)?></td>
</tr>
<?php }?>
</table>