<?php
$this->breadcrumbs=array(
	'Mails',
);

$this->menu=array(
array('label'=>'Nuevo Mail','url'=>array('create')),
);
?>

<h1><img src='images/iconos/glyphicons/glyphicons_121_message_empty.png'/> Mails<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'receptor', 'header'=>'receptor'), 
array('type'=>'html','value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->fecha)."</small>"', 'header'=>'Fecha'), 
array('name'=>'estado', 'header'=>'estado'), 
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
