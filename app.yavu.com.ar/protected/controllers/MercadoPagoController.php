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
		public function actionIndex()
		{
			echo 'OK';
		}
		public function actionCrearTestUser()
		{
			require_once dirname(__FILE__)."/../extensions/sdk-php-master/lib/mercadopago.php";
			$mp = new MP('5839987130287087', 'v5vbB8PyLJy7l48TH8zWjbyHKSWpthBF');
			$preference = $mp->get_preference("PREFERENCE_ID");

print_r ($preference);
		}

		
}

