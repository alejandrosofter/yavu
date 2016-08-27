<script>
function cambiarRecomendado()
{	
 		var clave='<?=hash("ripemd160", "andatealaputaquetepario")?>';
 		$.get('index.php?r=site/cambiarRecomendado',{hash:clave,nuevoEmail:$('#recomendado').val()},function(data){
 			if(data==''){swal({   title: "Opss..",  text:  "NO EXISTE ESTE MAIL!",  html: true,  type: "error"});return;};
 			if(data=='1'){swal({   title: "Opss..",  text:  "NO TE PODES AUTORECOMENDAR IDOLO :)!",  html: true,  type: "error"});return;};
 			$('#formRecomendado').remove();
 			$('#resCambio').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>BIEN!</strong> Has recomendado y le ayudará a tu recomendado!</div>');
 		});
}
</script>
<h2>TUS RECOMENDADOS <small>en todos los estados</small></h2>
<?php if($cliente['recomendado']==''){?>
	<div id='formRecomendado' class="form-search">
<input style='width:250px;background-color:#BAEABA;color:black' type="text"  id="recomendado" placeholder="EMAIL DE TU RECOMENDADOR">
<button class='btn btn-success'  onclick="cambiarRecomendado()">ACEPTAR</button>
</div>
<?php }?>
<div id='resCambio'></div>
<table class='table table-condensed'>
<tr><th>USUARIO</th><th>EMAIL</th><th>FECHA VTO.</th><th>ESTADO</th></tr>
<?php foreach($data as $item){?>
<tr><td><?=$item['nombreUsuario']?></td><td><?=$item['email']?></td><td><?=Yii::app()->dateFormatter->format("dd/MM/yy",$item['fechaVto'])?></td><td><?=$item['estado']?></td><td> <span style='color:green'><b> + 1</b></span></td></tr>
<?php }?>
<tr><th></th><th></th><th></th><th>TOTAL</th><th><span style='color:green'><b> + <?=count($data)?></b></span></th></tr>
</table>
<?php if(count($data)==0){?>
<small><i>NO TIENES RECOMENDADOS! comienza a recomendar y empieza a ganar!</i></small>
<?php }?>
<small><i>EL IMPORTE A ACREDITAR DEPENDE DEL PLAN QUE ELIJA</i></small><br>
<small><i>SE ACREDITA UNA VEZ QUE A EL RECOMENDADO SE LE <b>ACREDITA EL PAGO</b>!</i></small>
<script>
setTimeout(pop,1000);
function pop()
{
	$('#recomendado').popover({placement:'bottom',content:"<b>  DALE <big style='color:green'> + $10 </big></b> a tu RECOMENDADOR",html:true});
 	$('#recomendado').popover('show');
}

 
 	
</script>