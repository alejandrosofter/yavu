<div class="impresionPapel" id="impresionPapel">
<div class="imprimir">
<table border="1" cellpadding="0" cellspacing="0" style="height:50px; width:100%">
	<tbody>
		<tr>
			<td style="text-align:right">&nbsp;</td>
			<td style="text-align:right; width:50px;padding:10px"><strong><span style="font-size:48px;padding:10px"><?=$params['letra']?></span></strong></td>
			<td style="text-align:right">
			<div style=" text-align: right;">&nbsp;</div>
			<div style="position:absolute; width:96%;left: 10px; top: 50px;">
				<div>
				<div style="text-align: right;"><big><b>Nro <?=$params['nroComprobante']?></b></big></div>

				<div style="text-align: right;"><span style="font-size:14px"><?=$params['fecha']?></span></div>
				</div>
			</div>
			</td>
		</tr>
	</tbody>
</table>
<table border="1" cellpadding="3" cellspacing="0" style="width:100%">
	<tbody>
		<tr>
			<td style="text-align:left; vertical-align:top; width:600px">
			<div><span style="font-size:24px"><strong><?=$params['razonSocial_emisor']?></strong></span></div>

			<div><span style="font-size:12px"><strong><?=$params['condicionIva_emisor']?></strong></span></div>

			<div><?=$params['direccion_emisor']?></div>

			<div>CUIT: <?=$params['cuit_emisor']?></div>

			<div><?=$params['email_emisor']?></div>
			</td>
			<td style="text-align:right; vertical-align:top; width:600px">
			

			<div><span style="font-size:16px"><strong>A <?=$params['razonSocial_receptor']?></strong></span></div>

			<div><span style="font-size:12px"><strong><?=$params['condicionIva_receptor']?></strong></span></div>

			<div><?=$params['direccion_receptor']?></div>

			<div><strong>CUIT:</strong> <?=$params['cuit_receptor']?></div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<?=$params['detallePago']?>
			</td>
		</tr>
	</tbody>
</table>

</div>
</div>