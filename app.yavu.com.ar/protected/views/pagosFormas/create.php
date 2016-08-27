<?php
$this->breadcrumbs=array(
	'Formas de Pago'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a PagosFormas','url'=>array('index')),
);
?>

<h1>Nueva Forma de Pago</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>