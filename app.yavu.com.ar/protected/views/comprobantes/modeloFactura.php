<div class="contenedorFactura" id="contenedorComprobate">
	<div class="impresionPapel">
		<table border="1" cellpadding="0" cellspacing="0" style="height:50px; line-height:20.7999992370605px; width:100%">
			<tbody>
				<tr>
					<td style="text-align:right; padding:30px; width:300px"></td>
					<td style="text-align:center; vertical-align:middle; white-space:nowrap; width:50px">
						<div>
							<h1 style=""><a style="color:#0088cc" data-type="select2" href="#" id="letraComprobante" class="editable editable-click">  <?=$params['letra']?> </a> </h1>
							
							<?php if($params['hayElectronica']){?>
							<a  href="#" id='facturaElectronica' style='color:#0088cc' data-type="checklist"><small >Factura Electronica</small></a> 
							<?php }?>
							
						</div>
					</td>
					<td style="text-align:right;padding-right:30px; width:300px">
						<div style="line-height: 20.7999992370605px; text-align: right;">
							<div style="line-height: 20.8px; text-align: right;"><strong>NRO: </strong><span id="nroComprobante"><?=$params['nroComprobante']?> </span></div>
							<div style=" text-align: right;">
								

								<div style="text-align: right;"><span style="font-size:14px"><strong>FECHA:</strong>
									<a href="#" id="fechaComprobante" style="color:#0088cc" data-type="date" data-pk="1" class="editable editable-click">   <?=$params['fecha']?> </a> </span></div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<table border="1" cellpadding="0" cellspacing="0" style="height:50px; line-height:20.7999992370605px; width:100%">
				<tbody>
					<tr>
						<td style="text-align:left; vertical-align:top; padding-left:30px; width:600px">
							<div><strong><?=$params['razonSocial_emisor']?></strong></div>

							<div><strong>  <?=$params['condicionIva_emisor']?></strong></div>

							<div>  <?=$params['direccion_emisor']?></div>

							<div>CUIT:   <?=$params['cuit_emisor']?></div>

							<div>  <?=$params['email_emisor']?></div>
						</td>
						<td style="text-align:right;padding-right:30px; vertical-align:top; width:600px">

							<div><strong>A <a href="#" style="color:#0088cc" data-type="select2" id="razonSocial_receptor" class="editable editable-click"> <?=$params['razonSocial_receptor']?></a></strong></div>

							<div><span style="font-size:12px"><strong> <span id="condicionIvaReceptor"><?=$params['condicionIva_receptor']?></span></strong></span></div>

							<div><strong>DOMICILIO:</strong> <span id="direccionReceptor"><?=$params['direccion_receptor']?></span></div>

							<div><strong>CUIT:</strong> <span id="cuitReceptor"><?=$params['cuit_receptor']?></span></div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div style="padding-left:30px;" id="items">
								
								<table id="tablaItems"  style="width:100%;">
									<tbody>
										<tr><th style="width:60px">Cant.</th><th>Detalle</th><th style="width:80px">$ Unidad</th><th id="columnaBruto" style="width:80px;display:none">$ BRUTO</th><th style="width:90px">$ TOTAL</th></tr>
										<?=$params['items']?>
									</tbody>
								</table>
								<br><br><br><br><br><br>
								
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div style="padding-left:30px;padding-right:30px;display:<?=$params['verTipo']?>" id="pieItems">
								<table class="table table-condensed" style="width:260px;float:left">
									<tbody><tr><th style="width:100px">$ IVA 21%</th><th style="width:140px">$ BRUTO 21 %</th></tr>
										<tr><td id="gral_iva21"> <?=$params['importeIva']?></td><td id="gral_bruto21"><?=$params['importeBruto']?></td></tr>
									</tbody></table>

								</div>
								<h1 style="float:right;width:400px;text-align:right;padding-right:30px"><small>TOTAL </small> $ <b id="totalGral"> <?=$params['importeTotal']?></b></h1>
						</td>
						</tr>
						<tr><td colspan="2"><small><?=$params['cae']?></small> <span style="padding-right:30px;float:right"><small>Diseño y programación <b>YAVU.COM.AR</b></small></span></td></tr>
					</tbody>
				</table>

			</div>
		</div>