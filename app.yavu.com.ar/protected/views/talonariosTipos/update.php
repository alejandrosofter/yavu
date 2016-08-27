<?php
$this->breadcrumbs=array(
	'Tipo de Comprobantes'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a Tipo de Comprobantes','url'=>array('index')),
	array('label'=>'Nuevo Tipo de Comprobante','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>