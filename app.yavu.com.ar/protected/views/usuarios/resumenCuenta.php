<h4><img src='images/iconos/glyphicons/glyphicons_150_edit.png'/> <l style='color:'>RESUMEN </l>  por importes</h4>
<table class='table table-condensed' style='widht:100%'>
<tr>
	<th></th><th>$ Facturado</th><th> $ Pagado</th>
</tr>
<tr>
	<th>Esta Semana</th>
	<td><a data-toggle="tooltip" data-original-title="Detalle del importe" data-placement="top" data-fancybox-type='iframe' class='imprime' href='index.php?r=usuarios/items&tipo=week&pasada=0'> <?=Estadisticas::consultar('week','comprobantes')?></a></td>
	<td><a data-toggle="tooltip" data-original-title="Detalle del importe" data-placement="top" data-fancybox-type='iframe' class='imprime' href='index.php?r=usuarios/itemsPago&tipo=week&pasada=0'>  <?=Estadisticas::consultar('week','pagos')?></a></td>
</tr>
<tr class='warning'>
	<th>La Semana Pasada</th>
	<td><a data-toggle="tooltip" data-original-title="Detalle del importe" data-placement="top" data-fancybox-type='iframe' class='imprime' href='index.php?r=usuarios/items&tipo=week&pasada=1'> <?=Estadisticas::consultar('week','comprobantes',true)?></a></td>
	<td><a data-toggle="tooltip" data-original-title="Detalle del importe" data-placement="top" data-fancybox-type='iframe' class='imprime' href='index.php?r=usuarios/itemsPago&tipo=week&pasada=1'>  <?=Estadisticas::consultar('week','pagos',true)?></a></td>
</tr>
<tr>
	<th>En el Mes</th>
	<td> <a data-toggle="tooltip" data-original-title="Detalle del importe" data-placement="top" data-fancybox-type='iframe' class='imprime' href='index.php?r=usuarios/items&tipo=mes&pasada=0'><?=Estadisticas::consultar('mes','comprobantes')?></a></td>
	<td> <a data-toggle="tooltip" data-original-title="Detalle del importe" data-placement="top" data-fancybox-type='iframe' class='imprime' href='index.php?r=usuarios/itemsPago&tipo=mes&pasada=0'><?=Estadisticas::consultar('mes','pagos')?></a></td>
</tr>
<tr  class='warning'>
	<th>El Mes Pasado</th>
	<td> <a data-toggle="tooltip" data-original-title="Detalle del importe" data-placement="top" data-fancybox-type='iframe' class='imprime' href='index.php?r=usuarios/items&tipo=mes&pasada=1'><?=Estadisticas::consultar('mes','comprobantes',true)?></a></td>
	<td><a data-toggle="tooltip" data-original-title="Detalle del importe" data-placement="top" data-fancybox-type='iframe' class='imprime' href='index.php?r=usuarios/itemsPago&tipo=mes&pasada=1'><?=Estadisticas::consultar('mes','pagos',true)?></a></td>
</tr>
</table>
