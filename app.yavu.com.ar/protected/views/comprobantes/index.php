<?php
$this->breadcrumbs=array(
	'Comprobantes',
);

$this->menu=array(
array('label'=>'Nuevo Comprobante','url'=>array('create')),
);

?>


<h1><img src='images/iconos/glyphicons/glyphicons_150_edit.png'/> Comprobantes<small> de entrada y salida</small>
<div style="float:right"><?php $this->renderPartial('_search',array('model'=>$dataProvider));?> 
</div></h1>
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
'template'=>'{items} {pager}','id'=>'tablaComprobantes',
'type'=>'condensed',

'dataProvider'=>$dataProvider->search(),
'rowCssClassExpression' => '"fila_{$data->id}"',

'columns'=>array(

    array('name'=>'nroComprobante','value'=>'$data->nroComprobante==""?"-":$data->nroComprobante', 'header'=>'Nro Comp.'), 
array('type'=>'html','value'=>'"<small>".Yii::app()->dateFormatter->format("dd/MM/yy",$data->fecha)."</small>"', 'header'=>'Fecha'), 
array('value'=>'$data->entidad->razonSocial', 'header'=>'Entidad'), 
array('type'=>"html",'value'=>'$data->esElectronica?"<a data-fancybox-type=\'iframe\' class=\'imprime\'  href=\'index.php?r=comprobantes/comprobar&id=".$data->id."\'><img src=\'images/online.jpg\'/> </a>":"<img src=\'images/offline.jpg\'/"', 'header'=>'Electronico...'), 
array('value'=>'$data->tipo->nombreTipoTalonario', 'header'=>'Tipo'), 
array('type'=>'html','value'=>'"<small><strong style=\"color:".($data->estado=="ACTIVA"?"green":"red")."\">".$data->estado."</strong></small>"', 'header'=>'Estado'), 

array('type'=>'html','id' => 'columnaPagos','value'=>'"<strong > $ ".number_format($data->importe+$data->interesDescuento-$data->importeFavor,2)."</strong>"', 'header'=>'Importe'), 
array('type'=>'html','value'=>'"<small><strong style=\"color:".($data->getSaldo()==0?"blue":"red")."\"> $ ".number_format($data->getSaldo(),2)."</strong></small>"', 'header'=>'Saldo'), 

		/*
array('name'=>'nroComprobante', 'header'=>'nroComprobante'), 
array('name'=>'idTipoComprobante', 'header'=>'idTipoComprobante'), 
array('name'=>'interesDescuento', 'header'=>'interesDescuento'), 
array('name'=>'idTalonario', 'header'=>'idTalonario'), 
		*/
array(
'htmlOptions' => array('nowrap'=>'nowrap'),
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{pagos}  {enviaMail} {imprimir} {activar} {delete}',
		'buttons'=>array(
				 'imprimir' => array(
                'label'=>'Imprimir',
                'imageUrl'=>'images/iconos/glyphicons/imprimir.png',
                'options'=>array('class'=>'imprime','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=comprobantes/descargaPdf&id=".$data->id',
                'visible'=>'$data->idTalonario!=null',
            ),
                 'pagos2' => array(
                'label'=>'Pagos',
                'imageUrl'=>'images/iconos/glyphicons/money.png',
                //'options'=>array('class'=>'imprime','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=pagos/index&id=".$data->id',
            ),
				 'enviaMail' => array(
                'label'=>'Envia Mail',
                'imageUrl'=>'images/iconos/glyphicons/glyphicons_123_message_out.png',
                'options'=>array('class'=>'chico','data-fancybox-type'=>'iframe'),
                'url' => '"index.php?r=comprobantes/enviaEmailComprobante&id=".$data->id',
            ),

            'delete'=>array(
              'visible'=>'$data->estado=="ACTIVA"',
                    'url' => '"index.php?r=comprobantes/delete&id=".$data->id',
                    'click'=>'js:function(evt){
                        evt.preventDefault();
                        quitarComprobante(evt);
                        }',                        
                ), 
            'activar'=>array(
              'visible'=>'$data->estado!="ACTIVA"',
              'imageUrl'=>'images/iconos/glyphicons/glyphicons_193_circle_ok2.png',
                    'url' => '"index.php?r=comprobantes/activar&id=".$data->id',
                    'click'=>'js:function(evt){
                        evt.preventDefault();
                        activarComprobante(evt);
                        }',                        
                ), 
            'pagos'=>array(
                    'label'=>'Pagos',
                    'imageUrl'=>'images/iconos/glyphicons/money.png',
                    'url' => '"index.php?r=pagos/verPagos&id=".$data->id',
                    'click'=>'js:function(evt){
                        evt.preventDefault();
                        verPagos(evt);
                        }',                        
                ), 
            

			),


),
),
)); ?>
<script>
$('.items tr').each(function() {
   var estado=($(this).find("td").eq(5).children().children().html()); 
   var fila=($(this).attr('class')); 
   if(estado=="INACTIVA"){
   // $('.'+fila).attr('style',$('.'+fila).attr('class')+' warning');
   $('.'+fila).attr('style','  text-decoration: line-through; ');
  }
   console.log(fila);
 });
