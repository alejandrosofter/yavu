<?php

class PutoController extends Controller
{
	
	public function actionConsultarSolicitudes()
	{
		$data=SolicitudesServicio::model()->consultar($_GET['q']);
		$this->renderPartial("_solicitudes",array('datos'=>$data));
	}
	public function actionConsultarSolicitudesEstados()
	{
		$data=SolicitudServicioEstados::model()->consultar($_GET['idSolicitud']);
		$this->renderPartial("_solicitudesEstados",array('datos'=>$data));
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

		/**
		* Creates a new model.
		* If creation is successful, the browser will be redirected to the 'view' page.
		*/
	public function actionFacturar()
	{
		if(!isset($_SESSION["paraFacturar"])) $_SESSION["paraFacturar"]=array();
		if(!$this->existe($_GET['idSolicitud']))	$_SESSION["paraFacturar"][]=$_GET['idSolicitud'];
		echo count($_SESSION["paraFacturar"]);
	}
	public function actionFacturarCanasta()
	{
		$items=$_SESSION["paraFacturar"];
		$salida=array();
		foreach($items as $item)$salida[]=SolicitudesServicio::model()->findByPk($item);
	
		echo CJSON::encode($salida);
	}
	public function actionImprimir()
	{
		//include(dirname(__FILE__)."/../extensions/FPDI-1.6.0/fpdi_bridge.php");
		//include(dirname(__FILE__)."/../extensions/FPDI-1.6.0/fpdf_tpl.php");

		$id=$_GET['id'];
		$html=SolicitudesServicio::model()->getImpresion($id);
		$mPDF1 = Yii::app()->ePdf->mpdf();
			$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
			$mPDF1->AddPage('','','','','','','','','','','', 'myHeaderx', 'html_myHeader2x', '', '', 1, 1, 0, 0);
			$mPDF1->Bookmark("Comprobante Servicio",0);

$mPDF1->SetWatermarkText("YAVU");

			$mPDF1->WriteHTML($html);
			 $mPDF1->Output();
			//echo $html;
		
	}
	public function actionVaciarFacturar()
	{
		$_SESSION["paraFacturar"]=array();
	}
	private function existe($idIngresar)
	{
		foreach($_SESSION["paraFacturar"] as $id)
				if($idIngresar==$id)return true;
		return false;
	}
		public function actionCreate()
		{
			$model=new SolicitudesServicio;
			$model->fechaHora=Date("Y-m-d");
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['SolicitudesServicio']))
			{
			$model->attributes=$_POST['SolicitudesServicio'];
			if($model->save()){
				SolicitudServicioEstados::model()->ingresar($model->id,1,Date("Y-m-d"),"INICIO DE SERVICIO");
				$this->redirect(array('index','id'=>$model->id));
			}
			
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
			if(isset($_POST['SolicitudesServicio']))
			{
			$model->attributes=$_POST['SolicitudesServicio'];
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
			if(Yii::app()->request->isPostRequest)
			{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
			else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		/**
		* Lists all models.
		*/
		public function actionIndex()
		{
			$model= new SolicitudesServicio;
			if(isset($_GET['SolicitudesServicio']))$model->buscar=$_GET['SolicitudesServicio']['buscar'];
			$this->render('/solicitudesServicio/index',array(
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
			$model=SolicitudesServicio::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='solicitudes-servicio-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}