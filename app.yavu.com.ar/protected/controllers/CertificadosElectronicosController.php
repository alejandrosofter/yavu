<?php

class CertificadosElectronicosController extends Controller
{
		/**
		* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
		* using two-column layout. See 'protected/views/layouts/column2.php'.
		*/
		public $layout='//layouts/column1';

		/**
		* @return array action filters
		*/
		public function filters()
	    {
	        return array( 'accessControl' ); // perform access control for CRUD operations
	    }
	 
	    public function accessRules()
	    {
	        return array(
	        	
	           array('allow', 'users'=>array('@')),
	           array('deny'),
	            
	        );
	    }
	    public function actionSolicitarTramite()
	    {
	    	$cliente=YavuWeb::getCliente();
	    	$this->render('solicitarTramite',array('cliente'=>$cliente));
	    }
    public function actionuploadCert()
    {
    	$output_dir = "certificadosElectronicos/".Yii::app()->user->usuario.'/';
			if(isset($_FILES["myfile"]))
			{
				$ret = array();
				
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
			 	 	$fileName = Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_CERTIFICADO;
			 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
			    	$ret[]= $fileName;
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
			    echo json_encode($ret);
			 }
    }
    private function crearPk()
        {
        	$nomArchivo=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_KEY;
        	$archivoDest=dirname(__FILE__).'/certificadosElectronicos/'.Yii::app()->user->usuario.'/'.$nomArchivo;
            $ruta=dirname(__FILE__).'/../../certificadosElectronicos/'.Yii::app()->user->usuario.'/';
            $rutaDescarga='certificadosElectronicos/'.Yii::app()->user->usuario.'/'.$nomArchivo;
            $direccionDest=$rutaDescarga;
            $archivo=$ruta.$nomArchivo;
           

            $puerto=$_SERVER['SERVER_PORT']=="80"?"":":".$_SERVER['SERVER_PORT'];
            $nombreServidor=$_SERVER['SERVER_NAME'].$puerto;
            
            if(!file_exists($archivo)){
            	if(!file_exists($ruta))mkdir($ruta, 0755, true);
                $com='openssl genrsa -out '.$archivo.' 1024 ';
                
                exec($com);
                
            }
            $com2="ln $archivo $archivoDest";
            exec($com2);
            return $direccionDest;
        }
      
	

	public function actionGuardarCertificado()
        {
          	$ruta=dirname(__FILE__).'/../../certificadosElectronicos/'.Yii::app()->user->usuario.'/';

          	$nomKey=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_KEY;
          	$nomCert = Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_CERTIFICADO;
          	$nomCsr=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_PEDIDO;

          	$id=CertificadosElectronicos::model()->crear($_GET['fechaVto']);
           
            rename($ruta.$nomKey, $ruta.$id.'_'.$nomKey);
            rename($ruta.$nomCert, $ruta.$id.'_'.$nomCert);
            rename($ruta.$nomCsr, $ruta.$id.'_'.$nomCsr);
            
        }
        public function actionTestFinal()
        {
            include dirname(__FILE__).'/facturacionElectronica/FacturaElectronica.php';

            $pk=CertificadosElectronicos::model()->getRutaKey();
            $crt=CertificadosElectronicos::model()->getRutaCertificado();
            $p=new FacturaElectronica($crt,$pk);
            $cuit=isset($_GET['cuit'])?$_GET['cuit']:Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT');
            echo $p->verificar($cuit);
        }
        public function actionTest()
        {
            include dirname(__FILE__).'/facturacionElectronica/FacturaElectronica.php';
          	$ruta=dirname(__FILE__).'/../../certificadosElectronicos/'.Yii::app()->user->usuario.'/';
          	$nomKey=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_KEY;
          	$nomCert = Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_CERTIFICADO;
            $pk=$ruta.$nomKey;
            $csr=$ruta.$nomCert;
            $p=new FacturaElectronica($csr,$pk);
            $cuit=isset($_GET['cuit'])?$_GET['cuit']:Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT');
            echo $p->verificar($cuit);
        }
        public function actionHayPedidoPendiente()
        {
        	$ruta=dirname(__FILE__).'/../../certificadosElectronicos/'.Yii::app()->user->usuario.'/';
        	$nomKey=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_KEY;
        	$pk=$ruta.$nomKey;
        	if(file_exists($pk)) echo true;
        	echo false;
        }
        public function actionHayCertificadoPendiente()
        {
        	$ruta=dirname(__FILE__).'/../../certificadosElectronicos/'.Yii::app()->user->usuario.'/';
        	$nomKey=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_CERTIFICADO;
        	$pk=$ruta.$nomKey;
        	if(file_exists($pk)) echo true;
        	echo false;
        }
        public function actionGenerarCSR()
        {
        	$nomKey=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_KEY;
        	$direccionDest=$this->crearPk();
        	$ruta=dirname(__FILE__).'/../../certificadosElectronicos/'.Yii::app()->user->usuario.'/';
        	$nomPedido=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_PEDIDO;
            $archivo=$ruta.$nomPedido;
            $privada=$ruta.$nomKey;
            $direccionDest="certificadosElectronicos/".$nomPedido;
            $cn=isset($_GET['rz'])?$_GET['rz']:Settings::model()->getValorSistema('DATOS_EMPRESA_RAZONSOCIAL');
            $o='PUNTOVENTA_ELECTRONICO';
            $cuit=isset($_GET['ct'])?$_GET['ct']:Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT');
            $com='openssl req -new -key '.$privada.' -subj "/C=AR/O='.$o.'/CN='.$cn.'/serialNumber=CUIT '.$cuit.'" -out '.$archivo;
            exec($com);
        }
        public function actiondownCSR()
        {
        	$nomPedido=Yii::app()->user->usuario.'_'.CertificadosElectronicos::ARCHIVO_PEDIDO;
            $direccionDest="certificadosElectronicos/".Yii::app()->user->usuario.'/'.$nomPedido;
            Yii::app()->getRequest()->sendFile( $nomPedido , file_get_contents( $direccionDest) );
  			
        }

