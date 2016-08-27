<?php
$this->breadcrumbs=array(
	'Servicioses'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Servicios','url'=>array('index')),
array('label'=>'Create Servicios','url'=>array('create')),
array('label'=>'Update Servicios','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Servicios','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Servicios','url'=>array('admin')),
);
?>

<h1>View Servicios #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombreServicio',
		'peridiocidad',
		'importeServicio',
),
)); ?>
