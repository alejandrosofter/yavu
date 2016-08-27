<?php
$this->breadcrumbs=array(
	'Solicitudes Afips'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List SolicitudesAfip','url'=>array('index')),
array('label'=>'Create SolicitudesAfip','url'=>array('create')),
array('label'=>'Update SolicitudesAfip','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete SolicitudesAfip','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage SolicitudesAfip','url'=>array('admin')),
);
?>

<h1>View SolicitudesAfip #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'fecha',
		'idCliente',
		'claveAFIP',
		'cuitAFIP',
		'estado',
		'fechaPago',
		'fechaAlta',
		'observaciones',
),
)); ?>
