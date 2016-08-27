<?php
$this->breadcrumbs=array(
	'Ventas'=>array('index'),
	'Nuevo',
);

$this->menu=array(
);
?>

<h1>Nueva Deuda</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>