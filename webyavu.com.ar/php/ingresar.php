<?php

require("dbConexion/Db.class.php");

	// Creates the instance
	$db = new Db();
	$clave=hash('ripemd160', $_GET['clave']);

	$query="SELECT * FROM clientes where nombreUsuario='".$_GET['usuario']."' AND claveAcceso='".$clave."'";
	$q 	 =     $db->query($query);
	echo count($q);
?>