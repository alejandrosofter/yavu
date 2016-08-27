<?php
$this->breadcrumbs=array(
	'Solicitudes AFIP'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a Solicitudes','url'=>array('index')),
);
?>

<h1>Nueva Solicitud</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>