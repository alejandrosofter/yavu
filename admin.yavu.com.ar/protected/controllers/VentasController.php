<?php

class VentasController extends Controller
{
		/**
		* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
		* using two-column layout. See 'protected/views/layouts/column2.php'.
		*/
		public $tokenDigitalOcean="6b7ebde6030ce372cafc2266c5450c219d93851d7c12561cf6815440c2e3cb19";//yavu
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
	            array('allow', // allow authenticated users to access all actions
	                'users'=>array('@'),
	            ),
	            array('deny'),
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
		public function actionCrearDominio($id)
		{
			$model=$this->loadModel($id);
			$etiqueta=$model->nombreDominio;
			echo (shell_exec('./bash/apiOcean '.$etiqueta.'.yavu.com.ar'));
		}
		public function actionCrearBases($id)
		{
			$model=$this->loadModel($id);
			$etiqueta=$model->nombreDominio;
			$this->crearBase($etiqueta);
			$this->cargarData($etiqueta);
		}
		public function actionActivar($id)
		{
			$this->layout="//layouts/layoutSolo";
			$model=$this->loadModel($id);
			$model->estado=1;
			$model->save();
			$output = shell_exec('./bash/cambiarEstado '.$id.' Activo '.$model->nombreDominio);
			echo "<h1>Activado!</h1>";
		}
		public function actionDesactivar($id)
		{
			$this->layout="//layouts/layoutSolo";
			$model=$this->loadModel($id);
			$model->estado=2;
			$model->save();
			$output = shell_exec('./bash/cambiarEstado '.$id.' Inactivo '.$model->nombreDominio);
			echo "<h1>Desactivado $output!</h1>";
		}
		public function actionActualizarBases($id)
		{
			$model=$this->loadModel($id);
			$db=$model->nombreDominio;
			///$output = shell_exec('./bash/bases '.$db); NO ACTUALIZO ASI PORQ EU ME BORRA EL CONTENIDO

		}
		public function actionRecargarApache()
		{
			$output = shell_exec('./bash/scrApache');
			echo $output;
		}
		private function cargarData($db)
		{
			$output = shell_exec('./bash/bases '.$db);

		}
		private function crearBase($db)
		{
			if (!$link = mysql_connect('localhost', 'root', 'vertrigo')) {
    			echo 'Could not connect to mysql';
    		exit;
			}
			$sql    = 'Create database '.$db;
			$result = mysql_query($sql, $link);

		}
		public function actionCopiarArchivos($id)
		{
			$model=$this->loadModel($id);
			$nombreUsuario=$model->nombreDominio;
			$output = shell_exec('./bash/scr '.$nombreUsuario.' '.$id);
			echo $output;
		}
		public function actionCreate()
		{
			$model=new Ventas;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Ventas']))
			{
			$model->attributes=$_POST['Ventas'];
			if($model->save())
			$this->redirect(array('index','id'=>$model->id));
			}

			$this->render('create',array(
			'model'=>$model,
			));
		}
		public function actionActualizar($id)
		{
			$this->layout='//layouts/layoutSolo';
			$model=$this->loadModel($id);
			$this->render('actualiza',array(
			'model'=>$model
			));
		}
		public function actionGenerar($id)
		{
			$this->layout='//layouts/layoutSolo';
			$model=$this->loadModel($id);
			$this->render('generar',array(
			'model'=>$model
			));
		}
		public function actionUpdate($id)
		{
			$model=$this->loadModel($id);
			if(isset($_POST['Ventas']))
			{
			$model->attributes=$_POST['Ventas'];
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
			$this->loadModel($id)->delete();
			$this->redirect( array('index'));
		}

		/**
		* Lists all models.
		*/
		public function actionIndex()
		{
			$model= new Ventas;
			if(isset($_GET['Ventas']))$model->buscar=$_GET['Ventas']['buscar'];
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
			$model=Ventas::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='ventas-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
}
