<?php
$this->breadcrumbs=array(
	'Talonarios',
);

$this->menu=array(
array('label'=>'Nuevo Talonario','url'=>array('create')),
);
?>

<h1><img src='images/iconos/glyphicons/glyphicons_072_bookmark.png'/> Talonarios<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'nombreTalonario', 'header'=>'Nombre del Talonario'), 

array('name'=>'proximo', 'header'=>'Proximo'), 
array('value'=>'$data->tipoTalonario->nombreTipoTalonario', 'header'=>'Tipo  Talonario'), 

array('value'=>'$data->esPedeterminado?"SI":"NO"', 'header'=>'Predet.'), 
		/*

array('name'=>'esPedeterminado', 'header'=>'esPedeterminado'), 
array('name'=>'esElectronico', 'header'=>'esElectronico'), 
array('name'=>'idCertificadoElectronico', 'header'=>'idCertificadoElectronico'), 
array('name'=>'idPlantilla', 'header'=>'idPlantilla'), 

		*/
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update} {delete}',


),
),
)); ?>
