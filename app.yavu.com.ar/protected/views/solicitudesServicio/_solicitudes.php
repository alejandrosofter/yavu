<style>
  .ingresado{
    background-color:red;
  }
  .pendiente{
    background-color:orange;
  }
  .finalizado{
    background-color:green;
  }
</style>
<div style="float:left" class='span7' >
<table class='table condensed'>
  <tr>
    <th>FECHA</th>
    <th>CLIENTE</th>
    <th>REQUERIMIENTO</th>
		<th>TEL.</th>
  </tr>
  <?php foreach($datos as $item){?>
  <tr title="<?=$item->estado->nombreEstadoSolicitud?>" id='fila_<?=$item->id;?>' onclick="clickFila(<?=$item->id;?>)" class="<?=$item->nombreClassColor;?>">
    <td style='width:60px'><small><?=Yii::app()->dateFormatter->format("dd/MM/yy",$item->fechaHora)?></small></td>
    <td style='width:180px'><strong><?=$item->entidad->razonSocial?></strong></td>
		
    <td><?=$item->requerimiento?></td>
		<td style='width:70px'><small><small><small><?=$item->entidad->telefono?></small></small></small></td>
   
    <td style='width:70px'>
      <a class='imprime' data-fancybox-type='iframe' href="index.php?r=solicitudesServicio/update&id=<?=$item->id;?>"><img style="width:20px" title='Modificar' src='images/iconos/glyphicons/glyphicons_030_pencil.png'/></a>
      <a class='imprime' data-fancybox-type='iframe' href="index.php?r=solicitudesServicio/imprimir&id=<?=$item->id;?>"><img style="width:20px" title='Imprimir' src='images/iconos/glyphicons/glyphicons_015_print.png'/></a>
      <a onclick="facturar(<?=$item->id;?>)" href="#"><img style="width:20px" title='Facturar' src='images/iconos/glyphicons/glyphicons_458_money.png'/></a>
    </td>
    <td style='width:30px' class="flag" id="flag_<?=$item->id;?>"></td>
  </tr>
  <?php }?>

</table>

<i></i><b><?=count($datos);?></b> RESULTADOS</i>
</div>

	<div  id="solicitudesEstados" style="padding-top:100px" class="span4">Sin Estados... (click sobre un servicio para ver los estados)</div>

<script>
  var idSolicitudSeleccionada=0;
  
  function facturar(id)
  {
    $.get("index.php?r=solicitudesServicio/facturar&idSolicitud="+id,function(data){
			$('#paraFacturar').html(data+"  Para Facturar");
		});
  }
function clickFila(id)
  {
    
    if(idSolicitudSeleccionada!=id){
      buscarEstados(id);
    }
    
  }
  function setSeleccion(id)
  {
      $(".flag").html("");
      $("#flag_"+id).html("<img src='images/iconos/glyphicons/glyphicons_211_right_arrow.png'/>");
  }
  function buscarEstados(id)
  {
    setSeleccion(id);
    $.blockUI({ css: { backgroundColor: '#ccc', color: '#fff'},message: '<h1>CARGANDO ESTADOS ...</h1>',  });
		$.get("index.php?r=solicitudesServicio/consultarSolicitudesEstados&idSolicitud="+id,function(data){
			$('#solicitudesEstados').html(data);
      $("#solicitudesEstados").stick_in_parent();
      idSolicitudSeleccionada=id;
      $.unblockUI();
		});
  }
</script>