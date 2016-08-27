<?php
$this->breadcrumbs=array(
	'Ventas Deudas'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List VentasDeuda','url'=>array('index')),
array('label'=>'Create VentasDeuda','url'=>array('create')),
array('label'=>'Update VentasDeuda','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete VentasDeuda','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage VentasDeuda','url'=>array('admin')),
);
?>

<h1>View VentasDeuda #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'idVenta',
		'fechaVto',
		'importe',
		'importeSaldo',
		'estado',
		'fecha',
		'detalle',
),
)); ?>
