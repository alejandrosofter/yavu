<?php
$this->breadcrumbs=array(
	'Ventas'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a Ventas','url'=>array('index')),
);
?>

<h1>Nueva Venta</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>