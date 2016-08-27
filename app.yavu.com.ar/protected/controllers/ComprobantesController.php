 <?php

class ComprobantesController extends Controller
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
	            array('allow', // allow authenticated users to access all actions
	            	'users'=>array('@'),
	            	),
	            array('deny'),
	            );
	    }
	    
		public function actionbuscaVencimientos()
		{
			echo $this->renderPartial('/site/aVencer',array('desde'=>$_GET['desde'],'hasta'=>$_GET['hasta'] ,'muestraDeudas'=>isset($_GET['muestraDeudas'])?true:false,'muestraComprobantes'=>isset($_GET['muestraComprobantes'])?true:false,'muestraContratos'=>isset($_GET['muestraContratos'] )?true:false));
		}
		public function actionModificarModeloFactura()
		{
			$data=Plantillas::model()->getPlantilla ("COMPROBANTE");
			$this->render('modificarModeloFactura',array('data'=>$data));
		}
		public function actionLiquidarItems()
		{
			$model=new Comprobantes;
			$pred=Talonarios::getPredeterminado();
			$model->idTipoComprobante=1;
			$model->idTalonario=$pred->id;
			$model->nroComprobante=Talonarios::model()->getProximoNro($pred->id);
			$this->render('liquidarItems',array('model'=>$model
				
			));
		}
		public function actionIngresarComprobante()
		{
			$data=Comprobantes::model()->ingresarComprobante($_GET['pago'],$_GET['datosComprobante'],$_GET['items']);
			if(isset($_GET['enviaMail']) && $data['id']!=null)if($_GET['enviaMail']=='checked')
				$res=Comprobantes::model()->enviarComprobante($data['id'],$_GET['email']);
			if(isset($_GET['guardarMail']))$this->cambiarMailEntidad($_GET['email'],$_GET['datosComprobante']['idEntidad']);
			echo CJSON::encode($data);
		}
		private function cambiarMailEntidad($mail,$idEntidad)
		{
			$model=Entidades::model()->findByPk($idEntidad);
			$model->email=$mail;
			$model->save();
		}
		public function actionAgregarComprobante()
		{
			$receptor=Entidades::model()->findByPk(Settings::model()->getValorSistema('ID_ENTIDAD_DEFECTO'));
			$talPred=Talonarios::model()-> getPredeterminado();
			$params['letra']=$talPred->nombreTipoTalonario;
			$logo="<img src='images/".Settings::model()->getValorSistema("LOGOEMPRESA")."'</img>";
			$params['razonSocial_emisor']=Settings::model()->getValorSistema("LOGOEMPRESA")!=""?$logo:Settings::model()->getValorSistema('DATOS_EMPRESA_RAZONSOCIAL');
			$params['condicionIva_emisor']=Settings::model()->getValorSistema('DATOS_EMPRESA_CONDICIONIVA');
			$params['cuit_emisor']=Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT');
			$params['direccion_emisor']=Settings::model()->getValorSistema('DATOS_EMPRESA_DIRECCION');
			$params['email_emisor']=Settings::model()->getValorSistema('DATOS_EMPRESA_EMAILADMIN');

			$params['verTipo']= ($talPred->letraTalonario=='A' || $talPred->letraTalonario=='B')?"ok":"none";
			$params['detallePago']=array();
			$params['importeIva']=number_format(0,2);
			$params['importeBruto']=number_format(0,2);
			$params['importeTotal']=number_format(0,2);
			$params['cae']='';

			$params['nroComprobante']=str_pad($talPred->proximo, 6,'0', STR_PAD_LEFT);
			$params['fecha']=Yii::app()->dateFormatter->format("dd/MM/yyyy",Date('Y-m-d'));
			$params['razonSocial_receptor']=$receptor->razonSocial;
			
			$params['hayElectronica']=CertificadosElectronicos::model()->hayCertificadoActivo()?1:0;
			$params['idTipoComprobante']=$talPred->id;
			$params['idEntidad']=$receptor->id;

			$params['condicionIva_receptor']=$receptor->condicionIva->nombreIva;
			$params['direccion_receptor']=$receptor->domicilio==''?'s/n':$receptor->domicilio;
			$params['cuit_receptor']=$receptor->cuit;
			$params['items']=Comprobantes::model()->getItemsDefault();
			$params['pie']=Comprobantes::model()->getPieDefault();
			$plantilla=$this->renderPartial('modeloFactura',array('params'=>$params),true);
			$this->render('agregarComprobante',array('plantilla'=>$plantilla,'params'=>$params));
		}
		public function actionIngresar()
		{
			$data=Comprobantes::model()->ingresarComprobante2($_GET['idEntidad'],$_GET['importe'],$_GET['fecha'],isset($_GET['items'])?$_GET['items']:array(),$_GET['interesDescuentos'],$_GET['estado'],$_GET['idTalonario'],$_GET['idTipoComprobante'],$_GET['nroComprobante'],$_GET['credito']);
			if(isset($_GET['enviaMail']))if($_GET['enviaMail']=='checked')$res=Comprobantes::model()->enviarComprobante($data['id'],$_GET['email']);
			echo CJSON::encode($data);
		}

		/**
		* Specifies the access control rules.
		* This method is used by the 'accessControl' filter.
		* @return array access control rules
		*/

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

		/**
		* Creates a new model.
		* If creation is successful, the browser will be redirected to the 'view' page.
		*/
		public function actionCreate()
		{
			$model=new Comprobantes;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Comprobantes']))
			{
			$model->attributes=$_POST['Comprobantes'];
			if($model->save())
			$this->redirect(array('index','id'=>$model->id));
			}
			$tal=Talonarios::getPredeterminado();
			if($tal!=null) $model->idTalonario=$tal->id;
			$model->fecha=Date('Y-m-d');
			$model->estado='CANCELADO';
			$model->idTipoComprobante=1;
			$model->importeFavor=0;
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
			if(isset($_POST['Comprobantes']))
			{
			$model->attributes=$_POST['Comprobantes'];
			if($model->save())
			$this->redirect(array('index','id'=>$model->id));
			}

			$this->render('update',array(
			'model'=>$model,
			));
		}

		public function actionBuscaCreditos()
		{
			$res=Comprobantes::model()->getCreditos($_GET['idEntidad']);
			$res=$this->renderPartial('creditosEntidad',array('data'=>$res),true);
			$arr['data']=$res;
			echo CJSON::encode($arr);
		}
		
	public function actionDescargaPdf()
	{
		//include(dirname(__FILE__)."/../extensions/FPDI-1.6.0/fpdi_bridge.php");
		//include(dirname(__FILE__)."/../extensions/FPDI-1.6.0/fpdf_tpl.php");

		$id=$_GET['id'];
		$html=Comprobantes::model()-> _getTextoComprobate2($id);
		$mPDF1 = Yii::app()->ePdf->mpdf();
			$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
			$mPDF1->AddPage('','','','','','','','','','','', 'myHeaderx', 'html_myHeader2x', '', '', 1, 1, 0, 0);
			$mPDF1->Bookmark("Comprobante",0);

$mPDF1->SetWatermarkText("YAVU");

			$mPDF1->WriteHTML($html);
			 $mPDF1->Output();
			//echo $html;
		
	}
	public function actionImprimir($id)
	{
		Yii::import("ext.EnLetras");
		$this->layout="//layouts/layoutSolo";
		Yii::app()->user->setFlash('info','Presionar la tecla ENTER o <a href="#" onclick="imprimirPapel()">click aqui</a> para realizar la impresion (en caso de no funcionar realizar click sobre la pantalla antes de presionar ENTER)');
		$this->render('impresion',array('texto'=>Comprobantes::model()-> _getTextoComprobate2($id)));
		
	}
	public function actionEnviaEmailComprobante($id)
	{
		$this->layout="//layouts/layoutSolo";
		$model=Comprobantes::model()->findByPk($id);
		$this->render('enviaMails',array('model'=>$model));
	}
	public function actionEnviaMailComp()
	{
		$res=Comprobantes::model()->enviarComprobante($_GET['id'],$_GET['email']);
		$salida['enviado']=$res;
	    $salida['id']=$_GET['id'];
	    
	    echo CJSON::encode($salida);
	}
	
	public function actionActivar($id)
		{
				$model=$this->loadModel($id);
			$model->cambiarEstado("ACTIVA");
				echo 'ok';
			
		}
		public function actionDelete($id)
		{
			
				$model=$this->loadModel($id);
			$model->cambiarEstado("INACTIVA");
				echo 'ok';
			
		}

		/**
		* Lists all models.
		*/
		public function actionIndex()
		{
			$model= new Comprobantes;
			$model->estado="ACTIVA";
			if(isset($_GET['Comprobantes'])){
				$model->buscar=$_GET['Comprobantes']['buscar'];
				$model->estado=$_GET['Comprobantes']['estado'];
			}

			if(!isset($_GET['idTipoOperacion']))$_GET['idTipoOperacion']=1;
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
			$model=Comprobantes::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='comprobantes-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
}
