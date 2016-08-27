<?php
$this->breadcrumbs=array(
	'Mails'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a Mail','url'=>array('index')),
);
?>

<h1>Nuevo Mail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>