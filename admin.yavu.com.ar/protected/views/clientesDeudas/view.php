<?php
$this->breadcrumbs=array(
	'Clientes Deudases'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List ClientesDeudas','url'=>array('index')),
array('label'=>'Create ClientesDeudas','url'=>array('create')),
array('label'=>'Update ClientesDeudas','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete ClientesDeudas','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage ClientesDeudas','url'=>array('admin')),
);
?>

<h1>View ClientesDeudas #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'idServicio',
		'fecha',
		'fechaInicio',
		'fechaFin',
		'importe',
		'importeSaldo',
		'estado',
		'idCliente',
),
)); ?>
