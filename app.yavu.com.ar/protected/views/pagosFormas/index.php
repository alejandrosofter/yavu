<?php
$this->breadcrumbs=array(
	'Forma de Pagos',
);

$this->menu=array(
array('label'=>'Nueva Forma de Pago','url'=>array('create')),
);
?>

<h1>Formas de Pago<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'nombreFormaPago', 'header'=>'Forma de Pago'), 
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