		/**
		* Displays a particular model.
		* @param integer $id the ID of the model to be displayed
		*/
		public function actionView($id)
		{
			$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
		}
		public function actionAgregarCertificado()
		{
			$this->render('agregarCertificado',array(
			));
		}

		/**
		* Creates a new model.
		* If creation is successful, the browser will be redirected to the 'view' page.
		*/
		public function actionCreate()
		{
			$model=new CertificadosElectronicos;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['CertificadosElectronicos']))
			{
			$model->attributes=$_POST['CertificadosElectronicos'];
			if($model->save())
			$this->redirect(array('index','id'=>$model->id));
			}

			$this->render('create',array(
			'model'=>$model,
			));
		}

		/**
		* Updates a particular model.
		* If update is successful, the browser will be redirected to the 'view' page.
		* @param integer $id the ID of the model to be updated
		*/
		public function actionUpdate($id)
		{
			$model=$this->loadModel($id);
			if(isset($_POST['CertificadosElectronicos']))
			{
			$model->attributes=$_POST['CertificadosElectronicos'];
			if($model->save())
			$this->redirect(array('index','id'=>$model->id));
			}

			$this->render('update',array(
			'model'=>$model,
			));
		}

		/**
		* Deletes a particular model.
		* If deletion is successful, the browser will be redirected to the 'admin' page.
		* @param integer $id the ID of the model to be deleted
		*/
		public function actionDelete($id)
		{
			
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect('usuarios/cuenta');
		}

		/**
		* Lists all models.
		*/
		public function actionIndex()
		{
			$model= new CertificadosElectronicos;
			if(isset($_GET['CertificadosElectronicos']))$model->buscar=$_GET['CertificadosElectronicos']['buscar'];
			$this->render('index',array(
			'dataProvider'=>$model,
			));
		}

		/**
		* Returns the data model based on the primary key given in the GET variable.
		* If the data model is not found, an HTTP exception will be raised.
		* @param integer the ID of the model to be loaded
		*/
		public function loadModel($id)
		{
			$model=CertificadosElectronicos::model()->findByPk($id);
			if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
			return $model;
		}

		/**
		* Performs the AJAX validation.
		* @param CModel the model to be validated
		*/
		protected function performAjaxValidation($model)
		{
			if(isset($_POST['ajax']) && $_POST['ajax']==='certificados-electronicos-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
}