function quitarComprobante(evt)
{
  var tar=evt.currentTarget.href;

 swal({   title: "Estas seguro de quitar el comprobante?",   text: "Quedará de forma permanente inactivo",  type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Si, Borrar!",   cancelButtonText: "No, cancelo",   closeOnConfirm: false,   closeOnCancel: false }, function(isConfirm){   if (isConfirm) {    _quitarComprobante(tar);   } else {     swal("Cancelado", "Tu registro está a salvo", "error");   } });
  // alert(tar);
}
function _quitarComprobante(tar)
{
   $.get(tar,function(data){
    swal({   title: "Muy bien!", text: "Se ha quitado el registro!", type:  "success",  type: "success",   showCancelButton: false,   confirmButtonColor: "#58FA58",   confirmButtonText: "Bien hecho!",   closeOnConfirm: true }, function(){   location.reload(); });

  });
}
function activarComprobante(evt)
{
  var tar=evt.currentTarget.href;

 swal({   title: "Estas seguro de activar el comprobante?",   text: "Se pondrá el comprobante activo",  type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Si, Activar!",   cancelButtonText: "No, cancelo",   closeOnConfirm: false,   closeOnCancel: false }, function(isConfirm){   if (isConfirm) {    _activar(tar);   } else {     swal("Cancelado", "Tu registro está a salvo", "error");   } });
  // alert(tar);
}
function _activar(tar)
{
   $.get(tar,function(data){
    swal({   title: "Muy bien!", text: "Se ha quitado el registro!", type:  "success",  type: "success",   showCancelButton: false,   confirmButtonColor: "#58FA58",   confirmButtonText: "Bien hecho!",   closeOnConfirm: true }, function(){   location.reload(); });

  });
}

var target='';
var idComprobante=0;
function verPagos(evt)
{
    target=evt.currentTarget.href;
    idComprobante= getIdComprobante(target);
    buscarPagos();
    $('#ventanaPagos').modal();

}
function getIdComprobante(url)
{
    aux=parse_url(url);
    var res = aux.query.split("&");
    idAux=res[1].split("=")[1];
    return idAux;
}
function cargarPago()
{
  if(pagoCorrecto())ingresarPago();
}
function ingresarPago()
{
  var target='index.php?r=pagos/crear';
  var datos={fecha:$('#fecha').val(),idComprobante:idComprobante,importe:$('#importe').val(),idFormaPago:$('#idFormaPago').val() };
  $.getJSON(target,datos,function(data){
    refrescarSaldo(data.saldo);
    $('#importe').val('');
    $('#importe').focus();
    buscarPagos();
      });
}
function refrescarSaldo(saldo)
{
  var color=saldo==0?'blue':'red';
    $(".fila_"+idComprobante+" td:nth-child(8)").html('<small> <strong style=" background-color:#FFFF00;color:'+color+'"> $ '+saldo+' </strong></small>');
      
}
function pagoCorrecto()
{
  return true;
}
function buscarPagos()
{
     $.get(target+"&idComprobante="+idComprobante,function(data){
      //  console.log('dfd'+data);
    $('#cuerpo').html(data);
      });
}
</script>
<div class="modal hide fade" id="ventanaPagos" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"><img src='images/iconos/glyphicons/glyphicons_227_usd.png'/> PAGOS <small><div style="float:right" id='textoComprobante'></div></small></h2>
        
      </div>
      <div id='cuerpo' class="modal-body">

      </div>
      <div class="modal-footer">
       <button onclick='cargarPago()' type="button" style="float:right;" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
      <div style="float:right; padding-top:1px;padding-right:10px">

      <?php
$this->widget('zii.widgets.jui.CJuiDatePicker',
    array(
       'name' => 'fecha',
        'id' => 'fecha',
        'value'=>Date('d-m-Y'),
        'options' => array(
            'language' => 'es'
        ),
         'htmlOptions'=>array('style'=>'width:90px')
    )
);
      ?>
      <?php

$this->widget(
    'bootstrap.widgets.TbSelect2',
    array(
        'name' => 'idFormaPago',
        'id' => 'idFormaPago',
        'value' => '1',
        'data' => CHtml::listData(PagosFormas::model()->findAll(), 'id', 'nombreFormaPago'),
        'options' => array(
            'placeholder' => 'Seleccione ...',
            'width'=>'50px',
        ),
        'htmlOptions'=>array('style'=>'width:120px')
    )
);
      ?>
      <input type='text' style='width:60px;' id='importe' placeholder='$ 0.00' class='number'>
      </div>
       
      </div>
    </div>

</div>
</div>