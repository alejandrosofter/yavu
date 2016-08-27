<?php

class PagosController extends Controller
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
			return array(
			'accessControl', // perform access control for CRUD operations
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
			);
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
		public function actionCreate()
		{
			$model=new Pagos;
			if(isset($_GET['id']))$model->idComprobante=$_GET['id'];
			$model->fecha=Date('Y-m-d');
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Pagos']))
			{
			$model->attributes=$_POST['Pagos'];
			if($model->save())
			$this->redirect(array('index','id'=>$model->idComprobante));
			}
			
			$this->render('create',array(
			'model'=>$model,
			));
		}
		public function actionCrear()
		{
			$comp=Comprobantes::model()->findByPk($_GET['idComprobante']);
			$arr=explode('-',$_GET['fecha']);
			$fe=$arr[2].'-'.$arr[1].'-'.$arr[0];
			$sal=1;
			$model=new Pagos;
			$model->idComprobante=$_GET['idComprobante'];
			$model->fecha=$fe;
			$model->importe=$_GET['importe'];
			$model->idFormaPago=$_GET['idFormaPago'];
			if($model->save())$sal=0;
			$salida['saldo']=number_format($comp->getSaldo(),2);
			echo CJSON::encode($salida);
		}

		/**
		* Updates a particular model.
		* If update is successful, the browser will be redirected to the 'view' page.
		* @param integer $id the ID of the model to be updated
		*/
		public function actionUpdate($id)
		{
			$model=$this->loadModel($id);
			if(isset($_POST['Pagos']))
			{
			$model->attributes=$_POST['Pagos'];
			if($model->save())
			$this->redirect(array('index','id'=>$model->idComprobante));
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
			
			$model=$this->loadModel($id);
			$comp=$model->comprobante;

			$model->delete();
			$salida['saldo']=number_format($comp->getSaldo(),2);
			echo CJSON::encode($salida);
			
		}

		/**
		* Lists all models.
		*/
		
		public function actionIndex()
		{
			$model= new Pagos;
			if(isset($_GET['Pagos']))$model->buscar=$_GET['Pagos']['buscar'];
			if(isset($_GET['id']))$model->idComprobante=$_GET['id'];
			$this->render('index',array(
			'dataProvider'=>$model,
			));
		}
		public function actionVerPagos()
		{
			$model= new Pagos;
			$comprobante=Comprobantes::model()->findByPk($_GET['idComprobante']);
			if(isset($_GET['Pagos']))$model->buscar=$_GET['Pagos']['buscar'];
			if(isset($_GET['id']))$model->idComprobante=$_GET['id'];
			$this->renderPartial('verPagos',array(
			'model'=>$model->search(),'comprobante'=>$comprobante
			));
		}

		/**
		* Returns the data model based on the primary key given in the GET variable.
		* If the data model is not found, an HTTP exception will be raised.
		* @param integer the ID of the model to be loaded
		*/
		public function loadModel($id)
		{
			$model=Pagos::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='pagos-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
}
