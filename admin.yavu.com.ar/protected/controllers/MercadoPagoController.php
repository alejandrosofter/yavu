<?php

class MercadoPagoController extends Controller
{
		public $layout='//layouts/column1';

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

		public function actionCrearTestUser()
		{
			require_once dirname(__FILE__)."/../extensions/MP/mercadopago.php";
			$mp = new MP('5839987130287087', 'v5vbB8PyLJy7l48TH8zWjbyHKSWpthBF');
			var_dump($mp->get_access_token());
		}

		
}

