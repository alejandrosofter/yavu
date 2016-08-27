<?php
$this->breadcrumbs=array(
	'Tipo de Comprobantes',
);

$this->menu=array(
array('label'=>'Nuevo Tipo','url'=>array('create')),
);
?>

<h1>Tipo de Comprobantes<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'rowCssClassExpression' => '$data->esPredeterminado?"success":""',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'nombreTipoTalonario', 'header'=>'Tipo de Comprobantes'), 
array('name'=>'letraTalonario', 'header'=>'Letra'), 
array('value'=>'$data->proximo+1', 'header'=>'Próximo Nro'), 
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{predeterminar} {update} {delete}',
		'buttons'=>array(
				'predeterminar' => array(
                'label'=>'Predeterminar',
                'imageUrl'=>'images/iconos/glyphicons/glyphicons_337_pin_flag2.png',
                'url' => '"index.php?r=talonariosTipos/predeterminar&id=".$data->id',
                'visible'=>'!$data->esPredeterminado',
            )),


),
),
)); ?>
