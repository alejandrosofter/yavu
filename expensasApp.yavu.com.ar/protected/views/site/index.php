<div class='span12'>
	<h3><img src='images/iconos/glyphicons/glyphicons_049_star.png'/> BIENVENIDO <strong><?=Settings::model()->getValorSistema('DATOS_EMPRESA_RAZONSOCIAL')?>!</strong></h3>
	<div class='span3'>
		<img src='images/iconos/glyphicons/glyphicons_411_package.png'/> 
		<big><a href='index.php?r=liquidaciones/create'><b>Nueva</b> Liquidacion</a></big>
		<?php $this->renderPartial('/liquidaciones/ultimas')?>
		<hr>
		<img src='images/iconos/glyphicons/glyphicons_309_comments.png'/>
		<a href='index.php?r=propiedadesConsultas/create'><b>Nueva</b> Consulta Propiedad</a>
		<?php $this->renderPartial('/propiedadesConsultas/ultimas')?>
		<hr>
		<img src='images/iconos/glyphicons/glyphicons_150_edit.png'/>
		<a href='index.php?r=Comprobantes/create'><b>Nuevo</b> Comprobante</a>
		<?php $this->renderPartial('/comprobantes/ultimas')?>
	</div>
	<div class='span3'>
		<img src='images/iconos/glyphicons/glyphicons_132_inbox_minus.png'/>
		<a href='index.php?r=Comprobantes/LiquidarItems'><b>Cobrar</b> (liquidar deuda)</a>
		<?php $this->renderPartial('/paraCobrar/ultimas')?>
		<hr>
		<img src='images/iconos/glyphicons/glyphicons_036_file.png'/> 
		<a href='index.php?r=contratos/create'><b>Nuevo</b> Contrato</a>
		<?php $this->renderPartial('/contratos/ultimos')?>
		<hr>
		<img src='images/iconos/glyphicons/glyphicons_135_inbox_out.png'/>
		<a href='index.php?r=Gastos/create'><b>Agregar</b> gastos (expensas)</a>
		<?php $this->renderPartial('/gastos/ultimas')?>
		
	</div>
	<div class='span5'>
		<h3><img src='images/iconos/glyphicons/glyphicons_266_flag.png'/> Vencimientos <small></small></h3>
		Desde <input onchange="buscarVencimientos()"  type='text' style='width:30px' id='desde' value='<?=Settings::model()->getValorSistema('CANTIAD_DESDE_VENC')?>'></input> 
		Hasta <input onchange="buscarVencimientos()"  type='text' style='width:30px' id='hasta' value='<?=Settings::model()->getValorSistema('CANTIAD_HASTA_VENC')?>'></input>
	
		<div style='float:right'>
			| Deudas <input onchange="buscarVencimientos()"  id="muestraDeudas" value="1" checked type="checkbox">
			| Contratos <input onchange="buscarVencimientos()"  id="muestraContratos" value="1" checked type="checkbox">
			| Compr. <input onchange="buscarVencimientos()"  id="muestraComprobantes" value="1" checked type="checkbox">
		</div>
		
		<div id='contenedorVencimientos'></div>
	</div>
	

	
</div>

<script type="text/javascript">
buscarVencimientos();
function buscarVencimientos()
{
	$.get( "index.php?r=comprobantes/buscaVencimientos",{desde:$('#desde').val(),hasta:$('#hasta').val(),muestraContratos:$( "#muestraContratos" ).attr('checked'),muestraDeudas:$( "#muestraDeudas" ).attr('checked'),muestraComprobantes:$( "#muestraComprobantes" ).attr('checked')}, function( data ) {
	$('#contenedorVencimientos').html("-");
		$('#contenedorVencimientos').html(data);
	});
}
</script>