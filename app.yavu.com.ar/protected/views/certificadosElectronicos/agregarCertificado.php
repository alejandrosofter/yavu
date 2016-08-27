<link href="http://hayageek.github.io/jQuery-Upload-File/4.0.8/uploadfile.css" rel="stylesheet">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/down.js', CClientScript::POS_HEAD); ?>
<script src="http://hayageek.github.io/jQuery-Upload-File/4.0.8/jquery.uploadfile.min.js"></script>
<div>
<h1>Agregar Certificado<small> AFIP</small></h1>
Es indispensable para realizar su <b>FACTURACIÓN ELECTRONICA</b> desde YAVU u otro programa de facturación electronica tener <b> SU CERTIFICADO</b> que
es proveido por AFIP mediante su web y es <b> ÚNICO POR CADA CONTRIBUYENTE</b>. Para eso es necesesario hacer algunos pasos para conseguirlo.
</div>
<br>
<div class='span5'>
<div  id="myCarousel" class="carousel slide">

 <div class="carousel-inner">
	<div class='active item'>
	<h4><img src='images/iconos/glyphicons/glyphicons_150_edit.png'/> <l style='color:'><big>PASO 1/2</big> </l> pedido AFIP</h4>
	<table class='table condensed'>

			<tr><th>Razon Social</th><td><input type='text' style='width:160px' value="<?=Settings::model()->getValorSistema('DATOS_EMPRESA_RAZONSOCIAL')?>" id='razonSocial'></td></tr>
			<tr><th>CUIT (sin guiones)</th><td> <input type='text' style='width:130px' value="<?=Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT')?>" id='cuit'></td></tr>
			
			</table>
			<button style='float:left'  class='btn btn-success' id='btnGenerar' onclick="generar()">GENERAR</button>
			<button style='float:left'  class='btn btn-success' id='btnDown' onclick="descarga()">DESCARGAR</button>
<button style='float:right'  class='btn btn-primary' id='btnPaso2' onclick="clickPaso2()">SIGUIENTE</button>

	</div>
	<div class='item'>
	<h4><img src='images/iconos/glyphicons/glyphicons_150_edit.png'/> <l style='color:'><big>PASO 2/2</big> </l> certificado AFIP</h4>
	<table class='table condensed'>

			<tr><th>Certificado AFIP</th><td style='width:160px'><div id="singleupload"></div></td> <td><span id='hayCert' class="label label-success">CERT SUBIDO!</span></td></tr>
			<tr><th>Fecha Vto.</th><td> <?php $this->widget(
	    'bootstrap.widgets.TbDatePicker',
	    array(
	        'id' => 'fechaVto','name' => 'fechaVto',
	        'htmlOptions' => array('class'=>'span2'),
	    )
	);
	?></td></tr>

			</table>
			<button  class='botonPasos btn btn-primary' id='btnPaso1' onclick="clickPaso1()">ATRAS</button>
			<button style='float:right'  class='btn btn-success' id='btnFinaliza' onclick="test()">FINALIZAR</button>

	</div>
	</div>	

</div>
<div class="form-actions">
	


</div>
</div>
<div class='span3'>
 <a href='index.php?r=certificadosElectronicos/solicitarTramite' class="btn btn-primary btn-large">
 <img style='filter: invert(1);-webkit-filter: invert(1);' src='images/iconos/glyphicons/glyphicons_009_magic.png'/>
      <b>Quiero que YAVU</b> <br> <small>haga el tramite</small>
    </a>
</div>
<div id='resTest' class='span2'>

</div>
<script type="text/javascript">
$('#myCarousel').carousel({
  interval: false
});

function clickPaso1()
{
$('#myCarousel').carousel(0);
$('#btnPaso1').attr('class','btn btn-primary active');
$('#btnPaso2').attr('class','btn btn-primary');
}
function clickPaso2()
{
$('#myCarousel').carousel(1);
$('#btnPaso1').attr('class','btn btn-primary');
$('#btnPaso2').attr('class','btn btn-primary active');
}
Date.isLeapYear = function (year) { 
    return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0)); 
};

Date.getDaysInMonth = function (year, month) {
    return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
};

Date.prototype.isLeapYear = function () { 
    return Date.isLeapYear(this.getFullYear()); 
};

