<?php
 if(isset($_GET['q'])){
require("dbConexion/Db.class.php");
$db = new Db();
$query="SELECT * FROM clientes where id=".$_GET['id'];
$res 	 =     $db->query($query);
							
if(count($res)>0){
$verificado=hash('ripemd160', $res[0]['nombreUsuario'].'andatealaputaquetepario');
if($verificado==$_GET['q']){
$clave=hash('ripemd160', $_GET['clave']);
$query="UPDATE clientes set claveAcceso='".$clave."' where id=".$_GET['id'];
$res 	 =     $db->query($query);
}
}
}
?>