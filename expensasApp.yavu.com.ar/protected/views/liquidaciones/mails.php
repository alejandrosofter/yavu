<script>
var arrItems= Array();

function enviarMail(idParaCobrar_,idLiquidacion_)
{
    $('#loader_'+idParaCobrar_).show();
 	$.getJSON( "index.php?r=liquidaciones/enviaMail", {idParaCobrar:idParaCobrar_, idLiquidacion:idLiquidacion_}, function( data ) {
    
    if(data.enviado)
        $('#res_'+idParaCobrar_).attr('class','text-success');
        else{
             $('#res_'+idParaCobrar_).attr('class','text-error');
        }
        $('#loader_'+idParaCobrar_).hide();
 });

}
function enviarTodos()
{
	 $('#boton').hide();
	//console.log(arrItems);	
	for(i=0;i<arrItems.length;i++)
			enviarMail(arrItems[i].idParaCobrar,arrItems[i].idLiquidacion);
	 $('#boton').show();
}
function ingresa(paraCobrar,liquidacion)
{
	var item={idParaCobrar:paraCobrar,idLiquidacion:liquidacion};
	arrItems.push(item);
}
</script>
<div class='container'>
<h1><img src='images/iconos/glyphicons/glyphicons_010_envelope.png'></img> Envio de Mails <small>a los porpietarios/inquilinos:</small></h1>
<a id='boton' onclick="enviarTodos()" class='btn btn-primary'>ENVIAR A TODOS</a>
<?php foreach($propietarios as $prop){
if($prop->paraCobrar->entidad->email!=''){?>
<p id='res_<?=$prop->idParaCobrar?>' class="">Enviar a <strong><?=$prop->paraCobrar->entidad->razonSocial?></strong> al correo <strong><?=$prop->paraCobrar->entidad->email?></strong>
<img style='display: none;' id='loader_<?=$prop->idParaCobrar?>' src='images/loader.gif'/>

<p>
<script>ingresa(<?=$prop->idParaCobrar?>,<?=$prop->idLiquidacion?>)</script>
<?php }else{?>
<p class="muted"><strong><?=$prop->paraCobrar->entidad->razonSocial?></strong> no tiene mail!</p>
<?php }
}
?>

<div id='res'></div>

</div>