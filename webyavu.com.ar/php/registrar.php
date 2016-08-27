<?php
function is_process_running($PID)
   {
       exec("ps $PID", $ProcessState);
       return(count($ProcessState) >= 2);
   }
require("dbConexion/Db.class.php");
$fecha=Date('Y-m-d');
$fechaFin=Date('Y-m-d', strtotime("+31 days"));

	// Creates the instance
$db = new Db();
$nombreUsuario=strtolower(trim($_GET['nombreUsuario']));
$verificado=hash('ripemd160', $nombreUsuario.'andatealaputaquetepario');
$clave=hash('ripemd160', $_GET['clave']);
unset($_GET['clave']);

$_GET['estado']="A_VALIDAR";
$_GET['fechaVto']=$fechaFin;
$_GET['idCondicionIva']=0; //para no joder 
	//mysql_select_db('yavu');
$q="INSERT INTO clientes(estado,fechaVto,nombre,apellido,telefono,domicilio,idCondicionIva,versionYavu,nombreUsuario,claveAcceso,email,recomendado,verificado,importeSaldo) VALUES('".$_GET['estado']."','".$_GET['fechaVto']."','".$_GET['nombre']."','".$_GET['apellido']."', '".$_GET['celular']."', '".$_GET['domicilio']."', 0, '".$_GET['versionYavu']."','".$nombreUsuario."', '".$clave."', '".$_GET['email']."', '".$_GET['recomendado']."', '".$verificado."',0 )";
$db->query($q);
$idCliente=mysql_insert_id();

$q="INSERT INTO clientes_deudas(idServicio,fecha,fechaInicio,fechaFin,importe,importeSaldo,estado,idCliente) VALUES(1,'".$fecha."','".$fecha."', '".$fechaFin."', 0, 0, 'ACTIVO' ,LAST_INSERT_ID())";
$db->query($q);


//CREO LA BASE DE DATOS DEL CLIENTE
$db->query("CREATE DATABASE ".$nombreUsuario, $_GET);
$script='../bash/ejecuta '.$nombreUsuario;
$output = shell_exec($script);

   
//ENVIO EL MAIL PARA SU VALIDACION

//$data = file_get_contents($path);
$logo = 'http://yavu.com.ar/img/logoChicoChico.png';

$linkValidar='http://yavu.com.ar/validar.php?q='.$verificado;
$usuario=$nombreUsuario;
$email=$_GET['email'];
$replace = array('{usuario}', '{link}', '{logo}');
$with = array($usuario, $linkValidar,$logo);

ob_start();
include('plantillaEmail_verificacionCliente.tpl');
$ob = ob_get_clean();

$mensaje= str_replace($replace, $with, $ob);
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: '.$usuario.' <'.$email.'>, '.$usuario.' <'.$email.'>' . "\r\n";
$cabeceras .= 'From: YAVU <info@yavu.com.ar>' . "\r\n";

mail($email, "VALIDACION YAVU", $mensaje, $cabeceras);

?>