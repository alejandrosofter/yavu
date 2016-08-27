<?php
$this->breadcrumbs=array(
	'Mails',
);
$this->menu=array(
	array('label'=>'Nuevo Mail', 'url'=>array('create')),
);
?>

<header id="page-header">
<h1 id="page-title">Administración Mails</h1>
</header>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'mail-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		'id',
		'emisor',
		'receptor',
		'fecha',
		'estado',
		array(
			'class'=>'CButtonColumn','template'=>'{view}'
		),
	),
)); ?>
