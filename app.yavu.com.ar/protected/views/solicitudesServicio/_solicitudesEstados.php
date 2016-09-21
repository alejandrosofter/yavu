<table class='table condensed'>
  <tr>
    <th>FECHA</th>
    <th>DETALLE</th>
    <th>ESTADO</th>
  </tr>
  <?php foreach($datos as $item){?>
  <tr >
    <td><?=Yii::app()->dateFormatter->format("dd/MM/yy",$item->fechaHora)?></td>
    <td><?=$item->detalle?></td>
    <td class="<?=$item->nombreClassColor;?>"><?=$item->estado->nombreEstadoSolicitud?></td>
  </tr>
  <?php }?>

</table>

<i></i><b><?=count($datos);?></b> ESTADOS</i>
<div style="float:right"><h4><img src='images/iconos/glyphicons/glyphicons_432_plus.png'/> NUEVO ESTADO</h4></div>
Detalle <textarea rows=3 style="width:100%" type="text" id="detalle"/> <br>
 <input type="radio" name="idEstado" value="1"> <small><b style='color:red'>Ingresado</b></small> </input>|
  <input type="radio" name="idEstado" value="2">  <small><b style='color:orange'>En Curso</b></small></input> |
 <input type="radio" name="idEstado" value="3">  <small><b style='color:green'>Final.</b></small></input> |
  <input type="radio" name="idEstado" value="4"> <small><b style='color:black'>Fact.</b></small></input>
<a style='width:100%' onclick='ingresar()' class='btn btn-primary'>INGRESAR</a>
<script>
  
  function datosValidos()
  {
    var est = $("input[name='idEstado']:checked").val();
    var detalle=$("#detalle").val();
    if(est==null){
      sweetAlert("Oops...", "Debe ingresar un estado!", "error");
      return false;
    }
    if(detalle==""){
      sweetAlert("Oops...", "Debe ingresar un detalle!", "error");
      return false;
    }
    return true;
  }
  function resetForm()
  {
    $("#detalle").val("");
  }
function ingresar()
  {
    var idEstado = $("input[name='idEstado']:checked").val();
    var detalle=$("#detalle").val();
    if(datosValidos()){
      $.blockUI({ css: { backgroundColor: '#ccc', color: '#fff'},message: '<h1>INGRESANDO ESTADO ...</h1>',  });
		$.get("index.php?r=solicitudServicioEstados/ingresar&id="+idSolicitudSeleccionada+"&detalle="+detalle+"&idEstado="+idEstado,function(data){
			if(data!="")sweetAlert("Genial!", "El estado se guardo con exito!", "success");else  sweetAlert("Oops...", "No se pudo cargar el estado!", "error");
      resetForm();
      consultarSolicitudes();
      $.unblockUI();
		});
    }
  }
</script>