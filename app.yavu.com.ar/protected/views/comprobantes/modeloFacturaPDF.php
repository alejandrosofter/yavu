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
    text-align: center;
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
		<table width="100%" style="font-size: 9pt; border-collapse: collapse;" >
				<thead>
				<tr>
					<td style="text-align:right; padding:30px; width:400px">
					
					</td>
					<td style="text-align:center; padding:30px; width:100px">
					<h1><?=$params['letra']?></h1>
					</td>
					<td style="text-align:right;padding-right:30px; width:400px">
						<table class='items'  border='0'>
						<tr><td class='blanktotal' style='text-align:right'><b>FECHA:</b></td><td class='blanktotal' style='text-align:left'><?=$params['fecha']?></td></tr>
						<tr><td class='blanktotal' style='text-align:right'><b>NRO COMPROBANTE:</b></td><td class='blanktotal' style='text-align:left'><?=$params['nroComprobante']?></td></tr>
						</table>
						</td>
					</tr>
				</thead>
			</table>
			<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" >
				<thead>
				<tr>
					<td style="text-align:left; padding:30px; width:450px">
					<?=$params['razonSocial_emisor']?>
					<table class='items'  border='0'>
						<tr><td class='blanktotal' style='text-align:right'><b>CUIT:</b></td><td class='blanktotal' style='text-align:left'><?=$params['cuit_emisor']?></td></tr>
						<tr><td class='blanktotal' style='text-align:right'><b>DIRECCION:</b></td><td class='blanktotal' style='text-align:left'><?=$params['direccion_emisor']?></td></tr>
						<tr><td class='blanktotal' style='text-align:right'><b>CONTACTO:</b></td><td class='blanktotal' style='text-align:left'>Tel.<?=$params['telefono_emisor']?> /email: <?=$params['email_emisor']?></td></tr>
						</table>
					</td>
					
					<td style="text-align:right;padding-right:30px; width:450px">
					<br><br><br>
						<table class='items'  border='0'>
						<tr><td class='blanktotal' style='text-align:right'><b> </b></td><td class='blanktotal' style='text-align:left'><h1><?=$params['razonSocial_receptor']?></h1></td></tr>
						<tr><td class='blanktotal' style='text-align:right'><b>CUIT:</b></td><td class='blanktotal' style='text-align:left'><?=$params['cuit_receptor']?></td></tr>
						<tr><td class='blanktotal' style='text-align:right'><b>DIRECCIÓN:</b></td><td class='blanktotal' style='text-align:left'><?=$params['direccion_receptor']?></td></tr>
						<tr><td class='blanktotal' style='text-align:right'><b>CONTACTOS:</b></td><td class='blanktotal' style='text-align:left'>Tel.<?=$params['telefono_receptor']?> /email: <?=$params['email_receptor']?></td></tr>

						</table>
						</td>
					</tr>
				</thead>
			</table>
<table class="items2" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
<?=$params['items']?>

</table>
<table  width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
<tbody><tr>
		
		
		
		<td width="50%">
			<?php if($params['verTipo']=='ok'){?>
			<table class='items'  border='0'>
						<tr><td class='blanktotal' style='text-align:right'><b>$ IVA 21</b></td><td class='blanktotal' style='text-align:left'><?=$params['importeIva']?></td></tr>
						<tr><td class='blanktotal' style='text-align:right'><b>$ BRUTO 21</b></td><td class='blanktotal' style='text-align:left'><?=$params['importeBruto']?> </td></tr>
						</table>
		 <?php }?>
		</td>
		<td style="text-align: right" width="50%"><h1>TOTAL $<?=$params['importeTotal']?></h1></td></tr></tbody
		>
</table>
<?php if($params['cae']!=''){?>
		<span><strong>FACTURA ELECTRONICA</strong>	<?=$params['cae']?> | </span>
		<span><strong>Vto.</strong>	<?=$params['fechaVto']?> </span>
		 <?php }?>
</html>