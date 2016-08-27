<?php
$this->breadcrumbs=array(
	'Certificados Electronicoses'=>array('index'),
	'Nuevo',
);

$this->menu=array(
array('label'=>'Ir a CertificadosElectronicos','url'=>array('index')),
);
?>

<h1>Nuevo CertificadosElectronicos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>