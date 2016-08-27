<?php
$ip=('app.yavu.com.ar');
$ruta='http://'.$ip.'/index.php?r=yavu/servicio';
echo $ruta;
$x = new SoapClient($ruta);
echo json_encode($x->estaLogueado()); 
?>