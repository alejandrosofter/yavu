<?php
$this->breadcrumbs=array(
	'Servicios'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a Servicios','url'=>array('index')),
);
?>

<h1>Nuevo Servicio</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>