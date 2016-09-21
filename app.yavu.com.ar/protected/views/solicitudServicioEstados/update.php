<?php
$this->breadcrumbs=array(
	'Solicitud Servicio Estadoses'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a SolicitudServicioEstados','url'=>array('index')),
	array('label'=>'Nuevo SolicitudServicioEstados','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>