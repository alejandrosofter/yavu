<h1>Actualizar <small> archivos</small></h1>

<div id='cargadorArchivos' style="visible:none">
<i>Actualizando Archivos ...</i>
<img src='images/loader.gif'/>
</div>
<div id='cargadorBases' style="visible:none">
<i>Actualizando Bases ...</i>
<img src='images/loader.gif'/>
</div>
<script>
$('#cargadorBases').hide();
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
	$.get('index.php?r=ventas/actualizarBases&id=<?=$model->id?>',function (data){
		$('#cargadorBases').html("Bases Creadas!");
	});
}
</script>