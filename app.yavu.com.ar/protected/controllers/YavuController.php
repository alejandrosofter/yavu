<?php
class YavuController extends CController
	{


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
	* @param string el usuario
	* @param string la clave
	* @return string
	* @soap
	*/
	public function loginWeb($usuario,$clave)
	{

		$model=new LoginForm;
		
			
			$model->username=$usuario;
			$model->password=$clave;
			$model->login();
			return Yii::app()->user->usuario;
			
		
		
	}

		/**
		* @return object
		* @soap
		*/
		public function estaLogueado()
		{
			$data['estado']= !Yii::app()->user->isGuest;
			$data['nombreUsuario']=!Yii::app()->user->isGuest?Yii::app()->user->usuario:'';
			return $data;
		}
	}

?>