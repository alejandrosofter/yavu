<?php

$path=dirname(__FILE__).'/../img/logoChicoChico.png';

$data = file_get_contents($path);
$logo = 'data:image/png;base64,' . base64_encode($data);
//$logo='img/logoChicoChico.png';
$validacion='';
$linkValidar='http://yavu.com.ar/validar&q='.$validacion;
$usuario='';
$replace = array('{usuario}', '{link}', '{logo}');
$with = array($usuario, $linkValidar,$logo);

ob_start();
include('plantillaEmail_verificacionCliente.tpl');
$ob = ob_get_clean();

$mensaje= str_replace($replace, $with, $ob);
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$email='alejandro@softer.com.ar';
// Cabeceras adicionales
$cabeceras .= 'To: Mary <'.$email.'>, '.$usuario.' <'.$email.'>' . "\r\n";
$cabeceras .= 'From: YAVU <info@yavu.com.ar>' . "\r\n";
echo mail($email, "VALIDACION YAVU", $mensaje,$cabeceras);
echo 'mail enviado';
?>