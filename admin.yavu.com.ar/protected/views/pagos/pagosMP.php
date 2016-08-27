<h1>PAGOS MP</h1>

<?php
require_once dirname(__FILE__)."/../../extensions/sdk-php-master/lib/mercadopago.php";
$mp = new MP('5839987130287087', 'v5vbB8PyLJy7l48TH8zWjbyHKSWpthBF');
$mp->sandbox_mode(FALSE);
$filt=array();
$acess=($mp->search_payment($filt,0,0));
//print_r($acess['response']['results']);
//echo 'cant:'.count($acess);
?>
<table class='table table-condensed'>
<tr><th>FECHA</th><th>COLECTOR ID</th><th>NICK</th><th>EMAIL</th><th>FORMA PAGO</th><th>IMPORTE</th><th>ESTADO</th></tr>
<?php
$res=$acess['response']['results'] ;

 foreach($res as $item){

 	$fecha=Date('d/m/Y H:i',strtotime($item['collection']['date_created']))?>
<tr><td><?=$fecha?></td>
<td><?=$item['collection']['id']?></td>
<td><?=$item['collection']['payer']['nickname']?></td>
<td><?=$item['collection']['payer']['email']?></td>
<td><?=$item['collection']['payment_type']?></td>
<td><?=$item['collection']['total_paid_amount']?></td>
<td><?=$item['collection']['status_detail']?></td>
</tr>

<?php }?>
</table>