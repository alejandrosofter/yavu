<html>
<head>
<style>
body {font-family: sans-serif;
    font-size: 10pt;
}
p {    margin: 0pt;
}
td { vertical-align: top; }

table thead td { background-color: #FFFFFF;
   
    border: 0.1mm solid #000000;
}
table tbody td { background-color: #ffffff;

    border: 0.1mm solid #000000;
}
.vacio table tbody td{
	color:#FFFFFF;
}

.items td.blanktotal {
    background-color: #FFFFFF;
    border: 0mm none #000000;
}
.items td.totals {
    text-align: right;
    border: 0.1mm solid #000000;
}
</style>
</head>


	<table width="100%" style="font-size: 15pt; border-collapse: collapse;" >
				<thead>
				<tr>
					<td style="padding:50px"><?=$params['logo'];?></td>
					<td style="padding:30px; width:100%">
					
						<span style="float:right">Muchas gracias por confiar en nuestro servicio!</span> <BR>
						<strong>FECHA: <?=$params['fecha'];?></strong><BR>
						<strong>CLIENTE: <?=$params['cliente'];?></strong><BR>
						<strong>REQUERIMIENTO: <?=$params['requerimiento'];?></strong><BR>
						Las solicitudes tienen una demora de 48 hrs por lo menos .. cualquier consulta puede llamar al 4549601 o enviar un correo a info@softer.com.ar
					</td>
					
					</tr>
				</thead>
			</table>

</html>