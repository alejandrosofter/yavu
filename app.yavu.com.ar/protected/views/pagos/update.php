<?php
$this->breadcrumbs=array(
	'Pagos'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a Pagos','url'=>array('index')),
	array('label'=>'Nuevo Pago','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>