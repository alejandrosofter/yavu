<?php
$this->breadcrumbs=array(
	'Gastos',
);

$this->menu=array(
array('label'=>'Nuevo Gasto','url'=>array('create')),
);
?>
id ed<?=Yii::app()->session['idEdificio']?>
<h1><img src='images/iconos/glyphicons/glyphicons_135_inbox_out.png'/> Gastos<small> liquidación expensas</small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('type'=>'html','value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->comprobante->fecha)."</small>"','header'=>'Fecha'),
array('value'=>'$data->edificio->nombreEdificio', 'header'=>'Edificio'), 
array('value'=>'$data->comprobante->detalle', 'header'=>'Detalle del Gasto'),
array('value'=>'$data->tipo->nombreTipoGasto', 'header'=>'Tipo de Gasto'), 
array('value'=>'$data->esFondoReserva?"SI":"NO"', 'header'=>'Fondo de Reserva?'), 
array('type'=>'html','value'=>'"<small style=\"color:".($data->estado=="PENDIENTE"?"red":"green")."\" >".$data->estado."</small>"', 'header'=>'Estado'), 

array('type'=>'html','value'=>'"<strong> $ ".number_format($data->comprobante->importe,2)."</strong>"', 'header'=>'Importe'), 
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
