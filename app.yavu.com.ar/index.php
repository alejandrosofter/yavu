<?php

if (!isset($_SESSION['usuario'])) {
	session_start();
	if(isset($_POST['username']))$_SESSION['usuario']=$_POST['username'];
	if(isset($_GET['username']))$_SESSION['usuario']=$_GET['username'];
	require("protected/extensions/dbConexion/Db.class.php");
	$db = new Db();
	if(isset($_SESSION['usuario'])){
		$usuario=trim(strtolower($_SESSION['usuario']));
		$query="SELECT * FROM clientes where nombreUsuario='".$usuario."'";
		$q 	 =     $db->query($query);
		if(count($q)>0)$_SESSION['valido']=true;else $_SESSION['valido']=false;
	}else $_SESSION['valido']=false;
	
}else{

}

	$yii=dirname(__FILE__).'/framework/yii.php';
	$config=dirname(__FILE__).'/protected/config/main.php';
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
	require_once($yii);
	
	Yii::createWebApplication($config)->run();
	