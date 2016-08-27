<?php

class ClientesController extends Controller
{
		public function actions()
	    {
	        return array(
	            'servicios3'=>array(
	                'class'=>'CWebServiceAction',
	            ),
	        );
	    }
	    /**
	     * @param string 
	     * @return float 
	     * @soap
	     */
	    public function getSaldo($idVenta)
	    {
	    	$venta=Ventas::model()->findByPk($idVenta);
	        return $venta->cliente->importeSaldo;
	    }
	    
	    /**
	     * @param string 
	     * @return string 
	     * @soap
	     */
	    public function getVencimiento($idVenta)
	    {
	    	$venta=Ventas::model()->findByPk($idVenta);
	        return $venta->ultimaDeuda->fechaVto;
	    }
	    /**
	     * @param int 
	     * @param float 
	     * @return string 
	     * @soap
	     */
	    public function modificarSaldo($idVenta)
	    {
	    	$model=Ventas::model()->findByPk($idVenta);

	    	Pagos::model()->agregarSaldo($model->ultimoPago->id);
	    }

	     /**
	     * @param int 
	     * @return string 
	     * @soap
	     */
	    public function getNombreCliente($idVenta)
	    {
	    	$venta=Ventas::model()->findByPk($idVenta);
	        return $venta->cliente->razonSocial;
	    }
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
		public function actionCambiaSaldo($id)
		{
			$this->layout="//layouts/layoutSolo";
			$model=$this->loadModel($id);
			if(isset($_POST['Clientes']))
			{
				$importeAnterior=$model->importeSaldo;
				$model->attributes=$_POST['Clientes'];
				$importe=$model->importeSaldo-$importeAnterior;
				$this->agregarSaldo($importe,$model->id);
				Yii::app()->user->setFlash('success','Se han '.($importe<0?"quitado":"agregado").'<b> $ '.number_format($importe,2).'</b> '.($importe<0?"de":"en").' la cuenta ! ');
			}

			$this->render('cambiaSaldo',array(
			'model'=>$model,
			));
		}
		public function agregarSaldo($importe,$idCliente)
		{
			$cliente=Clientes::model()->findByPk($idCliente);
			$cliente->importeSaldo+=$importe;
			$cliente->save();
			Ventas::model()->agregarQuitarDeuda($importe,$idCliente);
		}

		/**
		* Creates a new model.
		* If creation is successful, the browser will be redirected to the 'view' page.
		*/
		public function actionCreate()
		{
			$model=new Clientes;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Clientes']))
			{
			$model->attributes=$_POST['Clientes'];
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
			if(isset($_POST['Clientes']))
			{
			$model->attributes=$_POST['Clientes'];
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
			$model= new Clientes;
			if(isset($_GET['Clientes']))$model->buscar=$_GET['Clientes']['buscar'];
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
			$model=Clientes::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='clientes-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
}
