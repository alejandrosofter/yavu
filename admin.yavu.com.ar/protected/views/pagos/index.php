<?php
$this->breadcrumbs=array(
	'Pagos',
);

$this->menu=array(
array('label'=>'Nuevo Pago','url'=>array('create')),
);
?>

<h1>Pagos<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'fecha', 'header'=>'Fecha'), 
array('name'=>'formaPago.nombreFormaPago', 'header'=>'Forma de Pago'), 
array('value'=>'"$ ".number_format($data->importe,2)','name'=>'importe', 'header'=>'Importe'),
array('value'=>'$data->cliente->nombreUsuario', 'header'=>'Cliente'), 
array('name'=>'idReferenciaMP', 'header'=>'REFERENCIA MP'), 
array('name'=>'estado', 'header'=>'ESTADO'), 
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
