<script src="js/aloha.min.js"></script>
<div class='impresionPapel'>
<h1><?=$edificio->nombreEdificio?> <small><?=Date('d M Y')?></small></h1>

<div class='row'>
	<div id='fondoReserva' class='span3'>
		<h3><img src='images/iconos/glyphicons/glyphicons_227_usd.png'/> Fondo de Reserva</h3>
		<table class="table table-condensed">
 			<tr><th>A Recaudar <?=Date('Y')?></th><td>$ <?=number_format(Liquidaciones::model()->importeReserva($_GET['idEdificio'],Date('Y')),2);?></td></tr>
 			<tr><td>Gastado</td><td>$ <?=number_format(Gastos::model()->getImporteGastosFondoReserva($_GET['idEdificio'],Date('Y')),2);?></td></tr>
 			<tr><td>Recaudado</td><td>$ <?=number_format(ComprobantesItemsParaCobrar::model()->consultarImporteFondoCobrado($_GET['idEdificio'],Date('Y')),2);?></td></tr>
 			
 			     <tr><th>Año Pasado</th><td>$ <?=number_format(Liquidaciones::model()->importeReserva($_GET['idEdificio'],Date('Y')-1),2);?></td></tr>
 			<tr><td>Gastado</td><td>$ <?=number_format(Gastos::model()->getImporteGastosFondoReserva($_GET['idEdificio'],Date('Y')-1),2);?></td></tr>
 			<tr><td>Recaudado</td><td>$ <?=number_format(ComprobantesItemsParaCobrar::model()->consultarImporteFondoCobrado($_GET['idEdificio'],Date('Y')-1),2);?></td></tr>
		</table>
		
	</div>
	<div class='span7'>
		<h3><img src='images/iconos/glyphicons/glyphicons_007_user_remove.png'/> Morosos</h3>
		<table id='tablaMorosos' class="table  table-condensed">
 			<tr><th>Un.Funcional</th><th>Inquilino</th><th class='personal'>Tel.</th><th class='personal'>Email</th><th>Meses</th><th style='width:80px'>Importe</th></tr>
 			<?php foreach($morosos as $mora){?>
 				<tr>
 					<td><?=$mora->propiedad->nombrePropiedad?></td>
 					<td><a class="imprime" data-fancybox-type="iframe" title="Detalle" 
 				href="index.php?r=paraCobrar/detalleMora&idEntidad=<?=$mora->idEntidad;?>&idPropiedad=<?=$mora->idPropiedad;?>&idEdificio=<?=$mora->propiedad->idEdificio;?>">
 				<?=$mora->entidad->razonSocial?></a></td>
 				<td class='personal'><?=$mora->entidad->telefono?></td>
 				<td class='personal'><?=$mora->entidad->email?></td>
 				<td style='width:60px'><?=$mora->cantidadMeses;?></td>
 				<td style='width:80px'>$ <?=number_format($mora->importe,2)?></td>
 				</tr>
 			<?php }?>
		</table>
		 <div data-placement="left" data-original-title="Aquí escriba el contenido" id='detalle'><b>Detalle:</b> ...</div>

	</div>
	
</div>
</div>
<div style='float:right'>
<form class="form-search">
	<label class="checkbox">
      <input type="checkbox" id='checkPersonal' onclick="cambiaPersonal()" checked> Mostrar datos Personales
    </label>
     
      <label class="checkbox">
      <input type="checkbox" id='checkReserva' onclick="cambiaFondo()" checked> Mostrar Fondo de reserva
    </label>
    
</form>


<a onclick='imprimirPapel()' style='width:800px' class="btn btn-primary" href="#"><i class="icon-print icon-white"></i> Imprimir</a>
</div>
<script>
aloha(document.querySelector('#detalle'));
aloha(document.querySelector('#tablaMorosos'));
$('#detalle').tooltip();
function cambiaPersonal()
{
	if($('#checkPersonal').attr('checked')=='checked')$('.personal').show();
	else $('.personal').hide();
}
function cambiaFondo()
{
	if($('#checkReserva').attr('checked')=='checked')$('#fondoReserva').show();
	else $('#fondoReserva').hide();
}
</script>