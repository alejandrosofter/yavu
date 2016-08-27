<?php
$this->breadcrumbs=array(
	'Certificados Electronicos',
);

$this->menu=array(
array('label'=>'Nuevo Certificados','url'=>array('create')),
);
?>

<h1>Certificados Electronicos<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'fechaCreacion', 'header'=>'Fecha Creación'), 
array('name'=>'fechaExpira', 'header'=>'Fecha Vto.'), 
array('name'=>'estado', 'header'=>'Estado'), 
		/*
array('name'=>'estado', 'header'=>'estado'), 
		*/
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
