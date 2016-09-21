<?php
$this->breadcrumbs=array(
	'Solicitudes Servicios'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a SolicitudesServicio','url'=>array('index')),
	array('label'=>'Nuevo SolicitudesServicio','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>