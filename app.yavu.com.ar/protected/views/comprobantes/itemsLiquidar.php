<div class=''>
	<div id='itemsParaLiquidar'>
		<i>No hay items para liquidar</i>
	</div>
	<div style="float:right">
		<h4 style='color:red' id='labInteres'>Interés $ 0.00</h4>
		<h4 style='color:green' id='labCredito'></h4>
		<h4 id='labSubTotal'>SUB-TOTAL $ 0.00</h4>
		<h3 id='labTotal'>TOTAL $ 0.00</h3>
	</div>
</div>

<button type="button" style='width:380px'  onclick='abreVentana()' class="btn btn-large btn-success">Liquidar</button>
<script>
function mostrarItems()
{
	var sal="<small><table class='table table-condensed'>";
	sal+="<tbody>";
	sal+="<tr>";
			sal+="<th>Detalle</th>";
			sal+="<th>Interés</th>";
			sal+="<th>Importe</th>";
			sal+="<th></th>";
	sal+="</tr>";
	console.log('agregando itemns');
	for(var i=0;i<seleccion.length;i++){
		sal+="<tr>";
			sal+="<td>";
			sal+=seleccion[i].entidad+'|'+seleccion[i].propiedad+'|'+seleccion[i].detalle+'|';
			sal+="</td>";
			sal+="<td><input type='text' class='span1' onchange='cambiaInteresSeleccion("+i+")' id='interesFacturar_"+i+"' value='";
			sal+=seleccion[i].interes.toFixed(2);
			sal+="'></input></td>";
			sal+="<td><input type='text' class='span1' onchange='cambiaImporteSeleccion("+i+")' id='itemFacturar_"+i+"' value='";
			sal+=seleccion[i].saldo.toFixed(2);
			sal+="' </input></td>";
			sal+="<td style='width:15px'><img title='Quitar Item' onclick='quitarItemSeleccion("+seleccion[i].id+")' style='cursor:pointer' src='images/iconos/glyphicons/glyphicons_199_ban.png'/></td>";
		sal+="</tr>";
	}
	sal+="</tbody>";
	sal+="</table></small>";
	$('#itemsParaLiquidar').html(sal);
}
function quitarItemSeleccion(id)
{
	quitar(id);
	mostrarInfo();
}
function cambiaInteresSeleccion(i)
{
	seleccion[i].interes=$('#interesFacturar_'+i).val()*1;
	mostrarInfo();
}
function cambiaImporteSeleccion(i)
{
	var valor=$('#itemFacturar_'+i).val()*1;
	if(valor> seleccion[i].importe) alert('El valor no puede ser mayor al saldo('+seleccion[i].importe.toFixed(2)+')!');
	else seleccion[i].saldo=valor;
	mostrarInfo();
}
</script>