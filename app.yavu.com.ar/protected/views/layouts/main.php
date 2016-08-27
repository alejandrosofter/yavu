<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="js/loaderAnim/nprogress.css">
  <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/loaderAnim/nprogress.js', CClientScript::POS_HEAD); ?>
  

  <link rel="stylesheet" type="text/css" href="js/">
  <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Add fancyBox -->
<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.3" type="text/css" media="screen" />
<link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
 <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />


<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.3', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5', CClientScript::POS_HEAD); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/print.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/timeago.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/block.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/printThis/printThis.js', CClientScript::POS_HEAD); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/diferenciaFechas.js', CClientScript::POS_BEGIN); ?>

<title><?php echo CHtml::encode($this->pageTitle); ?></title>
 <script>NProgress.start();</script>
    </head>
    <body>
      <script>
   function parse_url(str, component) {
  //       discuss at: http://phpjs.org/functions/parse_url/
  //      original by: Steven Levithan (http://blog.stevenlevithan.com)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  //         input by: Lorenzo Pisani
  //         input by: Tony
  //      improved by: Brett Zamir (http://brett-zamir.me)
  //             note: original by http://stevenlevithan.com/demo/parseuri/js/assets/parseuri.js
  //             note: blog post at http://blog.stevenlevithan.com/archives/parseuri
  //             note: demo at http://stevenlevithan.com/demo/parseuri/js/assets/parseuri.js
  //             note: Does not replace invalid characters with '_' as in PHP, nor does it return false with
  //             note: a seriously malformed URL.
  //             note: Besides function name, is essentially the same as parseUri as well as our allowing
  //             note: an extra slash after the scheme/protocol (to allow file:/// as in PHP)
  //        example 1: parse_url('http://username:password@hostname/path?arg=value#anchor');
  //        returns 1: {scheme: 'http', host: 'hostname', user: 'username', pass: 'password', path: '/path', query: 'arg=value', fragment: 'anchor'}

  var query, key = ['source', 'scheme', 'authority', 'userInfo', 'user', 'pass', 'host', 'port',
      'relative', 'path', 'directory', 'file', 'query', 'fragment'
    ],
    ini = (this.php_js && this.php_js.ini) || {},
    mode = (ini['phpjs.parse_url.mode'] &&
      ini['phpjs.parse_url.mode'].local_value) || 'php',
    parser = {
      php: /^(?:([^:\/?#]+):)?(?:\/\/()(?:(?:()(?:([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?()(?:(()(?:(?:[^?#\/]*\/)*)()(?:[^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
      strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
      loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/\/?)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/ // Added one optional slash to post-scheme to catch file:/// (should restrict this)
    };

  var m = parser[mode].exec(str),
    uri = {},
    i = 14;
  while (i--) {
    if (m[i]) {
      uri[key[i]] = m[i];
    }
  }

  if (component) {
    return uri[component.replace('PHP_URL_', '')
      .toLowerCase()];
  }
  if (mode !== 'php') {
    var name = (ini['phpjs.parse_url.queryKey'] &&
      ini['phpjs.parse_url.queryKey'].local_value) || 'queryKey';
    parser = /(?:^|&)([^&=]*)=?([^&]*)/g;
    uri[name] = {};
    query = uri[key[12]] || '';
    query.replace(parser, function($0, $1, $2) {
      if ($1) {
        uri[name][$1] = $2;
      }
    });
  }
  delete uri.source;
  return uri;
}
      function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
} 
      function numerificar()
      {
        $('.number').keypress(function(event) {
    if(event.which < 46
    || event.which > 59) {
        event.preventDefault();
    } // prevent if not number/dot

    if(event.which == 46
    && $(this).val().indexOf('.') != -1) {
        event.preventDefault();
    } // prevent if already dot
});
      }
$(document).ready(function() {
   numerificar(); 
});
      var start = Date.now();</script>
<div class="container-fluid">


 <?php 
$hayCert=CertificadosElectronicos::model()->hayCertificadoActivo();
$cliente=YavuWeb::getCliente();
$labSaldo=$cliente['importeSaldo']>0?"<span class='label label-warning'>PAGAR</span>":"";
 $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand' => '<img src="img/logoChico.png"/>',
    'brandUrl'=>'index.php?r=usuarios/cuenta',

    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'encodeLabel'=>false,
            'items'=>Usuarios::model()->menuPrincipal($this->menu) ),
      "<div id='loading' style='float:right;color:green;padding-top:10px;padding-left:30px'><img src='images/loader.gif'/></div>",
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'encodeLabel'=>false,
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>Yii::app()->user->usuario,'icon'  => 'user white', 'url'=>'#', 'items'=>array(
                   array( 'linkOptions'=> array('class'=>'recomienda','data-fancybox-type'=>'iframe'),'class'=>'chico','data-fancybox-type'=>'iframe','label'=>'<span style="">Recomendados <b><span class="badge badge-important">'.YavuWeb::consultarRecomendados(true).'</span></b> </span>','icon'  => 'thumbs-up', 'url'=>'index.php?r=site/recomendados'),
       array( 'linkOptions'=> array('class'=>'imprime','data-fancybox-type'=>'iframe'),'label'=>'Mis Datos Empresa','icon'  => 'thumbs-up', 'url'=>'index.php?r=site/editarDatosEmpresa'),
       array( 'linkOptions'=> array('class'=>'imprime','data-fancybox-type'=>'iframe'),'label'=>'Detalle Saldo '.$labSaldo,'icon'  => 'th-list', 'url'=>'index.php?r=site/saldoUsuario'),
      $hayCert?'': array( 'label'=>'Agregar Certificado Electronico','icon'  => 'star-empty', 'url'=>'index.php?r=certificadosElectronicos/agregarCertificado'),
       $hayCert?'': array( 'label'=>'Solicitar Tramite de Certificado AFIP','icon'  => 'share', 'url'=>'index.php?r=certificadosElectronicos/solicitarTramite'),
      
                  // array('label'=>'Datos de Sistema','icon'  => 'cog', 'url'=>'index.php?r=settings/variablesSistema'),
                  //  array('label'=>'Talonarios', 'url'=>'index.php?r=talonarios/index'),
                   // array('class'=>'rojo','label'=>'Ir a WEB', 'url'=>'index.php'),
                   // array('label'=>'Certificados Electronicos', 'url'=>'index.php?r=certificadosElectronicos/index'),
                    //array('label'=>'Plantillas', 'url'=>'index.php?r=plantillas/'),
                   
                  //  array('label'=>'Articulos', 'url'=>'index.php?r=articulos/index'),
                   //  array('label'=>'Usuarios', 'url'=>'index.php?r=usuarios'),
       null,
                    array('label'=>'Logout', 'icon'  => 'circle-arrow-left','url'=>'index.php?r=site/logout'),
                    //array('label'=>'Mis Datos','icon'  => 'user', 'url'=>'index.php?r=usuarios/update&id='.Yii::app()->user->id),
                )),
            ),
        ),
    ),
)); ?>
<div class='bread'>
<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
      'homeLink'=>CHtml::link('Home', array('site/usuario'))
		)); ?>
