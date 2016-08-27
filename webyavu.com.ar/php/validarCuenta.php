

<?php
require("dbConexion/Db.class.php");

	// Creates the instance
	$db = new Db();

	$query="SELECT * FROM clientes where verificado='".$_GET['q']."'";
	$res 	 =     $db->query($query);

	if(count($res)>0){

		$query="UPDATE clientes set estado='ACTIVO', verificado='' where id=".$res[0]['id'];
		$res 	 =     $db->query($query);
	?>
	<table>
	<tr>
		<td><img src='img/ok.jpg'/></td>
		<td>EL SISTEMA HA<b> SIDO ACTIVADO SATISFACTORIAMENTE</b>! Esta en condiciones de ingresar a su cuenta y comenzar a usar YAVU! Ingrese por la parte superior de la web de yavu e ingrese sus datos para el ingreso.</td>
	</tr>
	</table>
	<script>
		var myVar = setInterval(cuenta, 1000);
		var seg=8;
		function cuenta() {
			$('#cuenta').html('LLENDO A YAVU <b>en '+seg+"</b>");
			seg--;
			if(seg==0)window.location.href='http://app.yavu.com.ar/index.php?r=site/login';
		}
		

	</script>
		<big id='cuenta'></big>
	<?php } else{ ?>
	<table>
	<tr>
		<td><img src='img/cancel.jpg'/></td>
		<td>CODIGO DE VERFICACION INCORRECTO! o bien ya se ha verificado la cuenta</td>
	</tr>
	</table>
	<?php }?>
