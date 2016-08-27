
<style>
.navbar-fixed-top {
    z-index: 100;
}
</style>
<?php 

$colorPrimero='grey';
$colorSegundo='grey';
$colorTercero='grey';
$colorCuarto='grey';
$pasoPredomina='success';

$solicitudes=YavuWeb::consultarSolicitudesAfip();

$haySolicitudes=count($solicitudes)>0;
if($haySolicitudes)$solicitud=$solicitudes[0]; //LA ULTIMA
	else $solicitud=false;
if($solicitud)
	switch ($solicitud['estado']) {
    case 'PEDIDO':{
    	$colorPrimero='green';
    	$colorSegundo='orange';
    	$colorTercero='grey';
    	$colorCuarto='grey';
    	$pasoPredomina='warning';
        break;
    }
    case 'PENDIENTE PAGO':{
    	$colorPrimero='green';
    	$colorSegundo='orange';
    	$colorTercero='grey';
    	$colorCuarto='grey';
    	$pasoPredomina='warning';
        break;
    }
     case 'EN PROCESO':{
    	$colorPrimero='green';
    	$colorSegundo='green';
    	$colorTercero='orange';
    	$colorCuarto='grey';
    	$pasoPredomina='warning';
        break;
    }
    case 'TRAMITADO':{
    	$colorPrimero='green';
    	$colorSegundo='green';
    	$colorTercero='green';
    	$colorCuarto='green';
    	$pasoPredomina='success';
        break;
    }
}

?>


<h1><img src='images/iconos/glyphicons/glyphicons_044_keys.png'/>  SOLICITU DE TRAMITE <small> YAVU se hace cargo</small></h1>
SOLICITUDES
<?php if(count($solicitudes)>0){?>
<span class="label label-<?=$pasoPredomina?>"><?=Yii::app()->dateFormatter->format("dd/MM/yy",$solicitudes[0]['fecha']).' ' .$solicitudes[0]['estado'] ?></span>
<?php }
?>
<?php for($i=1;$i<count($solicitudes);$i++){?>
<span class="label  label-success"><?=Yii::app()->dateFormatter->format("dd/MM/yy",$solicitudes[$i]['fecha']).' ' .$solicitudes[$i]['estado'] ?></span>

<?php }?>
<dl  class="dl-horizontal">
  <dt style='color:<?=$colorPrimero?>'> PRIMERO</dt>
  <dd style='color:<?=$colorPrimero?>'><span id='vinculoPrimero'><a href="index.php?r=site/solicitarCertificado" class='pedido' data-fancybox-type='iframe'> Haces el pedido e ingresas tu CUIT y CLAVE FISCAL.</a></span></dd>
  <dt style='color:<?=$colorSegundo?>'> SEGUNDO</dt>
  <dd style='color:<?=$colorSegundo?>'><span id='vinculoSegundo'><?php $this->renderPartial('/site/linkPagoSolicitud',array('saldo'=>200,'idSolicitud'=>$solicitud['id']))?></span></dd>
  <dt style='color:<?=$colorTercero?>'> TERCERO</dt>
  <dd style='color:<?=$colorTercero?>'>Yavu realiza el tramite mediante afip y te hace la carga automática a tu sistema (APROX. 24 hrs hábiles)</dd>
  <dt style='color:<?=$colorCuarto?>'> CUARTO</dt>
  <dd style='color:<?=$colorCuarto?>'>YA PODES USAR FACTURACION ELECTRONICA</dd>

</dl>
<script>
if('<?=$colorPrimero?>'=='green' && '<?=$colorCuarto?>'!='green')$("#vinculoPrimero").html('Haces el pedido e ingresas tu CUIT y CLAVE FISCAL.');
if('<?=$colorSegundo?>'=='green')$("#vinculoSegundo").html('Realizas el pago de $200 por el tramite.');
if('<?=$colorSegundo?>'=='grey')$("#vinculoSegundo").html('Realizas el pago de $200  por el tramite..');
if('<?=$colorTercero?>'=='green')$("#vinculoTercero").html('Yavu realiza el tramite mediante afip y te hace la carga automática a tu sistema (APROX. 24 hrs hábiles)');
if('<?=$colorCuarto?>'=='green')$("#vinculoCuarto").html('YA PODES USAR FACTURACION ELECTRONICA');
</script>