<?php
$this->breadcrumbs=array(
	'Mails'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a Mail','url'=>array('index')),
	array('label'=>'Nuevo Mail','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>