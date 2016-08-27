<?php
$this->breadcrumbs=array(
	'Servicios'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a Servicios','url'=>array('index')),
	array('label'=>'Nuevo Servicios','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>