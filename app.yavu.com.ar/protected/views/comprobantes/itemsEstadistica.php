<h1>DETALLE DE <small>IMPORTE</small></h1>
<table class='table table-condensed'>
<tr><th>NRO</th><th>FECHA</th><th>CLIENTE</th><th>TIPO COMP.</th><th>IMPORTE</th><th>PAGADO</th></tr>
<?php foreach($items as $item){
$entidad=Entidades::model()->findByPk($item['idEntidad']);
$tal=TalonariosTipos::model()->findByPk($item['idTipoComprobante']);
$model=Comprobantes::model()->findByPk($item['id']);
	?>
<tr>
<td><a href="index.php?r=comprobantes/descargaPdf&id=<?=$item['id']?>" target="_blank" ><?=$item['nroComprobante']?></a></td>
	<td><?=Yii::app()->dateFormatter->format("dd/MM/yy",$item['fecha'])?></th>
	<td><?=$entidad->razonSocial?></td>
	<td><?=$tal->letraTalonario?></td>
	<td>$ <?=number_format($item['importe'],2)?></td>
	<td>$ <?=number_format($model->getImportePagado(),2)?></td>
</tr>
<?php }?>
</table>
<script>

</script>