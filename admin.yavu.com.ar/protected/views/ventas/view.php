<?php
$this->breadcrumbs=array(
	'Ventases'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Ventas','url'=>array('index')),
array('label'=>'Create Ventas','url'=>array('create')),
array('label'=>'Update Ventas','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Ventas','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Ventas','url'=>array('admin')),
);
?>

<h1>View Ventas #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'idCliente',
		'idServicio',
		'periodicidad',
		'importe',
		'idFormaPago',
		'estado',
		'fechaInicio',
		'cantidadMeses',
),
)); ?>
