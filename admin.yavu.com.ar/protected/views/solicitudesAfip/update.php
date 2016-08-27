<?php
$this->breadcrumbs=array(
	'Solicitudes AFIP'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a Solicitudes','url'=>array('index')),
	array('label'=>'Nueva Solicitud','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>