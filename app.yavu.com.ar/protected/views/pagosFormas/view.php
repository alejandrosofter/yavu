<?php
$this->breadcrumbs=array(
	'Pagos Formases'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List PagosFormas','url'=>array('index')),
array('label'=>'Create PagosFormas','url'=>array('create')),
array('label'=>'Update PagosFormas','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PagosFormas','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PagosFormas','url'=>array('admin')),
);
?>

<h1>View PagosFormas #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombreFormaPago',
),
)); ?>
