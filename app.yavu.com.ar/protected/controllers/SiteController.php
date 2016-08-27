<?php

class SiteController extends Controlador
{
	public $layout='//layouts/column1';

		/**
		* @return array action filters
		*/
		public function filters()
		{
			return array(
			'accessControl', // perform access control for CRUD operations
			);
		}

		  public function actions()
		    {
		        return array(
		            'servicio'=>array(
		                'class'=>'CWebServiceAction',
		            ),
		        );
		    }
    
		/**
		* Specifies the access control rules.
		* This method is used by the 'accessControl' filter.
		* @return array access control rules
		*/
		public function accessRules()
		{
			return array(
				'accessControl'
			);
		}
		public function actionCargarPedido()
		{
			YavuWeb::cargarPedidoAfip($_GET['cuit'],$_GET['clave']);
		}
		public function actionSolicitarCertificado()
		{
			$this->layout="//layouts/layoutSolo";
			$this->render('solicitarCertificado',array());
		}
		public function actionCambiarRecomendado()
		{
			if($_GET['hash']==hash("ripemd160", "andatealaputaquetepario")){
			
				$cliente=YavuWeb::getRecomendador($_GET['nuevoEmail']);
				if(!$cliente){echo '';return;} 
				if($cliente['email']==Yii::app()->user->emailCliente){echo '1';return;} 
				YavuWeb::cambiarRecomendado($_GET['nuevoEmail']);
				echo 'Se cambio Correctamente';
				
			}else echo 'NO TE HAGAS EL VIVO QUE YA SE QUIEN SOS';
		}
		public function actionRecomendados()
		{
			$this->layout="//layouts/layoutSolo";
			$res=YavuWeb::consultarRecomendados();
			$this->render('recomendados',array('data'=>$res,'cliente'=>YavuWeb::getCliente()));
		}
		public function actionGraficaAnual()
		{
			$ano=Date('Y');
			$anoAnterior=$ano-1;
			$data['anoActual']=Estadisticas::graficaAnual($ano);
			$data['anoAnterior']=Estadisticas::graficaAnual($anoAnterior);
			echo CJSON::encode($data);

		}
		public function actionUploadLogo()
    {
    	
    	$output_dir = "assets/";
    	
			if(isset($_FILES["myfile"]))
			{
				$ret = "";
				
			//	This is for custom errors;	
			/*	$custom_error= array();
				$custom_error['jquery-upload-file-error']="File already exists";
				echo json_encode($custom_error);
				die();
			*/
				$error =$_FILES["myfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["myfile"]["name"])) //single file
				{
			 	 	$fileName = $_FILES["myfile"]["name"];
			 	 	
			 	 	$image_name = $_FILES['myfile']['name'];
			 	 	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
			 	 	$ret=Imagenes::model()->guardaLogo($output_dir.$fileName,$image_name);
			 	 	//$im->resizeToWidth($anchoLogo);
			   }
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["myfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
				  	$fileName = $_FILES["myfile"]["name"][$i];
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
				  	$ret[]= $fileName;
				  }
				
				}
			    echo ($ret);
			 }
    }
    public function actionEnviarValidacion()
    {
    	$this->layout="//layouts/layoutSolo";
    	//ENVIO EL MAIL PARA SU VALIDACION

		//$path=dirname(__FILE__).'/../img/logoChicoChico.png';

		//$data = file_get_contents($path);
//		$logo = 'data:image/png;base64,' . base64_encode($data);
    	$cliente=YavuWeb::getCliente();
		$logo='yavu.com.ar/img/logoChicoChico.png';
		$email=$cliente['email'];
		$linkValidar='http://yavu.com.ar/validar.php?q='.$cliente['verificado'];
		$usuario=$cliente['nombreUsuario'];
		$replace = array('{usuario}', '{link}', '{logo}');
		$with = array($usuario, $linkValidar,$logo);

		ob_start();
		$this->renderPartial('/mail/plantilla_verificacionCliente',array());
		$ob = ob_get_clean();

		$mensaje= str_replace($replace, $with, $ob);
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Cabeceras adicionales
		$cabeceras .= 'To: '.$usuario.' <'.$email.'>, '.$usuario.' <'.$email.'>' . "\r\n";
		$cabeceras .= 'From: YAVU <info@yavu.com.ar>' . "\r\n";
		mail($email, "VALIDACION YAVU", $mensaje,$cabeceras);
		$this->render('enviarMail',array());
    }
    public function actionGuardarDatosEmpresa()
    {
    	$edito=Settings::model()->getValorSistema("ACTUALIZO_DATOS")*1;
    	if($edito==0){
    		Settings::model()->setValorSistema("ACTUALIZO_DATOS",1);
    		Yii::app()->user->setFlash('success',"SU YAVU ESTA LISTO PARA OPERAR!");
    	}
    	
    	foreach($_GET as $clave=>$valor){
    		Settings::model()->setValorSistema($clave,$valor);
    	}
    }
    public function actionInicioPrimeraVez()
    {
    	$this->layout="//layouts/layoutSolo";
    	$this->render('inicioPrimeraVez',array());
    }
    public function actionNoVerInicio()
    {
    	Settings::model()->setValorSistema("PRIMERA_VEZ_SISTEMA",0);
    }
    public function actionEditarDatosEmpresa()
    {
    	$this->layout="//layouts/layoutSolo";
    	$logo=Imagenes::model()->getImagen('LOGOEMPRESA',true);
    	$params['logo']=$logo;
			$params['condicionIva']=Settings::model()->getValorSistema('DATOS_EMPRESA_CONDICIONIVA');
			$params['cuit']=Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT');
			$params['razonSocial']=Settings::model()->getValorSistema('DATOS_EMPRESA_RAZONSOCIAL');
			$params['direccion']=Settings::model()->getValorSistema('DATOS_EMPRESA_DIRECCION');
			$params['email']=Settings::model()->getValorSistema('DATOS_EMPRESA_EMAILADMIN');
			$params['localidad']=Settings::model()->getValorSistema('DATOS_EMPRESA_LOCALIDAD');
			$params['provincia']=Settings::model()->getValorSistema('DATOS_EMPRESA_PROVINCIA');
			$params['telefonos']=Settings::model()->getValorSistema('DATOS_EMPRESA_TELEFONO');
			$params['resena']=Settings::model()->getValorSistema('DATOS_EMPRESA_RESENAEMPRESA');
			$params['inicioActividades']=Settings::model()->getValorSistema('DATOS_EMPRESA_INICIOACTIVIDAD');
			$params['ingresosBrutos']=Settings::model()->getValorSistema('DATOS_EMPRESA_INGBRUTOS');
			$params['puntoVenta']=Settings::model()->getValorSistema('DATOS_EMPRESA_PUNTOVENTA');
    	$this->render('/settings/datosEmpresa',array('params'=>$params));
    }
		public function actionCargarPlan()
		{
			YavuWeb::cargarPlan($_GET['idServicio']);
			YavuWeb::cargarSaldo($_GET['idServicio']);
			Yii::app()->user->setFlash('success','EL PLAN A SIDO CARGADO! AHORA REALIZE EL PAGO PARA SEGUIR USANDO YAVU!');
		}
		public function actiongetDatosServicio()
		{
			$servicio=YavuWeb::getServicio($_GET['id']);
			echo CJSON::encode($servicio);
		}
		public function actionCargarNuevoPlan()
		{
			$this->layout='//layouts/layoutSolo';
			$this->render('cargarNuevoPlan',array());
		}
		public function actionSaldoUsuario()
		{
			$this->layout='//layouts/layoutSolo';
			$this->render('saldoUsuario',array());
		}
	
