<?php
$this->breadcrumbs=array(
	'Solicitudes Servicios'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a SolicitudesServicio','url'=>array('index')),
);
?>

<h1>Nueva Solicitud</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>