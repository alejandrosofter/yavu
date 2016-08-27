<?php
$ip=('app.yavu.com.ar');
$ruta='http://'.$ip.'/index.php?r=yavu/servicio';
$x = new SoapClient($ruta);
echo ($x->loginWeb($_GET['usuario'],$_GET['clave'])); 
?>