<?php
$this->breadcrumbs=array(
	'Talonarios Tiposes'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List TalonariosTipos','url'=>array('index')),
array('label'=>'Create TalonariosTipos','url'=>array('create')),
array('label'=>'Update TalonariosTipos','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete TalonariosTipos','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage TalonariosTipos','url'=>array('admin')),
);
?>

<h1>View TalonariosTipos #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombreTipoTalonario',
		'tipoOperacion',
		'letraTalonario',
		'tipoElectronico',
),
)); ?>
