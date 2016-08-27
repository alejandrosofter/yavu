<div  style="padding:20px">
<h1>Mailing <small><?=$model->entidad->email==""?"Sin mail":$model->entidad->email?></small></h1>
<form class="form-search">
  <input placeholder="email" id='email' type="text" class="span3" value="<?=$model->entidad->email?>"> 
  <a id='btnEnviar' class="btn btn-primary" onclick='enviarMail()' href="#"><i class="icon-envelope icon-white"></i> Enviar Mail</a>
  <img id='imagen' src='images/loader.gif'/>
</form>

</div>
<script>
$('#imagen').hide();
function enviarMail()
{
	$('#btnEnviar').hide();
	$('#imagen').show();
	$.getJSON( "index.php?r=comprobantes/enviaMailComp",{id:<?=$model->id?>,email:$('#email').val()}, function( data ) {
		alert('Email enviado!');
		$('#btnEnviar').show();
		$('#imagen').hide();
	}).fail(function() {
		alert('No se puede enviar!');
		$('#btnEnviar').show();
		$('#imagen').hide();
	});
}
</script>