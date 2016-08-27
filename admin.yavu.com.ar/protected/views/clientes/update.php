<?php
$this->breadcrumbs=array(
	'Clientes'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a Clientes','url'=>array('index')),
	array('label'=>'Nuevo Clientes','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>