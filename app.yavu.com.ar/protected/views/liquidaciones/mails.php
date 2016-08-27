<script>
function enviarMail(idParaCobrar_,idLiquidacion_)
{
    $('#loader').show();
 $('#boton').hide();
 $.getJSON( "index.php?r=liquidaciones/enviaMail", {idParaCobrar:idParaCobrar_, idLiquidacion:idLiquidacion_}, function( data ) {
    $('#loader_'+idParaCobrar_).hide();
    if(data.enviado)
        $('#res_'+idParaCobrar_).attr('class','text-success');
        else{
             $('#res_'+idParaCobrar_).attr('class','text-error');
        }
 });
$('#boton').show();
   $('#loader').hide();
}
</script>
<div class='container'>
<h1><img src='images/iconos/glyphicons/glyphicons_010_envelope.png'></img> Envio de Mails <small>a los porpietarios/inquilinos:</small></h1>
<?php foreach($propietarios as $prop){
if($prop->paraCobrar->entidad->email!=''){?>
<p id='res_<?=$prop->idParaCobrar?>' class="muted">Se esta enviando mail a <strong><?=$prop->paraCobrar->entidad->razonSocial?></strong> al correo <strong><?=$prop->paraCobrar->entidad->email?></strong>
<img id='loader_<?=$prop->idParaCobrar?>' src='images/loader.gif'/>

<p>
<script>enviarMail(<?=$prop->idParaCobrar?>,<?=$prop->idLiquidacion?>)</script>
<?php }else{?>
<p class="muted"><strong><?=$prop->paraCobrar->entidad->razonSocial?></strong> no tiene mail!</p>
<?php }
}
?>

<div id='res'></div>

</div>