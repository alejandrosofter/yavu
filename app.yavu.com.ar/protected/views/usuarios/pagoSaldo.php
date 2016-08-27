<?php


$saldo=$saldo*1;
//**********************INTERFAZ MP************************************//
require_once dirname(__FILE__)."/../../extensions/sdk-php-master/lib/mercadopago.php";
$mp = new MP('5839987130287087', 'v5vbB8PyLJy7l48TH8zWjbyHKSWpthBF');
//$mp->sandbox_mode(FALSE);
$preference_data = array(
    "items" => array(
       array(
           "title" => "Servicio Sistemas YAVU",
           "quantity" => 1,
           "currency_id" => "ARS",
           "unit_price" => $saldo
       )
    ),
    "external_reference" => $idCliente,
);

$preference = $mp->create_preference($preference_data);
//$preference['response']['sandbox_init_point'];
//**********************INTERFAZ MP************************************//
?>
<div style='float:right'>
<a  href="<?php echo $preference["response"]["init_point"]; ?>" name="MP-Checkout" class="blue-ar-m-rn-arall">PAGAR SALDO <b>$<?=number_format($saldo,2)?></b></a>
    <script type="text/javascript" src="http://mp-tools.mlstatic.com/buttons/render.js"></script>
</div>