<?php
$this->breadcrumbs=array(
	'Solicitudes Servicios'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List SolicitudesServicio','url'=>array('index')),
array('label'=>'Create SolicitudesServicio','url'=>array('create')),
array('label'=>'Update SolicitudesServicio','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete SolicitudesServicio','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage SolicitudesServicio','url'=>array('admin')),
);
?>

<h1>View SolicitudesServicio #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'fechaHora',
		'idCliente',
		'requerimiento',
		'idEstado',
		'esUrgencia',
),
)); ?>
