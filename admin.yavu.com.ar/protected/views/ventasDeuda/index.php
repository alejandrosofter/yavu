<?php
$this->breadcrumbs=array(
	'Ventas Deudas',
);

$this->menu=array(
array('label'=>'Nuevo VentasDeuda','url'=>array('create')),
);
?>

<h1>Deuda<small> en detalle</small></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'detalle', 'header'=>'Detalle'),
array('name'=>'fechaInicio','type'=>'html','value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->fechaVto)."</small>"', 'header'=>'Vto.'), 
array('value'=>'"$ ".number_format($data->importe,2)','name'=>'importe', 'header'=>'Importe'),
array('value'=>'"$ ".number_format($data->importeSaldo,2)','name'=>'importe', 'header'=>'Saldo'),
array('name'=>'estado', 'header'=>'estado'), 
		/*
array('name'=>'fecha', 'header'=>'fecha'), 
array('name'=>'detalle', 'header'=>'detalle'), 
		*/
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
