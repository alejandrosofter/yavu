<?php
$this->breadcrumbs=array(
	'Deudas de Cliente'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a Deudas','url'=>array('index')),
	array('label'=>'Nueva Deuda','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>