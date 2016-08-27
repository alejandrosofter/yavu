<h1 >TU PEDIDO <small> a un paso</small></h1>
<dl class="dl-horizontal text-overflow">
  <dt>CUIT</dt>
  <dd><input type='text' id='cuit' style="width:150px" placeholder='cuit'></dd>
  <dt>CLAVE ACCESO</dt>
  <dd><input type='text' id='clave' style="width:140px" placeholder='cuit'></dd>
</dl>
<button style='width:100%' class='btn btn-success' id='btnAceptar' onclick='cargar()'>ACEPTAR</button>
<script type="text/javascript">
	function cargar()
	{
		
		if(datosValidos())_cargar();
			else swal({   title: "Opss..",  text:  "Hay datos que no son válidos!",  html: true,  type: "error"});

	}
	function datosValidos()
	{
		if($('#clave').val()=='') return false;
		if($('#cuit').val()=='') return false;
		return true;
	}
	function _cargar()
	{
		$('#btnAceptar').button('loading');
		$.get('index.php?r=site/cargarPedido',{cuit:$('#cuit').val(),clave:$('#clave').val()},function (data){
			parent.$.fancybox.close();
			$('#btnAceptar').button('reset');
		});
	}
</script>