<!DOCTYPE html>
<html lang="en">
    <head>

  <link rel="stylesheet" type="text/css" href="js/">
  <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Add fancyBox -->
<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.3" type="text/css" media="screen" />
<link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />

<link rel="stylesheet" href="js/chosenv1/chosen.css" type="text/css" media="screen" />
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/chosenv1/chosen.jquery.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/webcam/jquery.webcam.js', CClientScript::POS_HEAD); ?>
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
    </head>
    <body>
<div class="container-fluid">


 <?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    
    'brandUrl'=>'index.php?r=site/usuario',

    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'encodeLabel'=>true,
            'items'=>array(
               
                array('label'=>'Clientes', 'visible'=>Yii::app()->user->checkAccess("Clientes.Index"),'icon'  => 'icon-user', 'url'=>'#', 'items'=>array(                   
                    array('label'=>'Ver Clientes','visible'=>Yii::app()->user->checkAccess("Clientes.Index"), 'url'=>'index.php?r=Clientes'),
                    array('label'=>'Agregar','visible'=>Yii::app()->user->checkAccess("Clientes.Create"), 'url'=>'index.php?r=Clientes/create'),
                )),
                array('label'=>'Servicios', 'visible'=>Yii::app()->user->checkAccess("Servicios.Index"),'icon'  => 'icon-user', 'url'=>'#', 'items'=>array(                   
                    array('label'=>'Ver Servicios','visible'=>Yii::app()->user->checkAccess("Servicios.Index"), 'url'=>'index.php?r=Servicios'),
                    array('label'=>'Agregar','visible'=>Yii::app()->user->checkAccess("Servicios.Create"), 'url'=>'index.php?r=Servicios/create'),
                )),
                array('label'=>'Deudas', 'visible'=>Yii::app()->user->checkAccess("ClientesDeudas.Index"),'icon'  => 'icon-user', 'url'=>'#', 'items'=>array(                   
                    array('label'=>'Ver Ventas','visible'=>Yii::app()->user->checkAccess("ClientesDeudas.Index"), 'url'=>'index.php?r=ClientesDeudas'),
                    array('label'=>'Agregar','visible'=>Yii::app()->user->checkAccess("ClientesDeudas.Create"), 'url'=>'index.php?r=ClientesDeudas/create'),
               )),
                 array('label'=>'Solicitudes AFIP', 'visible'=>Yii::app()->user->checkAccess("solicitudesAfip.Index"),'icon'  => 'icon-user', 'url'=>'#', 'items'=>array(                   
                    array('label'=>'Ver Solicitudes','visible'=>Yii::app()->user->checkAccess("solicitudesAfip.Index"), 'url'=>'index.php?r=solicitudesAfip'),
                    array('label'=>'Agregar','visible'=>Yii::app()->user->checkAccess("solicitudesAfip.Create"), 'url'=>'index.php?r=solicitudesAfip/create'),
               )),
                array('label'=>'Pagos', 'visible'=>Yii::app()->user->checkAccess("Pagos.Index"),'icon'  => 'icon-user', 'url'=>'#', 'items'=>array(                   
                    array('label'=>'Ver Pagos','visible'=>Yii::app()->user->checkAccess("Pagos.Index"), 'url'=>'index.php?r=Pagos'),
                    array('label'=>'Pagos MP','visible'=>Yii::app()->user->checkAccess("PagosMP.Index"), 'url'=>'index.php?r=Pagos/PagosMP'),
                    array('label'=>'Agregar','visible'=>Yii::app()->user->checkAccess("Pagos.Create"), 'url'=>'index.php?r=Pagos/create'),
                )),
              
                 array('label'=>'','encodeLabel'=>true,'icon'  => 'arrow-down white', 'url'=>'#','activeCssClass'=>'icon-user', 'items'=>$this->menu),
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>isset(Yii::app()->user->nombre)?Yii::app()->user->nombre:'','icon'  => 'user white', 'url'=>'#', 'items'=>array(
                   array('label'=>'Datos de Sistema','visible'=>Yii::app()->user->checkAccess("settings.variablesSistema"), 'url'=>'index.php?r=settings/variablesSistema'),
                    
                    array('label'=>'Plantillas','visible'=>Yii::app()->user->checkAccess("plantillas.index"), 'url'=>'index.php?r=plantillas/'),
                    array('label1'=>'Envio de Mails', 'visible'=>Yii::app()->user->checkAccess("mail"),'url'=>'index.php?r=mail'),
                    
                     array('label'=>'Usuarios', 'visible'=>Yii::app()->user->checkAccess("usuarios"),'url'=>'index.php?r=usuarios'),
                    array('label'=>'Logout', 'icon'  => 'circle-arrow-left','url'=>'index.php?r=site/logout'),
                    '--',
                     array('label'=>'Actualizar Adminstrador','visible'=>Yii::app()->user->checkAccess("settings.variablesSistema"), 'url'=>'index.php?r=site/actualizarSistema'),
                    
                     array('label'=>'Actualizar Sistema Gestion','visible'=>Yii::app()->user->checkAccess("settings.variablesSistema"), 'url'=>'index.php?r=site/actualizarSistemaBase'),
                    
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
$(".alert").animate({opacity: 1.0}, 4000).fadeOut("slow");
$('#barraSec').affix();

</script>
<div class="container">
<?=$content?>
</div>

<script>
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
  $('.btn').click(function () {
    $(this).button('loading');
});
$(".imprime").fancybox({
    fitToView : false,
    width   : '920px',
    height    : '100%',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'none',
    closeEffect : 'none'
  });
$(".chico").fancybox({
    fitToView : false,
    width   : '400px',
    height    : '300px',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'none',
    closeEffect : 'none'
  });


</script>
<footer class="footer">
      <div class="container">
        <p>Diseño y programación desarrollado por <a href="http://softer.com.ar" target="_blank">SOFTER.</a></p>
        <p>Cualquier duda o consulta por favor contactar a <a href="mailto:alejandro@softer.com.ar">info@softer.com.ar</a> o bien al 0297-4307553</p>
       
      </div>
    </footer>
</div>
</body>
</html>