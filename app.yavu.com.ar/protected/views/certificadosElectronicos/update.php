<?php
$this->breadcrumbs=array(
	'Certificados Electronicoses'=>array('index'),
	'Actualizar',
);

	$this->menu=array(
	array('label'=>'Ir a CertificadosElectronicos','url'=>array('index')),
	array('label'=>'Nuevo CertificadosElectronicos','url'=>array('create'))
	);
	?>

	<h1>Actualizar</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>