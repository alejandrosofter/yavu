<?php
$this->breadcrumbs=array(
	'Solicitud Servicio Estadoses'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List SolicitudServicioEstados','url'=>array('index')),
array('label'=>'Create SolicitudServicioEstados','url'=>array('create')),
array('label'=>'Update SolicitudServicioEstados','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete SolicitudServicioEstados','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage SolicitudServicioEstados','url'=>array('admin')),
);
?>

<h1>View SolicitudServicioEstados #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'idSolicitudServicio',
		'idEstado',
		'detalle',
		'fechaHora',
),
)); ?>
