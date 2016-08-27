<style>
.centrado{
    padding-top:150px;
   }
.reflectBelow	{ 
	-webkit-box-reflect: below  400px -webkit-gradient(linear, left top, left bottom, from(transparent), to(rgba(255, 255, 255, 0.2)));
}


</style>
<script src="js/flip-1.0.18/dist/jquery.flip.js"></script>
<div id='login' class='span8 offset2 centrado reflectBelow' >
<div id='log'>
<table class='' >
<tr><td style='width:60px'><img  src='images/logoChicoRevez.png'/></td>
<td style='width:150px'>


			
					<label for="login-username"><big><big>U</big></big>SUARIO</label>
					<input type="text" name='username' id="username"  />
			

			
					<label for="login-password"><big><big>C</big></big>LAVE</label>
					<input type="password" name='password' id="password"  />
		
				<a style='cursor:pointer;width:100%' onclick="ingresar()" id='btnIngresa' class="btn btn-primary"><i class="icon-user icon-white"></i> INGRESAR</a>
			<a onclick='muestra(true)' style='cursor:pointer'><i class="icon-envelope"></i> Dame mis datos de acceso</a>


</td>
</tr>
</table>
</div>
<div id='pass'>
<table class='' >
<tr><td style='width:60px'><img  src='images/logoChicoRevez.png'/></td>
<td style='width:150px'>


			
					<label for="login-username">EMAIL</label>
					<input type="email" id="email" style='widht:100px' />
		
		
				<a style='cursor:pointer;width:100%' id='btnMail' onclick="enviarDatosEmail()" class="btn btn-info">ENVIAR</a>
			<a onclick='muestra(false)' style='cursor:pointer'><i class="icon-arrow-left"></i> Login (atras)</a>


</td>
</tr>
</table>
</div>
</div>
		<script>
		init();
		function init()
		{
			$('#username').val(localStorage.usuario);
			if(localStorage.usuario=='')$('#username').focus();
				else $('#password').focus();
		}
		function datosIngresoValido()
		{
			if($('#username').val()=='')return false;
			if($('#password').val()=='')return false;
			return true;
		}
		function datosEmailValido()
		{
			if($('#email').val()=='')return false;
			return true;
		}
		function enviarDatosEmail()
		{
			if( datosEmailValido()){
				$('#btnMail').button('loading');
				$.get('index.php?r=site/enviarDatos',{email:$('#email').val()},function(data){
				if(data==1){
					$('#btnMail').button('reset');
					swal({   title: "Genial!",  text:  "Te hemos enviado un correo a <b>"+$('#email').val()+"</b>",  html: true,  type: "success"});
					muestra(false);
				}else {
					$('#btnMail').button('reset');
					swal({   title: "Opss..",  text:  "El correo que ingresaste no es válido! intenta con otro por favor",  html: true,  type: "error"});
				} 
			});
			}
			
		else swal({   title: "Opss..",  text:  "Tienes que ingresar una cuenta de correo!",  html: true,  type: "error"});
		}
		
		function ingresar()
		{
			if( datosIngresoValido()){
				$('#btnIngresa').button('loading');
				$.post('index.php?r=site/loginWeb',{username:$('#username').val(),password:$('#password').val()},function(data){
				if(data==1){
					$('#btnIngresa').button('reset');
					localStorage.usuario=$('#username').val();
					var dir='http://app.yavu.com.ar/index.php?r=usuarios/cuenta';
					 window.location.replace (dir);
					
				}else{
					$('#btnIngresa').button('reset');
					swal({   title: "Opss..",  text:  "Los datos que ingresaste no son correctos! por favor vuelve a intentarlo",  html: true,  type: "error"});

				} 
			}).fail(function (data){
				$('#btnIngresa').button('reset');
				swal({   title: "Opss..",  text:  "Los datos que ingresaste no son correctos! por favor vuelve a intentarlo",  html: true,  type: "error"});
			});
			}
			
		else swal({   title: "Opss..",  text:  "Tienes que ingresar los datos de acceso!",  html: true,  type: "error"});
		}
		function muestra(tipo)
		{
			$("#login").flip(tipo);
		}
		$("#login").flip({
			axis:'x',trigger:'manual'
		});
		$('#password').keypress(function(e) {
    if(e.which == 13) {
        ingresar();
    }
});
		</script>