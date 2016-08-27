<?php
$this->breadcrumbs=array(
	'Ventas',
);

$this->menu=array(
array('label'=>'Nueva Venta','url'=>array('create')),
);
?>

<h1>Ventas<small> </small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}',
'type'=>'condensed',
 'rowCssClassExpression'=>'$data->getColor()',
'dataProvider'=>$dataProvider->search(),
'columns'=>array(
array('name'=>'fechaInicio','type'=>'html','value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->fechaInicio)."</small>"', 'header'=>'Inicio'), 
array('value'=>'$data->nombreCliente', 'header'=>'Cliente'), 
array('type'=>'html','value'=>'"<b>".$data->servicio->nombreServicio."</b>"', 'header'=>'Servicio'), 

array('value'=>'$data->proximaFacturacion." día/s"', 'header'=>'Prox. Facturacion'), 
array('value'=>'"$ ".number_format($data->importe,2)','name'=>'importe', 'header'=>'Importe'),
array('name'=>'est.nombreEstado', 'header'=>'Estado'), 

//array('type'=>'html','value'=>'"<a href=\"http://".$data->nombreDominio.".yavu.com.ar \" target=\"_blank\">".$data->nombreDominio.".yavu.com.ar</a>"', 'header'=>'Dominio'), 
		/*
array('name'=>'estado', 'header'=>'estado'), 
array('name'=>'fechaInicio', 'header'=>'fechaInicio'), 
array('name'=>'cantidadMeses', 'header'=>'cantidadMeses'), 
		*/
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{deuda}  {update} {delete} ',
		'buttons'=>array(
            'deuda' => array(
                'label'=>'deuda',
                'imageUrl'=>'images/iconos/glyphicons/glyphicons_037_coins.png',
                'options'=>array('class'=>'imprime','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=ventasDeuda/index&id=".$data->id',
            ),
				 'activar' => array(
                'label'=>'activar',
                'imageUrl'=>'images/iconos/glyphicons/glyphicons_198_ok.png',
                'options'=>array('class'=>'imprime','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=ventas/activar&id=".$data->id',
                'visible'=>'$data->estado==2',
            ),'desactivar' => array(
                'label'=>'desactivar',
                'imageUrl'=>'images/iconos/glyphicons/glyphicons_199_ban.png',
                'options'=>array('class'=>'imprime','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=ventas/desactivar&id=".$data->id',
                'visible'=>'$data->estado==1',
            ),
            'generar' => array(
                'label'=>'Generar',
                'imageUrl'=>'images/iconos/glyphicons/glyphicons_063_power.png',
                'options'=>array('class'=>'imprime','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=ventas/generar&id=".$data->id',
            ),
				  'actualizar' => array(
                'label'=>'Actualizar',
                'imageUrl'=>'images/iconos/glyphicons/glyphicons_082_roundabout.png',
                'options'=>array('class'=>'imprime','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=ventas/actualizar&id=".$data->id',
            ),
			),


),
),
)); 

?>

<script>
consultar();
function consultar()
{

}
</script>