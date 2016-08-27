<?php
$this->breadcrumbs=array(
	'Ventas Deudas'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a VentasDeuda','url'=>array('index')),
	array('label'=>'Nuevo VentasDeuda','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>