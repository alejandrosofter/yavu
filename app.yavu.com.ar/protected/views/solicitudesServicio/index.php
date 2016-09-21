<script src="js/jquery.sticky.js"></script>
<?php
$this->breadcrumbs=array(
	'Solicitudes Servicios',
);

$this->menu=array(
array('label'=>'Nuevo SolicitudesServicio','url'=>array('create')),
);
?>

<h1>SOLICITUDES DE SERVICIO<small> </small></h1>
<div ><input id="busca" placeholder="Busque por apellido u razon social" style="width:350px" type="text"/> <a onclick="buscar()" class="btn btn-primary" id="btnBusca">
	Buscar </a></div>
<div id="solicitudes"></div>
<script>
	$("#solicitudesEstados").stick_in_parent();
consultarSolicitudes();
	function buscar()
	{
		consultarSolicitudes();
	}
function consultarSolicitudes()
	{
		var q=$("#busca").val();
		$.blockUI({ css: { backgroundColor: '#ccc', color: '#fff'},message: '<h1>CARGANDO SOLICITUDES ...</h1>',  });
		$.get("index.php?r=solicitudesServicio/consultarSolicitudes&q="+q,function(data){
			$('#solicitudes').html(data);
		   $.unblockUI();
		});
	}
</script>