Date.prototype.getDaysInMonth = function () { 
    return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
};

Date.prototype.addMonths = function (value) {
    var n = this.getDate();
    this.setDate(1);
    this.setMonth(this.getMonth() + value);
    this.setDate(Math.min(n, this.getDaysInMonth()));
    return this;
};	


iniciarDescargador();
hayPedido();
hayCertificado();
setFecha()
function iniciarDescargador()
{
	$("#singleupload").uploadFile({
	url:"index.php?r=certificadosElectronicos/uploadCert",
	fileName:"myfile",
	uploadStr:"Subir Certificado",
	multiple:true,
	dragDrop:false,
	maxFileCount:1,
	onSuccess:function(files,data,xhr,pd)
	{
	   hayCertificado();
	   swal({   title: "CERTIFICADO SUBIDO",  text:  "La fecha vto es a 16 meses (si generaste en el día de HOY, si no calcula el vencimiento a 16 meses de la generación en AFIP)!",  html: true,  type: "success"});
				
		setFecha();
		test();
	}
	});
}
function setFecha()
{
	var x = 13; //or whatever offset
		var CurrentDate = new Date();
		CurrentDate.addMonths(x);
		$('#fechaVto').val(CurrentDate.getDate()+'/'+CurrentDate.getMonth()+'/'+CurrentDate.getFullYear());
}
function hayCertificado()
{
	$('#hayCert').hide();
	$.get( "index.php?r=certificadosElectronicos/hayCertificadoPendiente",{  }, function( data ) {
			if(data==1){
				$('#hayCert').show();
				$('#btnFinaliza').prop('disabled', false);  

			}else{
				$('#hayCert').hide();
				$('#btnFinaliza').prop('disabled', true); 
			}
					  		
	});
}
function hayPedido(pasar)
{
	$('#btnGenerar').hide();
	$.get( "index.php?r=certificadosElectronicos/hayPedidoPendiente",{  }, function( data ) {
			if(data!=1){
				$('#btnGenerar').show();
				$('#btnDown').hide();
				$('#btnPaso2').prop('disabled', true); 
			}else {
				$('#btnGenerar').hide();
				if(pasar!=true)$('#myCarousel').carousel('next');
				$('#btnDown').show();	
				$('#btnPaso2').prop('disabled', false); 
			}
					  		
	});
}
function generar()
{
	$.get( "index.php?r=certificadosElectronicos/generarCSR",{ cuit:$('#cuit').val(),razonSocial:$('#razonSocial').val() }, function( data ) {
					hayPedido(true);
					swal({   title: "PEDIDO GENERADO",  text:  "El próximo paso es descargar es descargar el pedido, generar el certificado en AFIP!",  html: true,  type: "success"});
				
					  		
				});
}
function guardarCertificado()
{
	$.get( "index.php?r=certificadosElectronicos/guardarCertificado",{ fechaVto:$('#fechaVto').val() }, function( data ) {
					window.location = "index.php?r=usuarios/cuenta";
					  					
				});
}
function test()
{
	$.blockUI({ message: '<h4><img src="images/loader.gif" /> Aguarde un momento, se está chequeando los certificados...</h4>' });
	$.get( "index.php?r=certificadosElectronicos/test",{ cuit:$('#cuit').val() }, function( data ) {
		$.blockUI({ message: '<h4>'+data+'<h4>' ,timeout:   3000, onUnblock: function(){ guardarCertificado() }  });	
				}).fail(function() {
   $.unblockUI();
   swal({   title: "Opss..",  text:  "Hubo un error en el ingreso del certificado, por favor chequear que el certificado sea valido o bien chequear que se haya pedido correctamente.",  html: true,  type: "error"});
  });
}
function descarga()
{
	$.fileDownload('index.php?r=certificadosElectronicos/downCSR&rz='+$('#razonSocial').val()+'&ct='+$('#cuit').val(), {
    successCallback: function (url) {
 swal({   title: "Opss..",  text:  "Error al descargar!",  html: true,  type: "error"});

    },
    failCallback: function (html, url) {
 
        alert('Your file download just failed for this URL:' + url + '\r\n' +
                'Here was the resulting error HTML: \r\n' + html
                );
    }
});
}

</script>
