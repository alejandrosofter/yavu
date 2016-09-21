<?php
$this->breadcrumbs=array(
	'Solicitud Servicio Estadoses'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a SolicitudServicioEstados','url'=>array('index')),
);
?>

<h1>Nuevo SolicitudServicioEstados</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>