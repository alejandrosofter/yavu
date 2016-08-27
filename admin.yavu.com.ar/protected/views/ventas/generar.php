<h1>Generar <small> generando archivos</small></h1>

<div id='cargadorArchivos' style="visible:none">
<i>Cargando Archivos ...</i>
<img src='images/loader.gif'/>
</div>
<div id='cargadorBases' style="visible:none">
<i>Cargando Bases ...</i>
<img src='images/loader.gif'/>
</div>
<div id='cargadorDominio' style="visible:none">
<i>Cargando Dominio ...</i>
<img src='images/loader.gif'/>
</div>
<div id='rebootApache' style="visible:none">
<i>Recargando Apache ...</i>
<img src='images/loader.gif'/>
</div>
<script>
$('#cargadorBases').hide();
$('#cargadorDominio').hide();
$('#rebootApache').hide();
copiarArchivos();

function copiarArchivos()
{
	$.get('index.php?r=ventas/copiarArchivos&id=<?=$model->id?>',function (data){
		$('#cargadorArchivos').html("Archivos Copiados/Sincronizados!");
		crearBases();
	});
}
function crearBases()
{
	$('#cargadorBases').show();
	$.get('index.php?r=ventas/crearBases&id=<?=$model->id?>',function (data){
		$('#cargadorBases').html("Bases Creadas!");
		crearDominio();
	});
}
function crearDominio()
{
	$('#cargadorDominio').show();
	$.get('index.php?r=ventas/CrearDominio&id=<?=$model->id?>',function (data){
		$('#cargadorDominio').html("Dominio <b><?=$model->cliente->nombreDominio?>.yavu.com.ar</b> Creado!");
		recargarApache();
	});
}
function recargarApache()
{
	$('#rebootApache').show();
	$.get('index.php?r=ventas/recargarApache',function (data){
		$('#rebootApache').html("Apache <b>recargado</b> !");
	});
}
</script>