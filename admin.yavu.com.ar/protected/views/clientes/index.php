<?php
$this->breadcrumbs=array(
	'Clientes',
);

$this->menu=array(
array('label'=>'Nuevo Cliente','url'=>array('create')),
);
?>

<h1>Clientes<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
	array('name'=>'versionYavu', 'header'=>'Version'), 

array('name'=>'recomendado', 'header'=>'Recomendado'), 
array('name'=>'nombreUsuario', 'header'=>'USUARIO'), 
array('name'=>'email', 'header'=>'Email'), 
array('name'=>'estado', 'header'=>'ESTADO'), 
array('value'=>'Yii::app()->dateFormatter->format("dd/MM/yy",$data->fechaVto)', 'header'=>'VTO.'), 
array('name'=>'importeSaldo', 'header'=>'Saldo'), 
		/*

array('name'=>'claveAcceso', 'header'=>'claveAcceso'), 

		*/
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete} ',
		'buttons'=>array(
            'saldo' => array(
                'label'=>'Cambiar Saldo',
                'imageUrl'=>'images/iconos/glyphicons/glyphicons_037_coins.png',
                'options'=>array('class'=>'imprime','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=clientes/cambiaSaldo&id=".$data->id',
            ),
			),


),
),
)); 
?>