	public function actionEnviarEmail()
	{
		if($this->emailValido($_POST['email'])&&$this->valido($_POST['message'])&&$this->valido($_POST['name'])&&$this->valido($_POST['subject'])){
			$mensajeCliente="Gracias por utilizar nuestra WEB, en la brevedad nos contactaremos con ud. <br> Nombre:".$_POST['name'].'<br> Asunto:'.$_POST['subject']."<br> Mensaje:".$_POST['message']."<br> Email:".$_POST['email'];
			$mensajeEmpresa="Han realizado un comentario en la WEB: <br> Nombre:".$_POST['name'].'<br> Asunto:'.$_POST['subject']."<br> Mensaje:".$_POST['message']."<br> Email:".$_POST['email'];
			Emails::model()->enviarMensajeBase( Settings::model()->getValorSistema('DATOS_EMPRESA_EMAILADMIN'),'Contacto Web',$mensajeEmpresa,$_POST['email']);
			Emails::model()->enviarMensajeBase($_POST['email'],'Contacto Web Insercon',$mensajeCliente);
			$this->redirect('index.php?r=site/contacto');
		}else{
			if(isset($_POST['message']))EUserFlash::setErrorMessage('Hay datos incompletos en el formulario, por favor completelos e intente nuevamente.');
		}
	}
	
		
	private function valido($dato)
	{
		if($dato=='')
            return false;
         return true;
	}
	private function emailValido($mail)
	{
		$validator = new CEmailValidator;
                if($validator->validateValue($mail))
                     return true;
         return false;
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	
	public function actionError()
	{
		$this->layout="//layouts/layoutSolo";
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
	public function actionEnviarDatos()
	{
		$cliente=YavuWeb::getClienteMail($_GET['email']);
		$verificado=hash('ripemd160', $cliente['nombreUsuario'].'andatealaputaquetepario');

		$logo='http://yavu.com.ar/img/logoChicoChico.png';
		$email=$cliente['email'];
		$linkValidar='http://yavu.com.ar/cambiarClave.php?q='.$verificado."&id=".$cliente['id'];
		$usuario=$cliente['nombreUsuario'];
		$replace = array('{usuario}', '{link}', '{logo}');
		$with = array($usuario, $linkValidar,$logo);

		ob_start();
		$this->renderPartial('/mail/plantilla_recuperarClave',array());
		$ob = ob_get_clean();

		$mensaje= str_replace($replace, $with, $ob);
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Cabeceras adicionales
		$cabeceras .= 'To: '.$usuario.' <'.$email.'>, '.$usuario.' <'.$email.'>' . "\r\n";
		$cabeceras .= 'From: YAVU <info@yavu.com.ar>' . "\r\n";
		mail($email, "CAMBIO CLAVE YAVU", $mensaje,$cabeceras);


		if($cliente)echo true; else echo false;
	}
	public function actionIndex()
	{
		$this->redirect('index.php?r=usuarios/cuenta');
	}
	public function actionUsuario()
	{
		if(!isset(Yii::app()->user->esWeb))$this->redirect('index.php?r=site/login');
		if(Yii::app()->user->esWeb){
			$this->redirect('index.php?r=usuarios/miInicio');
		}else{
			$this->layout="//layouts/main";
			$this->render('/site/index');
		}
		
	}
	public function actionAyuda()
	{
		$this->layout="//layouts/layoutSolo";
		$this->render('ayuda',array('archivo'=>$_GET['nombre']));
	}
	public function actionPropiedades()
	{
		$this->layout="//layouts/web";
		$template='thinker_template';
		$contenido=$this->renderPartial('propiedades',array('estilo'=>$estilo,'model'=>Propiedades::model()->inmuebles(Propiedades::ACTIVA)),true);
		$this->render('/site/'.$template,array('template'=>$template,'path'=>'templates/'.$template.'/','contenido'=>$contenido));
	}

	
	public function actionLogin()
	{
		$model=new LoginForm;
		$this->layout = '//layouts/layoutSolo';
		$invalido=false;
		
		// display the login form
		$this->render('login',array());
	}
	public function actionLoginWeb()
	{
		$model=new LoginForm;
		$valido=false;
		if($_SESSION['valido'])
		{
			
			$model->username=$_POST['username'];
			$model->password=$_POST['password'];
			// validate user input and redirect to the previous page if valid
			if($model->login())
				$valido =true;
		}
		echo $valido;
	}
	public function actionLogout()
	{
		if(isset($_COOKIE["logueadoYAVU"]))unset($_COOKIE["logueadoYAVU"]);
		Yii::app()->user->logout();
		unset($_SESSION['usuario']);
		$this->redirect('http://yavu.com.ar');
	}
}