<?php

class EntidadesController extends Controller
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
			//'right', // perform access control for CRUD operations
			);
		}
		public function actionGetEntidad($id)
		{
			$model=Entidades::model()->findByPk($id);
			echo CJSON::encode($model);
		}

		public function actionBuscaCreditos($idEntidad)
		{
			$model=Entidades::model()->findByPk($idEntidad);
			echo $model->importeFavor*1;
		}
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
			$model=new Entidades;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Entidades']))
			{
			$model->attributes=$_POST['Entidades'];
			if($model->save()){
				Yii::app()->user->setFlash('success','Se ha cargado con exito!');
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
			if(isset($_POST['Entidades']))
			{
			$model->attributes=$_POST['Entidades'];
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
			$this->redirect(array('index'));
		}

		/**
		* Lists all models.
		*/
		public function actionIndex()
		{
			$model= new Entidades;
			if(isset($_GET['Entidades']))$model->buscar=$_GET['Entidades']['buscar'];
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
			$model=Entidades::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='entidades-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
}
