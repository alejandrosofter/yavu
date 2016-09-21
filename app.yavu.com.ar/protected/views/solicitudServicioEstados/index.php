<?php
$this->breadcrumbs=array(
	'Solicitud Servicio Estadoses',
);

$this->menu=array(
array('label'=>'Nuevo SolicitudServicioEstados','url'=>array('create')),
);
?>

<h1>Solicitud Servicio Estadoses<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'id', 'header'=>'id'), 
array('name'=>'idSolicitudServicio', 'header'=>'idSolicitudServicio'), 
array('name'=>'idEstado', 'header'=>'idEstado'), 
array('name'=>'detalle', 'header'=>'detalle'), 
array('name'=>'fechaHora', 'header'=>'fechaHora'), 
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
