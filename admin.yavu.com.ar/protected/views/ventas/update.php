<?php
$this->breadcrumbs=array(
	'Ventas'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a Ventas','url'=>array('index')),
	array('label'=>'Nuevo Ventas','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>