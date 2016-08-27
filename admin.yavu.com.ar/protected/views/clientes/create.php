<?php
$this->breadcrumbs=array(
	'Clientes'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a Clientes','url'=>array('index')),
);
?>

<h1>Nuevo Cliente</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>