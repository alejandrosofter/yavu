<h1>NUEVO PLAN <small> servicio</small></h1>
Por favor elija que plan desea adquirir: <br>
<div  class="btn-group" id='servicio' data-toggle="buttons-radio">
  <button onclick="cambia()" type="button" value='2' class="btn btn-primary active" >Mensual</button>
  <button onclick="cambia()" type="button" value='4' class="btn btn-primary">Trimestral</button>
  <button onclick="cambia()" type="button" value='5' class="btn btn-primary">Semestral</button>
  <button onclick="cambia()" type="button" value='6' class="btn btn-primary">Anual</button>
</div>

<table>
<tr><th style='text-align:right'>SERVICIO:</th><td id='nombreServicio'></td></tr>
<tr><th style='text-align:right'>CANTIDAD DE MESES:</th><td id='cantidadMeses'></td></tr>
<tr><th style='text-align:right'>FECHA INICIO:</th><td id='fechaInicio'></td></tr>
<tr><th style='text-align:right'>FECHA VTO:</th><td id='fechaVto'></td></tr>
<tr><th style='text-align:right'>IMPORTE: $</th><td ><h4 id='importeServicio' style='text-style:bold'></h4></td></tr>
</table>
<button onclick="cargar()" style='width:100%' type="button" value='6' class="btn btn-success">ACEPTAR</button>
<script>
cambia();
var idServicioSeleccion=2;
function cambia2()
{
	$('#servicio .btn.active').each(function() {
		idServicioSeleccion=this.value;
   		getDatosServicio(idServicioSeleccion);
});
}
function cambia()
{
	setTimeout(cambia2,200);
}
function cargar()
{
	swal({   title: "Estas seguro/a de asignarte este plan?",   text: "Una vez cargado el plan no lo podrá cambiar...",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#7ccd7c",   confirmButtonText: "SI ACEPTAR!",   closeOnConfirm: false },function(){  _cargar();});
	
}
function _cargar()
{
	$.getJSON('index.php?r=site/cargarPlan',{idServicio:idServicioSeleccion},function(data){
		parent.$.fancybox.close();
	});
}
function getDatosServicio(id)
{

	$.getJSON('index.php?r=site/getDatosServicio',{id:id},function(data){
		var fechaInicio= new Date(data.fechaInicio);
		fechaInicio=(fechaInicio.getDate() + 1) + "/" + fechaInicio.getMonth() + "/" + fechaInicio.getFullYear();

		var fechaVto= new Date(data.fechaVto);
		fechaVto=(fechaVto.getDate() + 1) + "/" + fechaVto.getMonth() + "/" + fechaVto.getFullYear() + " a las "+fechaVto.getHours()+" hrs";

		$('#nombreServicio').html(data.nombreServicio);
		$('#cantidadMeses').html(data.duracion+' Mes/es');
		$('#fechaInicio').html(fechaInicio);
		$('#fechaVto').html(fechaVto);
		$('#importeServicio').html((data.importeServicio));
	});
}
</script>