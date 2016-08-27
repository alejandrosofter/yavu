<?php


$saldo=$saldo*1;
//**********************INTERFAZ MP************************************//
require_once dirname(__FILE__)."/../../extensions/sdk-php-master/lib/mercadopago.php";
$mp = new MP('5839987130287087', 'v5vbB8PyLJy7l48TH8zWjbyHKSWpthBF');
//$mp->sandbox_mode(FALSE);
$preference_data = array(
    "items" => array(
       array(
           "title" => "SOLICITUD DE GENERACION DE CERTIFICADO AFIP",
           "quantity" => 1,
           "currency_id" => "ARS",
           "unit_price" => $saldo
       )
    ),
    "external_reference" => $idSolicitud.'_solicitud',
);

$preference = $mp->create_preference($preference_data);
//$preference['response']['sandbox_init_point'];
//**********************INTERFAZ MP************************************//
?>

<a  href="<?php echo $preference["response"]["init_point"]; ?>" onreturn="cargo" name="MP-Checkout" class="">Realizas el pago de $200  por el tramite.</a>
    <script type="text/javascript" src="http://mp-tools.mlstatic.com/buttons/render.js"></script>
<script type="text/javascript">
   function cargo(json)
   {
    if(json.collection_status==null){
        swal({   title: "Opss..",  text:  "El usuario no completó el proceso de pago, no se ha generado ningún pago",  html: true,  type: "error"});
       return;
    }
     if(json.collection_status=='rejected'){
        swal({   title: "Opss..",  text:  "El pago fué rechazado, el usuario puede intentar nuevamente el pago",  html: true,  type: "error"});
       return;
    }
    if(json.collection_status=='in_process'){
        swal({   title: "Opss..",  text:  "El pago está siendo revisado",  html: true,  type: "error"});
       return;
    }
    if(json.collection_status=='pending'){
        swal({   title: "Opss..",  text:  "El usuario no completó el pago",  html: true,  type: "error"});
       return;
    }
     if(json.collection_status=='approved'){
        swal({   title: "GENIAL!",  text:  "El pago ya se acreditó, estamos trabajando para subir tu certificado",  html: true,  type: "success"});
        setTimeout(recargar,4000);
       return;
    }
      
   }
   function recargar()
   {
   window.location=document.URL;
   }
</script>