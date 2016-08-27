<?php
$this->breadcrumbs=array(
	'Solicitudes AFIP',
);

$this->menu=array(
array('label'=>'Nueva Solicitud','url'=>array('create')),
);
?>

<h1>Solicitudes AFIP<small> certificados electronicos</small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('type'=>'html','value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->fecha)."</small>"', 'header'=>'fecha'), 
array('value'=>'$data->cliente->nombreUsuario', 'header'=>'Cliente'), 



array('name'=>'fechaPago', 'header'=>'fechaPago'), 
array('name'=>'fechaAlta', 'header'=>'fechaAlta'), 
array('name'=>'estado', 'header'=>'estado'), 

/*
array('name'=>'observaciones', 'header'=>'observaciones'), 
array('name'=>'claveAFIP', 'header'=>'claveAFIP'), 
array('name'=>'cuitAFIP', 'header'=>'cuitAFIP'), 
		*/
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
