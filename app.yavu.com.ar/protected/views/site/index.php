<?php
$primeraVez=Settings::model()->getValorSistema('PRIMERA_VEZ_SISTEMA');
if($primeraVez==1){
?>
<a data-toggle="tooltip" data-original-title="Bienvenidos a YAVU" data-placement="top" data-fancybox-type="iframe" class="inicio" href="index.php?r=site/inicioPrimeraVez"><span class="label label-info">INICIO PRIMERA VEZ</span></a>
<?php }?>
<script type="text/javascript">
	iniciaVentanaEditarEmpresa();
	iniciarFancy();
	
	function iniciarFancy()
	{
		$(".nuevoPlan").fancybox({
    fitToView : false,
    afterClose : function() {
        location.reload();
        return;
    },
    width   : '450px',
    height    : '350px',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade'
  });
		$(".inicio").fancybox({
    fitToView : false,
    width   : '640px',
    height    : '450px',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade'
  });
		$(".grillaSaldo").fancybox({
    fitToView : false,
    width   : '820px',
    afterClose : function() {
        location.reload();
        return;
    },
    height    : '100%',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade'
  });
	}
	function abrirVentanaInicio(direc,titulo)
	{
		$.fancybox.open([
    {
        href : direc,
        title : titulo
    },    
], {
    padding : 10   
});
	}
	if('<?=$primeraVez?>'=='1'){
		$(".inicio").eq(0).trigger('click');

	}
function iniciaVentanaEditarEmpresa()
  {
    $(".editarEmpresa").fancybox({
    fitToView : false,
    width   : '920px',
    height    : '100%',
     afterClose : function() {
        location.reload();
        return;
    },
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade'
  });
  }
</script>

