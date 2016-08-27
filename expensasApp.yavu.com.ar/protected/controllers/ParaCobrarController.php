<?php

class ParaCobrarController extends Controller
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

		public function actionItems($id)
        {
                $this->layout="//layouts/layoutSolo";
                $items=ParaCobrarItems::model()->items($id);
                $this->render('items',array('items'=>$items));
        }
        public function actionDetalleMora()
        {
        	$this->layout="//layouts/layoutSolo";
        	$model=ParaCobrar::model()->morosos($_GET['idEdificio'],false,$_GET['idPropiedad']);
        	$entidad=Entidades::model()->findByPk($_GET['idEntidad']);
        	$this->render('detalleMora',array(
			'model'=>$model,'entidad'=>$entidad
			));

        }
        public function init()
        {
                $this->layout="//layouts/column1";
        }
        public function actionGetDeuda()
        {
                $res=ParaCobrar::model()->busqueda($_GET['idPropiedad']);
                $cad=$this->renderPartial('vistaDeudas',array(
                        'res'=>$res
                ),true);
                $data['data']=$cad;
                echo CJSON::encode($data);
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
			$model=new ParaCobrar;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['ParaCobrar']))
			{
			$model->attributes=$_POST['ParaCobrar'];
			if($model->save()){
				Yii::app()->user->setFlash('success','Se ha cargado con exito!');
				$this->redirect(array('index','id'=>$model->id));
			}
			
			}
			$model->estado=ParaCobrar::PENDIENTE;
			$model->fecha=Date('Y-m-d');
			$this->render('create',array(
			'model'=>$model,
			));
		}
		public function actionGetParaCobrar($id)
		{
			$pc=ParaCobrar::model()->with('entidad','propiedad')->findByPk($id);
			$sal=array();
			$sal['data']=$pc;
			$sal['entidad']=$pc->entidad;
			$sal['propiedad']=$pc->propiedad;
			echo CJSON::encode($sal);
		}

		/**
		* Updates a particular model.
		* If update is successful, the browser will be redirected to the 'view' page.
		* @param integer $id the ID of the model to be updated
		*/
		public function actionUpdate($id)
		{
			$model=$this->loadModel($id);
			if(isset($_POST['ParaCobrar']))
			{
			$model->attributes=$_POST['ParaCobrar'];
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
			try{
				$this->loadModel($id)->quitar();
				$this->redirect(array('/paraCobrar'));
			} catch (Exception $e) {
				 throw new CHttpException(01,'No se puede eliminar por que existe dependencias! Debe eliminar primero la liquidación');
			}
			
		}

		/**
		* Lists all models.
		*/
		public function actionIndex()
		{
			
			$model= new ParaCobrar;
			if(isset($_GET['ParaCobrar']))$model->buscar=$_GET['ParaCobrar']['buscar'];
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
			$model=ParaCobrar::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='para-cobrar-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
}
