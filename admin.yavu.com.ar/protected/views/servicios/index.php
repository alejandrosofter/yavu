<?php
$this->breadcrumbs=array(
	'Servicios',
);

$this->menu=array(
array('label'=>'Nuevo Servicios','url'=>array('create')),
);
?>

<h1>Servicios<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array( 
array('name'=>'nombreServicio', 'header'=>'Nombre'), 
array('value'=>'"$ ".number_format($data->importeServicio,2)','name'=>'importeServicio', 'header'=>'Importe'), 
array('name'=>'duracion', 'header'=>'Duración'), 
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
