<?php

require("dbConexion/Db.class.php");

	// Creates the instance
	$db = new Db();
	$query="SELECT * FROM clientes where nombreUsuario='".$_GET['usuario']."'";
	//echo $query;
	$q 	 =     $db->query($query);
	echo count($q);
?>