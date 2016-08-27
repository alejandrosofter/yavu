<?php
$this->breadcrumbs=array(
	'Deudas de Cliente',
);

$this->menu=array(
array('label'=>'Nueva Deuda','url'=>array('create')),
);
?>

<h1>Deudas<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'id', 'header'=>'id'), 
array('value'=>'$data->cliente->nombreUsuario', 'header'=>'Cliente'), 
array('value'=>'$data->servicio->nombreServicio', 'header'=>'Servicio'), 
array('type'=>'html', 'value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->fecha)."</small>"', 'header'=>'fecha'), 
array('type'=>'html','value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->fechaInicio)."</small>"', 'header'=>'Fecha Inicio'), 
array('type'=>'html','value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->fechaFin)."</small>"', 'header'=>'Fecha Fin'), 
array('name'=>'importe', 'header'=>'importe'), 

array('name'=>'estado', 'header'=>'estado'), 

	
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