</div>
<?php
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
    echo '<div style="float:center">';
    foreach($flashMessages as $key => $message) {
        echo '<div class="alert in fade alert-' . $key . '">' . $message . ' <a href="#" class="close" data-dismiss="alert">×</a></div>';
    }
    echo '</div>';
}

?>
<script>
function quitarDeTabla(evt)
{
  var tar=evt.currentTarget.href;
  console.log(evt);
 // swal({   title: "Estas seguro de quitar?",   text: "No podrá recuperar el elemento",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Si, Borrar!",   cancelButtonText: "No, cancelo",   closeOnConfirm: false,   closeOnCancel: false }, function(isConfirm){   if (isConfirm) _quitar(tar) else   swal("Cancelled", "Your imaginary file is safe :)", "error");} });
 console.log(evt);
 swal({   title: "Estas seguro de quitar?",   text: "No podrá recuperar el elemento",  type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Si, Borrar!",   cancelButtonText: "No, cancelo",   closeOnConfirm: false,   closeOnCancel: false }, function(isConfirm){   if (isConfirm) {    _quitar(tar);   } else {     swal("Cancelado", "Tu registro está a salvo", "error");   } });
  // alert(tar);
}
function _quitar(tar)
{
   $.getJSON(tar,function(data){
    swal({   title: "Muy bien!", text: "Se ha quitado el registro!", type:  "success",  type: "success",   showCancelButton: false,   confirmButtonColor: "#58FA58",   confirmButtonText: "Bien hecho!",   closeOnConfirm: true }, function(){   location.reload(); });

  }).fail(function(data){
    sweetAlert("Oops...", "Es posible que el elemento este ligado a otra tabla", "error");
    console.log(data);
  });
}

$(".alert").animate({opacity: 1.0}, 4000).fadeOut("slow");
$('#barraSec').affix();

</script>
<div class="container">
<?=$content?>
</div>

<script>
function str_pad(input, pad_length, pad_string, pad_type) {
  //  discuss at: http://phpjs.org/functions/str_pad/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Michael White (http://getsprink.com)
  //    input by: Marco van Oort
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //   example 1: str_pad('Kevin van Zonneveld', 30, '-=', 'STR_PAD_LEFT');
  //   returns 1: '-=-=-=-=-=-Kevin van Zonneveld'
  //   example 2: str_pad('Kevin van Zonneveld', 30, '-', 'STR_PAD_BOTH');
  //   returns 2: '------Kevin van Zonneveld-----'

  var half = '',
    pad_to_go;

  var str_pad_repeater = function(s, len) {
    var collect = '',
      i;

    while (collect.length < len) {
      collect += s;
    }
    collect = collect.substr(0, len);

    return collect;
  };

  input += '';
  pad_string = pad_string !== undefined ? pad_string : ' ';

  if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
    pad_type = 'STR_PAD_RIGHT';
  }
  if ((pad_to_go = pad_length - input.length) > 0) {
    if (pad_type === 'STR_PAD_LEFT') {
      input = str_pad_repeater(pad_string, pad_to_go) + input;
    } else if (pad_type === 'STR_PAD_RIGHT') {
      input = input + str_pad_repeater(pad_string, pad_to_go);
    } else if (pad_type === 'STR_PAD_BOTH') {
      half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
      input = half + input + half;
      input = input.substr(0, pad_length);
    }
  }

  return input;
}
function validaCuit(sCUIT) 
{ 
    var aMult   = '6789456789'; 
    var aMult   = aMult.split(''); 
    var sCUIT   = String(sCUIT); 
    var iResult = 0; 
    var aCUIT = sCUIT.split(''); 
     
    if (aCUIT.length == 11) 
    { 
        // La suma de los productos 
        for(var i = 0; i <= 9; i++) 
        { 
            iResult += aCUIT[i] * aMult[i]; 
        } 
        // El módulo de 11 
        iResult = (iResult % 11); 
         
        // Se compara el resultado con el dígito verificador 
        return (iResult == aCUIT[10]); 
    }     
    return false; 
} 
function isset(object){
  console.log('existe error?:'+typeof object);
    if (typeof object =='undefined') return false;
    return true;
}

function imprimirPapel(debugFalg)
{
    $(".impresionPapel").printThis({
      debug: debugFalg,             
      importCSS: true,           
      printContainer: false,      
      pageTitle: "",             
      removeInline: false        
  });
}
  $('.btnAccion').click(function () {
    $(this).button('loading');
});
$(".imprime").fancybox({
    fitToView : false,
    width   : '920px',
    height    : '100%',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade'
  });
$(".chico").fancybox({
    fitToView : false,
    width   : '400px',
    height    : '300px',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade'
  });
$(".recomienda").fancybox({
    fitToView : false,
    width   : '550px',
    height    : '100%',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade'
  });
$(".pedido").fancybox({
    fitToView : false,
    width   : '450px',
     afterClose : function() {
        location.reload();
        return;
    },
    height    : '300px',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade'
  });

$('#loading').html((Date.now() - start) + " ms");
NProgress.done();
</script>
<script src="js/sweetalert-master/dist/sweetalert.min.js"></script> <link rel="stylesheet" type="text/css" href="js/sweetalert-master/dist/sweetalert.css">

<footer class="footer">
      <div class="container">
        <p>Diseño y programación desarrollado por <a href="http://yavu.com.ar" target="_blank">YAVU SOFT</a></p>
        <p>Cualquier duda o consulta por favor enviar un correo a <a href="mailto:info@softer.com.ar"><b>info@softer.com.ar</b></a></p>
       
      </div>
    </footer>
</div>
</body>
</html>