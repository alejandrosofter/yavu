<?php
$this->breadcrumbs=array(
	'Talonarios Tiposes'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a TalonariosTipos','url'=>array('index')),
);
?>

<h1>Nuevo TalonariosTipos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>