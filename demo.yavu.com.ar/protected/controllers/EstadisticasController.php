<?php

class EstadisticasController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	public function init()
	{
		$this->layout="//layouts/column1";
	}

	public function accessRules()
	{
		return array(
		);
	}
	public function actionIndex()
	{
		$this->render('estadisticas',array(
			
		));
	}
	public function actionResultadoExpensas()
	{	
		$edificio=Edificios::model()->findByPk($_GET['idEdificio']);
		$morosos=ParaCobrar::model()->morosos($_GET['idEdificio']);
		$this->renderPartial('resultadoExpensas',array(
			'morosos'=>$morosos,'edificio'=>$edificio
		));
	}

	
	public function actionExpensas()
	{
		$this->render('expensas',array(
			
		));
	}
	public function actionContratos()
	{
		$items=Contratos::model()->findAll();
		$this->render('contratos',array('items'=>$items
			
		));
	}
}