<div class='span12'>
	<div class='span4'>
		<?php 
		$deudas=YavuWeb::consultarDeuda();
		
		$ultimaDeuda=$deudas[(count($deudas)-1)];
		$primeraDeuda=$deudas[0];
		

		$dStart = new DateTime(Date('Y-m-d'));
		$dEnd  = new DateTime($cliente['fechaVto']);
		$dDiff = $dStart->diff($dEnd);
		$diasRestan=$dStart>$dEnd?-$dDiff->days:$dDiff->days;
		

		$labelCaduca=$diasRestan>0?($diasRestan.' días'):('<a data-toggle="tooltip" data-original-title="Renovar PLAN" data-placement="top" data-fancybox-type="iframe" class="nuevoPlan" href="index.php?r=site/cargarNuevoPlan"><span class="label label-info">CARGAR NUEVO PLAN!</span></a>');
		
		
		$estado=$cliente['estado'];
		$despliega=$estado=='ACTIVO'?'in':'out';
		$colorEstado=$cliente['estado']=="ACTIVO"?"green":"red";
		$saldo=$cliente['importeSaldo'];
		?>
		<h4><span style='cursor:pointer' data-toggle="collapse" href="#collapseExample" ><img src='images/iconos/glyphicons/glyphicons_150_edit.png'/> <l style='color:'>DATOS</l> de la Empresa</span></h4>
		<div class="collapse <?=$despliega?>" id="collapseExample" >

		<?=Imagenes::model()->getImagen('LOGOEMPRESA',true);?>
			<table class='table condensed'>
				<tr><th>Condición Fiscal</th><td><?=Settings::model()->getValorSistema('DATOS_EMPRESA_CONDICIONIVA')?></td></tr>
				<tr><th>Razón Social</th><td><?=Settings::model()->getValorSistema('DATOS_EMPRESA_RAZONSOCIAL')?></td></tr>
				<tr><th>Cuit</th><td><?=Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT')?></td></tr>
				<tr><th>Localidad</th><td><?=Settings::model()->getValorSistema('DATOS_EMPRESA_LOCALIDAD')?></td></tr>
				<tr><th></th><td>
				<a data-toggle="tooltip" data-original-title="Editar datos de su Empresa" data-placement="top" data-fancybox-type='iframe' class='btn btn-primary editarEmpresa' href='index.php?r=site/editarDatosEmpresa'><i  class="icon-pencil icon-white"></i></a></td></tr>
			</table>
		</div>
		
		<h4><span style='cursor:pointer' data-toggle="collapse" href="#resumenServicio" ><img src='images/iconos/glyphicons/glyphicons_150_edit.png'/> <l style='color:'>SERVICIO</l> <span style='color:<?=$colorEstado?>'> yavu </span></span></h4>
		<div  class="collapse in" id='resumenServicio'>
			<table class='table condensed'>
				<tr><th style='color:<?=$colorEstado?>'>ESTADO</th><td style='color:<?=$colorEstado?>'> <?=$estado?></td></tr>
				<tr><th>Recomendado por...</th><td><?=$cliente['recomendado']==''?'nadie':$cliente['recomendado']?></td></tr>
				<tr><th>Vto. Servicio</th><td><?=Yii::app()->dateFormatter->format("dd/MM/yy",$cliente['fechaVto'])?></td></tr>
				
				<tr><th>Caduca en...</th><td> <?=$labelCaduca?></td></tr>

				<tr><th>SALDO CUENTA</th><td><b> <a data-toggle="tooltip" data-original-title="Ver Saldo!" data-placement="top" data-fancybox-type='iframe' class='grillaSaldo' href='index.php?r=site/saldoUsuario'> $ <?=number_format($saldo,2)?> <span class="label label-info"><?=$saldo>0?"PAGAR AQUI!":""?></span></b></a></td></tr>
				<tr><th></th><td>
				

				</td></tr>
			
			</table>
		</div>
		<?php
		$hayCert=CertificadosElectronicos::model()->hayCertificadoActivo();
		$cert=CertificadosElectronicos::model()->getCertificadoActivo();
		$colorEstadoElectronica=$hayCert?'green':'red';
		$estadoElectronica=$hayCert?'SI':'INHABILITADA';
		$fechaEmi=$hayCert?Yii::app()->dateFormatter->format("dd/MM/yyyy",$cert->fechaExpira):'-';
		$fechaVtoCert=$hayCert?Yii::app()->dateFormatter->format("dd/MM/yyyy",$cert->fechaCreacion):'-';
		$pA='-';
		$pB='-';
		$pC='-';
		?>
		<?php if($estado=='ACTIVO'){?>
		<h4><span style='cursor:pointer' data-toggle="collapse" href="#resumenElectronica" ><img src='images/iconos/glyphicons/glyphicons_150_edit.png'/> <l style='color:'>FACTURACIÓN </l> <span style="color:<?=$colorEstadoElectronica?>">electronica</span></span></h4>
		
		
		<div  class="collapse <?=$despliega?>" id='resumenElectronica'>
		<table class='table condensed'>
			<tr><th style='color:<?=$colorEstadoElectronica?>'>ESTADO</th><td style='color:<?=$colorEstadoElectronica?>'> <?=$estadoElectronica?></td></tr>
			<tr><th>Emisión</th><td><?=$fechaEmi?></td></tr>
			<tr><th>Vto. Cert</th><td><?=$fechaVtoCert?></td></tr>
			
			<tr><th><?php if($hayCert){?><button id='btnTest' class='btn btn-success' onclick='testCertificado()'>TEST CERTIFICADO</button></td><?php }?></th><td> <?php if(!$hayCert){?><a  href='index.php?r=certificadosElectronicos/AgregarCertificado' class="btn btn-primary"><b>AGREGAR</b> CERT.</a> <?php }?></td></tr>
		</table>
		</div>
		<?php }?>
	</div>
	<div class='span5'>
	
	<?=$this->renderPartial('resumenCuenta',array());?>
	<?=$this->renderPartial('/site/graficoAnual',array());?>
	</div>
	

	
</div>

<script type="text/javascript">

	

	function testCertificado()
	{
		$('#btnTest').button('loading');
		$.get( "index.php?r=certificadosElectronicos/testFinal", function( data ) {
			$('#btnTest').button('reset');
			swal({   title: "RESULTADO!",   text: data,   html: true });
		});
	}
	

</script>