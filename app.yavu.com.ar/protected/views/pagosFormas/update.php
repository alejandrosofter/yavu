<?php
$this->breadcrumbs=array(
	'Pagos Formases'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a PagosFormas','url'=>array('index')),
	array('label'=>'Nuevo PagosFormas','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>