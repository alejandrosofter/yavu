<?php

require("dbConexion/Db.class.php");

	// Creates the instance
	$db = new Db();
	$query="SELECT * FROM clientes where email='".$_GET['email']."'";
	
	$q 	 =     $db->query($query);
	echo count($q);
?>