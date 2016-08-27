<?php
$this->breadcrumbs=array(
	'Deudas'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a Deudas','url'=>array('index')),
);
?>

<h1>Nueva Deuda</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>