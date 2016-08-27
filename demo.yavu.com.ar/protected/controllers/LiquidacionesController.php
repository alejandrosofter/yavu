<?php

class LiquidacionesController extends Controller
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
		public function actionMails()
	{
		$this->layout='//layout/layoutSolo';
		$propietarios=LiquidacionesParaCobrar::model()->porLiquidacion($_GET['id']);
		$this->render('mails',array('propietarios'=>$propietarios));
	}
		public function actionEnviaMail($idParaCobrar,$idLiquidacion)
		{
			
	        	$paraCobrar=ParaCobrar::model()->findByPk($idParaCobrar);
	        	$liquidacion=Liquidaciones::model()->findByPk($idLiquidacion);
	        	$salida=$this->_enviaEmailLiquidacion($idLiquidacion,$paraCobrar->entidad->email);
	        	echo CJSON::encode($salida);
		}
		public function _enviaEmailLiquidacion($idLiquidacion,$destino)
		{
					$mPDF1 = Yii::app()->ePdf->mpdf();
	        		$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
	        		$mPDF1->AddPage('','','','','','','','','','','', 'myHeaderx', 'html_myHeader2x', '', '', 1, 1, 0, 0);
	        		$mPDF1->Bookmark("Planilla de GASTOS",0);
					$mPDF1->WriteHTML($this->actionImprimirGastos($idLiquidacion,true));

					$salida['email']=$destino;
					$mPDF1->AddPage('','','','','','','','','','','', 'myHeaderx', 'html_myHeader2x', '', '', 1, 1, 0, 0);
					$mPDF1->Bookmark('Liquidación  de Expensas',0);
					$mPDF1->WriteHTML($this->actionImprimir($idLiquidacion,true));
					
					$stylesheet = file_get_contents('css/impresion.css');
	        		$mPDF1->WriteHTML($stylesheet, 1);
					$data = $mPDF1->Output('data.pdf', 'S');
					$params['fecha']=Date('d-m-Y');
					$params['titulo']='Liquidacion de Expensas';
					$params['nombreEmpresa']=Settings::model()->getValorSistema('DATOS_EMPRESA_DIRECCION');
					$params['direccion']=Settings::model()->getValorSistema('DATOS_EMPRESA_FANTASIA');
					$params['telefono']=Settings::model()->getValorSistema('DATOS_EMPRESA_TELEFONO');
					$params['emailAdmin']=Settings::model()->getValorSistema('DATOS_EMPRESA_EMAILADMIN');
					$params['cuerpo']=$this->renderPartial('/liquidaciones/comprobanteMail',array(),true);
					$mensaje=Settings::model()->getValorSistema('PLANTILLA_BASE',$params);
			
					$salida['enviado']=Mail::model()->enviarMail($destino,$mensaje,'NUEVA LIQUIDACION EXPENSAS',Settings::model()->getValorSistema('DATOS_EMPRESA_EMAILADMIN'),array($data));
	        		$salida['id']=$idParaCobrar;
	        		return $salida;
		}	

		public function actionImprimirGastos($id,$retorna=false)
		{
			Yii::app()->user->setFlash('info','Presionar la tecla ENTER para realizar la impresion (en caso de no funcionar realizar click sobre la pantalla antes de presionar ENTER)');
			$this->layout="//layouts/layoutSolo";
			$liq=Liquidaciones::model()->findByPk($id);
			$arrFecha=explode('-',$liq->fecha);
			$param['edificio']=$liq->edificio->nombreEdificio;
			$param['mes']=$this->getMes($arrFecha[1]);
			$param['ano']=$this->getAno($liq->fecha);
			$param['cuit']=$liq->edificio->cuit;
			$param['mes']=$this->getMes($arrFecha[1]);
			$param['gastosOrdinarios']=$this->getGrillaGastos($liq,1);
			$param['telefonos']=$liq->edificio->telefono;
			$param['direccion']=$liq->edificio->domicilio;
			$param['lugarPago']=$liq->edificio->lugarPago;
			$param['gastosExtraordinarios']=$this->getGrillaGastos($liq,2);
			$data=Plantillas::model()->getPlantilla ('GASTOS_EXP', $param);
			$model=Comprobantes::model()->findByPk($id);
			if($retorna)return $this->render('impresionGastos',array('model'=>$model,'data'=>$data),$retorna);
			$this->renderPartial('impresionGastos',array('model'=>$model,'data'=>$data),$retorna);
		}
		private function getGrillaGastos($liq,$idTipoGasto)
		{
			$sum=0;
			$totLocal=0;
			$totCoch=0;
			$totDepto=0;
			$cad='<table class="tablaDatos">';
			$cad.='<tr><th style="width:280px">Proveedor</th><th >Concepto</th><th style="width:70px">$ Loc.</th><th style="width:70px">$ Dpto.</th><th style="width:70px">$ Coch.</th><th style="text-align:right;width:80px">Importe</th></tr>';
			foreach($liq->gastos as $item)
				if($item->gasto->idTipoGasto==$idTipoGasto){
					$impLocal=$item->gasto->porcentajeLocal==null?0:($item->gasto->porcentajeLocal->porcentaje/100)*$item->gasto->comprobante->importe;
					$impDepto=$item->gasto->porcentajeDepto==null?0:($item->gasto->porcentajeDepto->porcentaje/100)*$item->gasto->comprobante->importe;
					$impCochera=$item->gasto->porcentajeCochera==null?0:($item->gasto->porcentajeCochera->porcentaje/100)*$item->gasto->comprobante->importe;
						$sum+=$item->gasto->comprobante->importe;
						$totLocal+=$impLocal;
						$totCoch+=$impCochera;
						$totDepto+=$impDepto;
						$cad.='<tr>';
							$cad.='<td>'.$item->gasto->comprobante->entidad->razonSocial.'</td>';
							//$cad.='<td>'.$item->gasto->comprobante->nroComprobante.'</td>';
							$cad.='<td>'.$item->gasto->comprobante->detalle.'</td>';
							$cad.='<td>'.number_format($impLocal,2).'</td>';
							$cad.='<td>'.number_format($impDepto,2).'</td>';
							$cad.='<td>'.number_format($impCochera,2).'</td>';
							
							$cad.='<td style="text-align:right">'.$this->getRow($item->gasto->comprobante,'importe',true).'</td>';
							
						$cad.='</tr>';
			}
			if($liq->importeFondoReserva>0&&$idTipoGasto==2){
				$sum+=$liq->importeFondoReserva;
				$cad.='<tr>';
							$cad.='<td>Otros</td>';
							
							$cad.='<td>A fondo de reserva</td>';
							$cad.='<td></td>';
							$cad.='<td></td>';
							$cad.='<td></td>';
							$cad.='<td style="text-align:right">$ '.number_format($liq->importeFondoReserva,2).'</td>';
							
				$cad.='</tr>';
			}
			$cad.='<tr>';
							$cad.='<td></td>';
							$cad.='<td><b><big>TOTAL</big></b></td>';
							$cad.='<td><b>$ '.number_format($totLocal,2).'</b></td>';
							$cad.='<td><b>$ '.number_format($totDepto,2).'</b></td>';
							$cad.='<td><b>$ '.number_format($totCoch,2).'</b></td>';
							$cad.='<td style="text-align:right"><b><big>$ '.number_format($sum,2).'</big></b></td>';
							
				$cad.='</tr>';
			$cad.='</table>';
			return $cad;
		}
		private function getMes($mes)
	{
		$arr=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$restaMes=Settings::model()->getValorSistema('RESTA_MES_EXPENSAS')+0;
		$ind=$mes-$restaMes-1;
		if($ind<0)$ind=12+$ind;

		return $arr[($ind)];
	}
	private function getAno($fecha)
	{
		$arr=explode('-',$fecha);
		$ano=$arr[0];
		$restaMes=Settings::model()->getValorSistema('RESTA_MES_EXPENSAS')+0;
		$ind=$arr[1]-$restaMes-1;
		if($ind<0)$ano--;
		return $ano;
	}
	public function actionImprimir($id,$retorna=false)
	{
		$this->layout="//layouts/layoutVacio";
		$liq=Liquidaciones::model()->findByPk($id);
		$arrFecha=explode('-',$liq->fecha);
		$param['edificio']=$liq->edificio->nombreEdificio;
		$param['direccion']=$liq->edificio->domicilio;
		$param['cuit']=$liq->edificio->cuit;
		$param['mes']=$this->getMes($arrFecha[1]);
		$param['ano']=$this->getAno($liq->fecha);
		$param['pago']=$liq->edificio->lugarPago;
		$param['telefonos']=$liq->edificio->telefono;
		$param['expensas']=$this->getGrillaExpensas($liq);
		$param['morosos']=$this->getMorosos($liq);
		$data=Plantillas::model()->getPlantilla ('EXPENSAS', $param);
		
		$model=Comprobantes::model()->findByPk($id);
		Yii::app()->user->setFlash('info','Presionar la tecla ENTER para realizar la impresion (en caso de no funcionar realizar click sobre la pantalla antes de presionar ENTER)');
		if($retorna)return $this->render('impresion',array('model'=>$model,'data'=>$data),$retorna);
		$this->renderPartial('impresion',array('model'=>$model,'data'=>$data),$retorna);
	}
	private function getMorosos($liquidacion)
	{
		$cad='<div id="tablaMorosos"><h2>MOROSOS</h2>';
		$cad.='<table  class="tablaDatos">';
		$cad.='<tr><th>Un.Func</th><th style="width:250px">Inquilino</th><th>Meses</th><th style="width:95px">Importe</th></tr>';
		$res=ParaCobrar::model()->morosos($liquidacion->idEdificio,true,null,true);
		foreach($res as $item){
				$cad.='<td>'.$item->propiedad->nombrePropiedad.'</td>';
				$cad.='<td>'.$item->entidad->razonSocial.'</td>';
				$cad.='<td>'.$item->cantidadMeses.'</td>';
				$cad.='<th>$ '.number_format($item->importe,2).'</th>';
			$cad.='</tr>';
		}
			
		$cad.='</table></div>';
		return $cad;
	}
	private function getGrillaExpensas($liquidacion)
	{
		$cad='<table class="tablaDatos">';
		$cad.='<tr><th>Un.Func</th><th>Inquilino</th><th>% U.F.</th><th>% Coch.</th><th>Ord.Depto</th><th>Ext.Depto</th><th>Ord.Coch</th><th>Ext.Coch</th><th>Local</th><th>Esp.</th>';
		//$cad.=$this->imprimeColumnasItems($liquidacion);
		if($liquidacion->importeFondoReserva>0)$cad.='<th>$ fondo.r</th>';
		$cad.='<th>Total</th></tr>';
		foreach($liquidacion->liquidacionesParaCobrar as $item){
			$cad.='<tr>';
				$cad.='<td>'.$item->paraCobrar->propiedad->nombrePropiedad.'</td>';
				$cad.='<td>'.$item->paraCobrar->entidad->razonSocial.'</td>';
				$cad.='<td>'.$item->paraCobrar->propiedad->porcentaje.'</td>';
				$cad.='<td>'.(($item->paraCobrar->propiedad->tieneCochera)?($item->paraCobrar->propiedad->porcentajeCochera):"-").'</td>';


				//$cad.=$this->imprimeItems($item->paraCobrar,$liquidacion);
				$cad.="<td>".number_format($item->paraCobrar->getValor(1,1),2)."</td>"; // (tipoGasto, tipoPropiedad)
				$cad.="<td>".number_format($item->paraCobrar->getValor(2,1),2)."</td>";
				
				$cad.="<td>".number_format($item->paraCobrar->getValor(1,2),2)."</td>";
				$cad.="<td>".number_format($item->paraCobrar->getValor(2,2),2)."</td>";
				$cad.="<td>".number_format($item->paraCobrar->getValor(1,3),2)."</td>";
				$cad.="<td>".number_format($item->paraCobrar->getValor(4,1),2)."</td>";
				if($liquidacion->importeFondoReserva>0)$cad.="<td>$ ".number_format($item->paraCobrar->getValor(3,null),2)."</td>";
				$cad.='<th>'.number_format($item->paraCobrar->importe,2).'</th>';
			$cad.='</tr>';
		}
			
		$cad.='</table>';
		return $cad;
	}
	private function imprimeColumnasItems($liquidacion)
	{
		//<th>% Depto.</th><th>Ordinarias Dpto.</th><th>% Cochera</th><th>Ordinarias Cochera</th><th>Extr. Depto.</th><th>Extr. Cochera</th>
		$cad='';
		foreach(PropiedadesTipos::model()->paraImpresion() as $tipo)
			$cad.="<td>% ".$tipo->nombreTipoCorto."</td>";

		foreach(PropiedadesTipos::model()->paraImpresion() as $tipo)
			foreach(GastosTipos::model()->paraImpresion() as $itemGasto)
				$cad.="<td>".$itemGasto->nombreTipoCorto.' '.$tipo->nombreTipoCorto."</td>";
		
		
		return $cad;
	}
	private function imprimeItems($paraCobrar,$liquidacion)
	{
		$cad='';
		
		foreach(PropiedadesTipos::model()->paraImpresion() as $tipo)
			foreach(GastosTipos::model()->paraImpresion() as $itemGasto)
				$cad.="<td>$ ".number_format($paraCobrar->getValor($itemGasto->id,$tipo->id),2)."</td>";
		return $cad;
	}
	private function getRow($item,$campo,$num=null)
	{
		if($item==null)return '-';
		if($num) return '$ '.number_format($item->$campo,2);
		return $item->coeficiente;
	}

		public function actionView($id)
		{
			$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
		}

		public function actionCreate()
		{
			$model=new Liquidaciones;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Liquidaciones']))
			{
				$model->attributes=$_POST['Liquidaciones'];
				if($model->validate()&&isset($_POST['gastos']))
				if($model->save()){
					Yii::app()->session['idEdificio'] = $model->idEdificio;
					LiquidacionesGastos::model()->cargarGastos($model->id,$_POST['gastos']);
					LiquidacionesParaCobrar::model()->ingresarParaCobrar($model->id);
					Yii::app()->user->setFlash('success', "<b>Exito</b> Se ha creado la Liquidacion satisfactoriamente!");
					$this->redirect(array('index','id'=>$model->id));
					return;
				}
					
			}
			$model->idEdificio=Yii::app()->session['idEdificio'];
			$model->fecha=Date('Y-m-d');
			$model->fechaVto=Date('Y-m-d');
			$this->render('create',array(
				'model'=>$model,
			));
		}

		public function actionIngresar()
		{
			$arrFecha=explode('-',$_GET['fecha']);
			$fecha=$arrFecha[2].'-'.$arrFecha[1].'-'.$arrFecha[0];
			$estado="";
			$arr=Comprobantes::model()->ingresarComprobante($_GET['idEntidad'],$_GET['importe'],$fecha,$_GET['items'],$_GET['interes'],$_GET['bonificacion'],$_GET['estado'],$_GET['idTalonario'],$_GET['idTipoComprobante'],$_GET['nroComprobante'],$_GET['credito']);
			if($arr['id']!=null){
				
				$modelCom=Comprobantes::model()->findByPk($arr['id']);
				$importeResto=$modelCom->importeTotal-$_GET['importePaga']-$_GET['credito'];
				Pagos::model()->ingresaPago($arr['id'],$_GET['importePaga'],$importeResto);
				//ParaCobrar::model()->modificarItems($_GET['items']);
				
				if($importeResto<=0)$modelCom->cancelar();
				$importeResto-=$_GET['credito'];
				Entidades::model()->ingresarCredito($_GET['idEntidad'],$importeResto);
				//$this->ingresarCredito($_GET['idEntidad'],$_GET['importe'],$_GET['items']);
				
			}
			echo CJSON::encode($arr);
		}
		private function enviarMail($id)
		{

		}
		private function ingresarCredito($idEntidad,$importe,$items)
		{
			$resto=$importe-$this->getImporteTotalItems($items);
			Entidades::model()->ingresarCredito($idEntidad,-$resto);
		}
		private function getImporteTotalItems($items)
		{
			$tot=0;
			foreach($items as $item) $tot+=$item['saldo'];
			return $tot;
		}
		public function actionUpdate($id)
		{
			$model=$this->loadModel($id);

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Liquidaciones']))
			{
				$model->attributes=$_POST['Liquidaciones'];
				if($model->save())
					$this->redirect(array('index','id'=>$model->id));
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}

		public function actionQuitarLiquidacion($id)
		{
			try{
				LiquidacionesGastos::model()->cambiarEstado($id,"PENDIENTE");
				LiquidacionesParaCobrar::model()->quitarParaCobrar($id);
				$this->loadModel($id)->delete();
				$this->redirect(array('index'));
				}catch (Exeption $e){
					throw new CHttpException(02,'No puede eliminar la liquidacion ya que pueden existir comprobantes realizados bajo esta liquidación!');
				}
			
		}

		/**
		* Lists all models.
		*/
		public function actionIndex()
		{
			
			$model= new Liquidaciones;
			if(isset($_GET['Liquidaciones'])){
				$model->idEdificio=$_GET['Liquidaciones']['idEdificio'];
				Yii::app()->session['idEdificio'] = $_GET['Liquidaciones']['idEdificio'];

			}else $model->idEdificio=Yii::app()->session['idEdificio'] ;
			
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
			$model=Liquidaciones::model()->findByPk($id);
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
			if(isset($_POST['ajax']) && $_POST['ajax']==='liquidaciones-form')
			{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			}
		}
}
