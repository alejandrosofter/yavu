<?php

class SiteController extends Controller
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
		public function accessRules()
	    {
	        return array(
	        );
		}
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
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
	public function actionActualizarSistema()
	{
		$this->layout="//layouts/main";
		$output = shell_exec('./bash/ejecuta actualizarSistema');
		$this->render('/site/actualizarSistema',array('salida'=>$output));
	}
	public function actionActualizarSistemaBase()
	{
		$this->layout="//layouts/main";
		$output = shell_exec('./bash/ejecuta actualizaSistemaBase');
		$this->render('/site/actualizarSistemaBase',array('salida'=>$output));
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

	public function actionIndex()
	{
		$this->layout="//layouts/main";
		if(isset(Yii::app()->user->id))
			$this->render('/site/index');
			else $this->redirect('index.php?r=site/login');
	}
	public function actionUsuario()
	{
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
	
	public function actionLogin()
	{
		$model=new LoginForm;
		$this->layout = '//layouts/layoutLogin';
		$invalido=false;
		if(isset($_POST['username']))
		{
			
			$model->username=$_POST['username'];
			$model->password=$_POST['password'];
			// validate user input and redirect to the previous page if valid
			if($model->login())
				$this->redirect('index.php?r=usuarios/cuenta');
				
		}
		// display the login form
		$this->render('login',array('model'=>$model,'invalido'=>$invalido));
	}
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('index.php?r=usuarios/cuenta');
	}
}