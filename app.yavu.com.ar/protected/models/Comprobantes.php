<?php

/**
 * This is the model class for table "comprobantes".
 *
 * The followings are the available columns in table 'comprobantes':
 * @property integer $id
 * @property integer $idEntidad
 * @property double $importe
 * @property string $detalle
 * @property string $fecha
 * @property string $estado
 * @property string $nroComprobante
 * @property integer $idTipoComprobante
 *
 * The followings are the available model relations:
 * @property Entidades $idEntidad0
 * @property ComprobantesTipos $idTipoComprobante0
 * @property ComprobantesComprobantes[] $comprobantesComprobantes
 * @property ComprobantesComprobantes[] $comprobantesComprobantes1
 * @property Gastos[] $gastoses
 * @property LiquidacionesItemsComprobantes[] $liquidacionesItemsComprobantes
 */
if(isset(Yii::app()->user->usuario))
	include_once(dirname(__FILE__)."/../controllers/facturacionElectronica/FacturaElectronica.php");
class Comprobantes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comprobantes the static model class
	 */
	public $buscar;
	const CANCELADO='CANCELADO';
	const PENDIENTE='PENDIENTE';
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getPieDefault()
	{
		$cad="<table class='table bordered' style='width:70px'>";
		$cad.="</table>";

		return $cad;
	}
	public function getItemsDefault()
	{
		$cad="	";

		return $cad;
	}
	public function week($anterior=false,$resultadosArray=false)
	{
		$dias=$anterior?"-10":"0";
		$anterior="DATE_ADD(curdate(),INTERVAL ".$dias." DAY)";
		$resultados=$resultadosArray?"*":"sum(importe) as importe";
		$connection=Yii::app()->getDb();
        $sql="SELECT ".$resultados." from comprobantes t WHERE yearweek(fecha)=yearweek(".$anterior.") AND estado='ACTIVA' order by fecha";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        if($resultadosArray) return $res;
        if(count($res)>0)return $res[0]['importe'];
        return 0;
	}
	public function mes($anterior=false,$resultadosArray=false)
	{
		$dias=$anterior?"-31":"0";
		$anterior="DATE_ADD(curdate(),INTERVAL ".$dias." DAY)";
		$resultados=$resultadosArray?"*":"sum(importe) as importe";
		$connection=Yii::app()->getDb();
        $sql="SELECT ".$resultados." from comprobantes t WHERE month(fecha)=month(".$anterior.") AND estado='ACTIVA' order by fecha";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        if($resultadosArray) return $res;
        if(count($res)>0)return $res[0]['importe'];
        return 0;
	}
	private function getSemana($dia)
	{
		$semana="SELECT WEEK(  '2015-10-04', 7 ) - WEEK( DATE_SUB(  '2015-10-04', INTERVAL DAYOFMONTH(  '2015-10-04' ) -1
DAY ) , 7 ) +1";
		$dia=2;
		if($dia>=1 && $dia<=7)return "fecha>=";
		if($dia>7 && $dia<=14)return 2;
		if($dia>14 && $dia<=21)return 3;
		return 4;
	}
	public function restaurarQuitar()
	{
		$model=$this;
		$model->quitarItems();
		$model->quitarPagos();
		Entidades::model()->ingresarCredito($model->idEntidad,-$model->importeFavor);
		$model->delete();
	}
	public function quitarItems()
	{
		foreach($this->items as $item){
			$paraCobrar=ParaCobrar::model()->findByPk($item->idParaCobrar);
			if($paraCobrar!=null){
				$paraCobrar->importeSaldo+=$item->importe;
				$paraCobrar->estado=ParaCobrar::PENDIENTE;
				$paraCobrar->save();
			}
			
			$item->delete();

		}

	}

	public function quitarPagos()
	{
		foreach($this->pagos as $pago)
			$pago->delete();
	}
	public function getEstados()
	{
		return array(self::PENDIENTE=>'PENDIENTE',self::CANCELADO=>'CANCELADO');
	}
	public function ingresarComprobante($pagos,$datosComprobante,$items)
	{
		$resElec=null;
		$id=null;
		$nroComprobante=Talonarios::model()->getProx($datosComprobante['idTipoComprobante']);
		$datosComprobante['fecha']=$this->ripFecha($datosComprobante['fecha']);
		if($datosComprobante['esElectronica']==1 && $datosComprobante['puedeElectronica']==1){
			$resElec=$this->ingresarElectronico($datosComprobante['importeTotal'],$datosComprobante['idEntidad'],$datosComprobante['fecha'],$datosComprobante['idTipoComprobante']);
			
			if($resElec->FeCabResp->Resultado=='A'){
				
				$id=$this->_ingresaComprobante2($pagos,$items,$datosComprobante['esElectronica'],$datosComprobante['idEntidad'],$datosComprobante['importeTotal'],$datosComprobante['fecha'],$datosComprobante['idTipoComprobante']==1?Settings::model()->getValorSistema('TEXTO_COMP_EXPENSAS'):"",0,'ACTIVA',0,$datosComprobante['idTipoComprobante'],$nroComprobante,0);
				$this->_ingresaRtaElectronica($id,$resElec);
			}
		}else{
			$id=$this->_ingresaComprobante2($pagos,$items,($datosComprobante['esElectronica']==1 && $datosComprobante['puedeElectronica']==1),$datosComprobante['idEntidad'],$datosComprobante['importeTotal'],$datosComprobante['fecha'],$datosComprobante['idTipoComprobante']==1?Settings::model()->getValorSistema('TEXTO_COMP_EXPENSAS'):"",0,'ACTIVA',0,$datosComprobante['idTipoComprobante'],$nroComprobante,0);
		}
		
		
		return array('id'=>$id,'resElectronico'=>$resElec);
	}
	private function ripFecha($fe)
	{
		$arr=explode('/',$fe);
		return $arr[2].'-'.$arr[1].'-'.$arr[0];
	}
	public function ingresarComprobante2($idEntidad,$importe,$fecha,$items,$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor)
	{
		$resElec=null;
		$id=null;
		if(Talonarios::model()->findByPk($idTalonario)->esElectronico){
			$resElec=$this->ingresarElectronico($importe,$idEntidad,$fecha,$idTalonario);
			if($resElec->FeCabResp->Resultado=='A'){
				$id=$this->_ingresaComprobante2($items,$idEntidad,$importe,$fecha,$idTipoComprobante==1?Settings::model()->getValorSistema('TEXTO_COMP_EXPENSAS'):"",$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor);
				$this->_ingresaRtaElectronica($id,$resElec);
			}
		}else{
			$id=$this->_ingresaComprobante2($items,$idEntidad,$importe,$fecha,$idTipoComprobante==1?Settings::model()->getValorSistema('TEXTO_COMP_EXPENSAS'):"",$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor);
		}
		
		
		return array('id'=>$id,'resElectronico'=>$resElec);
	}
	private function _ingresaRtaElectronica($idComprobante,$data)
	{
		$model=new ComprobantesRespuestaElectronica;
		$model->idComprobante=$idComprobante;
		$model->cae=$data->FeDetResp->FECAEDetResponse->CAE;
		$model->fechaVence=$data->FeDetResp->FECAEDetResponse->CAEFchVto;
		$model->estado=$data->FeDetResp->FECAEDetResponse->Resultado;
		$model->save();
	}
	private function _ingresaComprobante($items,$idEntidad,$importe,$fecha,$txtExp,$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor)
	{
		$id=$this->ingresarComp($idEntidad,$importe,$fecha,$txtExp,$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor);
		Pagos::model()->ingresaPago($id);
		$this->ingresarItems2($items,$id);
		return $id;
	}
	private function ingresarElectronico($importe,$idEntidad,$fecha,$idTalonarioTipo)
	{
		$entidad=Entidades::model()->findByPk($idEntidad);
		$talonario=TalonariosTipos::model()->findByPk($idTalonarioTipo);
		
		$cuit=Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT');

		$f=new FacturaElectronica(CertificadosElectronicos::model()->getRutaCertificado(),CertificadosElectronicos::model()->getRutaKey());
		$tipo=$talonario->tipoElectronico;
		$pventa=Settings::model()->getValorSistema('DATOS_EMPRESA_PUNTOVENTA');

		$nroSig=$f->proximoAutorizar ($pventa,$tipo,$cuit)+1;

		$tipoDoc=$entidad->getTipoElectronico();
		$iva21=0;
		$iva105=0;
		$concepto= 1;
		
		$facturaElectronica=$this->getFacturaElectronica($importe,$idEntidad,$fecha,$nroSig,$tipo,$tipoDoc,$concepto);
		
		return($f->ingresarFactura($cuit,$pventa,$tipo, $facturaElectronica,1));
	}
	private function getFacturaElectronica($importe,$idEntidad,$fecha,$proximoNumero,$tipo,$tipoDoc=80,$concepto=1, $tributoImp=0,$tributoIva=0)
	{
		$datosTributo=null;
		$datosIva=null;
		$datosIva2=null;
		$entidad=Entidades::model()->findByPk($idEntidad);
		$cuitCliente=str_replace(' ','',str_replace('-', '', $entidad->cuit))+0;
		if($tipo==6||$tipo==7||$tipo==8)
			$cuitCliente=0;
		else $cuitCliente=str_replace(' ','',str_replace('-', '',$entidad->cuit))+0;


		$datosTributo['Id']=99;
		$datosTributo['Desc']='Impuesto';
		$datosTributo['BaseImp']=round($tributoImp,2);
		$datosTributo['Alic']=$tributoIva;
		$datosTributo['Importe']=round($tributoImp*$tributoIva,2);



		$fecha=explode(' ', $fecha);
	    //si es FACTURA C (11) no va con IVA
		$importeIva=$tipo==11? 0:round($importe*0.21,2);
		$importeNeto=$tipo==11?round($importe,2):round($importe-($importe*0.21),2);
		$res=array(
			'Concepto' => $concepto,
	                   'DocTipo' => $tipoDoc,//80 cuit
	                   'DocNro' => $cuitCliente,//23111111113
	                   'CbteDesde' => $proximoNumero,//*
	                   'CbteHasta' => $proximoNumero,//*
	                   
	//                   'CbteFch' => str_replace('-','',$fecha[0]),//*
	                   'CbteFch' => Date('Ymd'),
	                   'ImpTotal' => round($importe,2), //importe total
	                   'ImpTotConc' => 0, //0
	                   'ImpNeto' => $importeNeto, //importe neto
	                   'ImpOpEx' => 0, //importe neto
	                   'ImpTrib' => 0, //importe *
	                   'ImpIVA' =>$importeIva , //importe *
	                   'FchServDesde' => '', //importe neto *
	                   'FchServHasta' => '', //importe neto *
	                   'FchVtoPago' => '', //importe neto *
	                   'MonId' => 'PES', //PES *
	                   'MonCotiz' => 1, //1 *
	                   //'Tributos'=>array('Tributo' =>$this->getTributo($datosTributo)),
	                   'Iva'=>array(
	                   	'AlicIva'=>$this->getIva(5,$importeNeto,$importeIva)
	                   	),

	                   );
	    //if($datosTributo!=null) $res['Tributos']=array('Tributo' =>$this->getTributo($datosTributo));
if($tipo==11)$res['Iva']=null;
return $res;
}
private function getIvaDos($iva105,$iva21)
{
	$res=array();
	if($iva105!=null) $res[]=$iva105;
	if($iva21!=null) $res[]=$iva21;
	return $res;
}
private function getTributo($datos)
{
	if($datos==null) return array();
	$res=array(
		'Id' => $datos['Id'],
		'Desc' => $datos['Desc'],
                   'BaseImp' => $datos['BaseImp'],//80 cuit
                   'Alic' => $datos['Alic'],//80 cuit
                   'Importe' => $datos['Importe'],//23111111113
                   );
	return $res;
}
private function getIva($idIva,$base,$importe)
{
    $res= array(//5 el 21, 4 el 10.5
    	'Id' => $idIva,
                   'BaseImp' => $base,//ej 100
                   'Importe' => $importe,//ej 21
                   );
    return (object)$res;
}

public function _getTextoComprobate($id)
{
	$model=Comprobantes::model()->findByPk($id);
	$params['letra']=$model->tipo->letraTalonario;
	$params['hayElectronica']=$model->esElectronica;
	$params['items']=$this->grillaDetalleItems($model);
	$params['nroComprobante']=str_pad($model->nroComprobante,5,'0', STR_PAD_LEFT);
	$params['concepto']=$model->detalle;
	$params['verTipo']= ($model->tipo->letraTalonario=='A' || $model->tipo->letraTalonario=='B')?"ok":"none";
	$params['importeTotal']=number_format($model->importe,2);
	$params['importeIva']=number_format($model->importe-($model->importe/1.21),2);
	$params['importeBruto']=number_format($model->importe/1.21,2);
	$params['cae']=$model->esElectronica?('<b>CAE </b> '.$model->comprobanteElectronico->cae):'';
	$params=$this->getDatosEntidad(isset($model->item->paraCobrar)?$model->item->paraCobrar->propiedad:null,null,$params,'emisor');
	$params=$this->getDatosEntidad(null,$model->entidad,$params,'receptor');

		//$V=new EnLetras();
		//$params['importeLetras']=$V->ValorEnLetras($model->importe+$model->interesDescuento-$model->importeFavor,'');
	$date = date_create($model->fecha);
	$params['fecha']= date_format($date, 'd/m/Y');

	$texto=Yii::app()->controller->renderPartial('modeloFactura',array('params'=>$params),true);
	Yii::app()->controller->layout="//layouts/layoutSolo";
	return Yii::app()->controller->render('impresion',array('texto'=>$texto),true);
}
public function _getTextoComprobate2($id)
{
	$model=Comprobantes::model()->findByPk($id);
	$params['letra']=$model->tipo->letraTalonario;
	$params['hayElectronica']=$model->esElectronica;
	$ptoVenta=$model->esElectronica?Settings::model()->getValorSistema('DATOS_EMPRESA_PUNTOVENTA'):Settings::model()->getValorSistema('DATOS_EMPRESA_PUNTOVENTACOMUN');
	$ptoVenta=str_pad($ptoVenta,5,"0",STR_PAD_LEFT);
	$params['items']=$this->grillaDetallePDF($model,($model->tipo->letraTalonario=='A' || $model->tipo->letraTalonario=='B'));
	$params['nroComprobante']= $ptoVenta." - ".str_pad($model->nroComprobante,8,'0', STR_PAD_LEFT);
	$params['concepto']=$model->detalle;
	$params['verTipo']= ($model->tipo->letraTalonario=='A' || $model->tipo->letraTalonario=='B')?"ok":"none";
	$params['importeTotal']=number_format($model->importe,2);
	$params['importeIva']=number_format($model->importe-($model->importe/1.21),2);
	$params['importeBruto']=number_format($model->importe/1.21,2);
	$params['cae']=$model->esElectronica?('<b>CAE </b> '.$model->comprobanteElectronico->cae):'';
	$params['fechaVto']=$model->esElectronica?($model->comprobanteElectronico->fechaVto):'';
	$params=$this->getDatosEntidad(isset($model->item->paraCobrar)?$model->item->paraCobrar->propiedad:null,null,$params,'emisor');
	$params=$this->getDatosEntidad(null,$model->entidad,$params,'receptor');

		//$V=new EnLetras();
		//$params['importeLetras']=$V->ValorEnLetras($model->importe+$model->interesDescuento-$model->importeFavor,'');
	$date = date_create($model->fecha);
	$params['fecha']= date_format($date, 'd/m/Y');
	Yii::app()->controller->layout="//layouts/layoutSoloSolo";
	$texto=Yii::app()->controller->renderPartial('modeloFacturaPDF',array('params'=>$params),true);
	
	return $texto;
}
public function getDatosEntidad($propiedad,$entidad,$params,$nombreParam)
{
	if($propiedad!=null)
		
		if($propiedad->edificio!=null){
			$params['telefono_'.$nombreParam]=$propiedad->edificio->telefono;
			$params['razonSocial_'.$nombreParam]=$propiedad->edificio->nombreEdificio;
			$params['cuit_'.$nombreParam]=$propiedad->edificio->cuit;
			$params['direccion_'.$nombreParam]=$propiedad->edificio->domicilio;
			$params['detalle_'.$nombreParam]='CONSORCIO DE EDIFICIOS';
			$params['condicionIva_'.$nombreParam]=$propiedad->edificio->condicionIva->nombreIva;
			$params['email_'.$nombreParam]=$propiedad->edificio->email;
			return $params;
			
			
		}
		if($entidad==null){
			$logo=Imagenes::model()->getImagen("LOGOEMPRESA",true);
			$params['razonSocial_'.$nombreParam]=$logo?$logo:Settings::model()->getValorSistema('DATOS_EMPRESA_RAZONSOCIAL');
			$params['cuit_'.$nombreParam]=Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT')=="s/cuit"?"":Settings::model()->getValorSistema('DATOS_EMPRESA_CUIT');
			$params['direccion_'.$nombreParam]=Settings::model()->getValorSistema('DATOS_EMPRESA_DIRECCION');
			$params['telefono_'.$nombreParam]=Settings::model()->getValorSistema('DATOS_EMPRESA_TELEFONO');
			$params['condicionIva_'.$nombreParam]=Settings::model()->getValorSistema('DATOS_EMPRESA_CONDICIONIVA');
			$params['email_'.$nombreParam]=Settings::model()->getValorSistema('DATOS_EMPRESA_EMAILADMIN');
			$params['logo_'.$nombreParam]="<img src='images/".Settings::model()->getValorSistema("logoEmpresa")."'></img>";
		}else{
			$params['telefono_'.$nombreParam]=$entidad->telefono;
			$params['razonSocial_'.$nombreParam]=$entidad->razonSocial;
			$params['cuit_'.$nombreParam]=$entidad->cuit==""?"s/cuit":$entidad->cuit;
			$params['direccion_'.$nombreParam]=$entidad->domicilio==""?"s/ domicilio":$entidad->domicilio;
			$params['detalle_'.$nombreParam]=$entidad->detalle;
			$params['condicionIva_'.$nombreParam]=$entidad->condicionIva->nombreIva;
			$params['email_'.$nombreParam]=$entidad->email;
		}
		return $params;
	}

	private function grillaDetalleItems($model)
	{
		$sum=0;
		$interesTotal=0;
		$tot=0;
		$verTipo= ($model->tipo->letraTalonario=='A' || $model->tipo->letraTalonario=='B')?"ok":"none";
		$subTotales="";
		$cad='';
		foreach($model->items as $item){
			$tot+=$item->importe;
			$parc=$item->importe+$item->decuentoInteres;
			$sum+=$parc;
			$interesTotal+=$item->decuentoInteres;
			$cad.='<tr >';
			$cad.='<td>'.$item->cantidad.'</td>';
			$cad.='<td>'.$item->detalle.'</td>';
			$cad.='<td> $ '.number_format($item->importe,2).'</td>';
			$cad.='<td style="display:'.$verTipo.'"> $ '.number_format($item->importe-($item->importe/1.21),2).'</td>';
			$cad.='<td> $ '.number_format($item->importe*$item->cantidad,2).'</td>';

			$cad.='</tr>';
		}
		return $cad;
	}
	private function grillaDetallePDF($model,$conBruto)
	{
		$CANT_ITEMS_SOPORTA_A4=20;
		$tot=0;
		$interesTotal=0;
		$sum=0;
		$cad='<thead><tr>
		
		<td width="10%">CANT.</td>
		<td width="60%">DESCRIPCION</td>';
		if($conBruto)$cad.='<td width="15%">$ BRUTO</td>';
		$cad.='
		<td width="15%">$ UNIDAD</td>
		<td width="15%">TOTAL</td></tr></thead>
		<tbody>';
			foreach($model->items as $item){
				$CANT_ITEMS_SOPORTA_A4--;
				$importe=$item->importe * $item->cantidad;
				$bruto=number_format($item->importe/1.21,2);
				$total=$importe*$item->cantidad;
				$tot+=$total;
				$cad.='<tr >';
				$cad.='<td style="columna"  width="10%">'.$item->cantidad.'</td>';
				$cad.='<td  width="60%">'.$item->detalle.'</td>';
				if($conBruto)$cad.='<td width="15%">$ '.$bruto.'</td>';
				$cad.='<td  width="15%"> $ '.number_format($item->importe,2).'</td>';
				$cad.='<td  width="15%"> $ '.number_format($importe,2).'</td>';


				$cad.='</tr>';
			}
			$cad=$this->rellena($CANT_ITEMS_SOPORTA_A4,$cad,$conBruto);

			$cad.='</tbody>';
			
			return $cad;
		}
		private function rellena($cant,$cad,$conBruto)
		{
			for($i=0;$i<$cant;$i++){
				$cad.='<tr ><td style="color:#FFFFFF" width="10%">55</td>
						<td width="60%"></td>';
						if($conBruto)$cad.='<td width="15%"></td>';
						$cad.='
						<td width="15%"></td>
						<td width="15%"></td></tr>';
			}
			return $cad;
		}
		private function grillaDetalle($model)
		{
			$cad='<table class="table table-condensed">';
			$cad.=' <colgroup>
			<col span="3" style="background-color:#fff">
			<col style="background-color:#EBEBEB">
			<col style="background-color:#EBEBEB">
			<col style="background-color:#EBEBEB">
			<col style="background-color:#EBEBEB">
			<col style="background-color:#EBEBEB">
		</colgroup>';
		$cad.='<tr><th>Prop.</th><th>Concepto</th><th>Int/desc</th></td>';
		$sum=0;
		$interesTotal=0;
		$tot=0;
		foreach(PropiedadesTipos::model()->paraImpresion() as $tipo)
			foreach(GastosTipos::model()->paraImpresion() as $itemGasto)
				$cad.="<th><small><small>".$itemGasto->nombreTipoCorto.' '.$tipo->nombreTipoCorto."</small></small></th>";
			$cad.='<th><small>Fondo.R</small></th><th>Pend.</th><th>Total</th></tr>';

			foreach($model->items as $item){
				$tot+=$item->importe;
				$parc=$item->importe+$item->decuentoInteres;
				$sum+=$parc;
				$interesTotal+=$item->decuentoInteres;
				$cad.='<tr >';
				$cad.='<td>'.$item->paraCobrar->propiedad->nombrePropiedad.'</td>';
				$cad.='<td>'.$item->detalle.'</td>';
				$cad.='<td> $ '.number_format($item->decuentoInteres,2).'</td>';
				$cad.=$this->subDetalleGrilla($item);
				$cad.='<td> $ '.number_format($item->paraCobrar->importeSaldo,2).'</td>';
				$cad.='<td> $ '.number_format($parc,2).'</td>';


				$cad.='</tr>';
			}

		//if($model->importeFavor>0)
		//$cad.='<tr ><td></td><td><small>Importe a favor usado</small></td><td></td><td></td><td></td><td></td><td></td><td></td><td><small>- $ '.number_format($model->importeFavor,2).'</small></td></tr>';
			if($model->importe>$tot)
				$cad.='<tr ><td></td><td><small>Importe a favor</small></td><td></td><td></td><td></td><td></td><td></td><td></td><td><small> $ '.number_format($model->importe-$tot,2).'</small></td></tr>';

			if($interesTotal<$model->interesDescuento)
				$cad.='<tr ><td></td><td><small>Interés adicional</small></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><small> $ '.number_format($model->interesDescuento-$interesTotal,2).'</small></td></tr>';
			$cad.='<tr >';
			$cad.='<td></td>';
			$cad.='<td></td>';
			$cad.='<td><big><big>TOTALES</big></big></td>';
			$cad.='<td> </td>';
			$cad.='<td> </td>';
			$cad.='<td> </td>';
			$cad.='<td></td><td></td><td></td>';
			$cad.='<td><big><big> $ '.number_format($model->importe+$model->interesDescuento-$model->importeFavor,2).'</big></big></td>';
			$cad.='</tr>';
			$cad.='</table>';
			if(isset($model->comprobanteElectronico))$cad.='<table class="table"> <tr><td><b>CAE</b> '.$model->comprobanteElectronico->cae.' | <b>VTO</b> '.$model->comprobanteElectronico->fechaVence.'</tr></table>';
			return $cad;
		}
		protected function afterSave()
		{
			Talonarios::model()->incrementaProx($this->idTipoComprobante);
			parent::afterSave();
		}
		private function agregarEspacios($e)
		{
			$aux='';
			for($i=$e;$i<=4;$i++)
				$aux.='<td>-</td>';
			return $aux;
		}

		private function agregarCreditos($imp,$tot)
		{
			$cad='';
			if($imp-$tot>0){
				$cad.='<tr class="success">';

				$cad.='<td colspan="2">En concepto de crédito a favor</td>';
				$cad.='<td> - </td>';
				$cad.='<td>$ '.number_format($imp-$tot,2).' </td>';
				$cad.='<td> - </td>';
				$cad.='</tr>';
			}
			if($imp-$tot<0){
				$cad.='<tr class="error">';

				$cad.='<td colspan="2">En concepto de USO de crédito a favor</td>';
				$cad.='<td> - </td>';
				$cad.='<td>$ '.number_format($imp-$tot,2).' </td>';
				$cad.='<td> - </td>';
				$cad.='</tr>';
			}
			return $cad;
		}
		public function cambiarEstado($estado)
		{
			$this->estado=$estado;
			$this->save();
		}
		private function subDetalleGrilla($itemComp)
		{
			$cad='';
			$sum=0;
			foreach(PropiedadesTipos::model()->paraImpresion() as $tipo)
				foreach(GastosTipos::model()->paraImpresion() as $itemGasto){
					$valor=$itemComp->paraCobrar->getValor($itemGasto->id,$tipo->id);
					$sum+=$valor;
					$cad.="<td><small>$ ".number_format($valor,2)."</small></td>";
				}


				$cad.="<td><small>$ ".number_format($itemComp->paraCobrar->getFondoReserva(),2)."</small></td>";
				return $cad.'';
			}
			public function enviarComprobante($id,$email=null){
	//$dest es por si se quiere enviar a otro mail que no sea el de la entidad
				$model=Comprobantes::model()->findByPk($id);
				$destino=isset($email)?$email:$model->entidad->email;
				$mPDF1 = Yii::app()->ePdf->mpdf();
				$mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
				$mPDF1->AddPage('','','','','','','','','','','', 'myHeaderx', 'html_myHeader2x', '', '', 1, 1, 0, 0);
				$mPDF1->Bookmark("Comprobante",0);
				$mPDF1->WriteHTML($this->_getTextoComprobate2($id));

				$salida['email']=$destino;

			//$stylesheet = file_get_contents('css/impresion.css');
			//$mPDF1->WriteHTML($stylesheet, 1);
				$data = $mPDF1->Output('data.pdf', 'S');
				$params['fecha']=Date('d-m-Y');
				$params['titulo']='COMPROBANTE EN LINEA ';
				$params['nombreEmpresa']=Settings::model()->getValorSistema('DATOS_EMPRESA_DIRECCION');
				$params['direccion']=Settings::model()->getValorSistema('DATOS_EMPRESA_FANTASIA');
				$params['logo']=Settings::model()->getValorSistema('LOGOEMPRESA');
				$params['empresaReceptor']=$model->entidad->razonSocial;
				$params['telefono']=Settings::model()->getValorSistema('DATOS_EMPRESA_TELEFONO');
				$params['emailAdmin']=Settings::model()->getValorSistema('DATOS_EMPRESA_EMAILADMIN');
				$params['cuerpo']= Yii::app()->controller->renderPartial('/comprobantes/comprobanteMail',array('params'=>$params),true);
			

				ob_start();
				Yii::app()->controller->renderPartial('/mail/plantilla_envioComprobante',array());
				$ob = ob_get_clean();
				$logo = 'http://yavu.com.ar/img/logoChicoChico.png';
				$fecha=Date('d-m-Y');
				$replace = array('{cliente}', '{fecha}', '{logo}');
				$with = array($model->entidad->razonSocial, $fecha,$logo);

				

				$mensaje= str_replace($replace, $with, $ob);
				$tituloMail='SU COMPROBANTE YAVU';
				$res=Mail::model()->enviarMail($destino,$mensaje,$tituloMail,Settings::model()->getValorSistema('DATOS_EMPRESA_EMAILADMIN'),($data));

			}
			public function getNombre()
			{
				return $this->entidad->razonSocial.'- nro '.$this->nroComprobante;
			}
			public function ingresarComprobante22($idEntidad,$importe,$fecha,$items,$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor)
			{
				$id=null;
				$resElec=null;
				if(Talonarios::model()->findByPk($idTalonario)->esElectronico){
					$resElec=$this->ingresarElectronico($importe,$idEntidad,$fecha,$idTalonario);
					if($resElec->FeCabResp->Resultado=='A'){
						$id=$this->_ingresaComprobante2($items,$idEntidad,$importe,$fecha,$idTipoComprobante==1?Settings::model()->getValorSistema('TEXTO_COMP_EXPENSAS'):"",$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor);
						$this->_ingresaRtaElectronica($id,$resElec);
					}
				}else
				$id=$this->_ingresaComprobante($items,$idEntidad,$importe,$fecha,$idTipoComprobante==1?Settings::model()->getValorSistema('TEXTO_COMP_EXPENSAS'):"",$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor);

				return array('id'=>$id,'resElectronico'=>$resElec);
			}
			private function _ingresaComprobante2($pagos,$items,$hayElectronico,$idEntidad,$importe,$fecha,$txtExp,$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor)
			{
				$id=$this->ingresarComp($hayElectronico,$idEntidad,$importe,$fecha,$txtExp,$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor);
				
				$this->ingresarPagos($pagos,$id);
				$this->ingresarItems($items,$id);
				return $id;
			}
			private function ingresarPagos($pagos,$idComp)
			{
				foreach($pagos as $id=>$valor)Pagos::model()->ingresaPago($idComp,$valor,$id);
			}
			private function ingresarItems($items,$id)
			{
				foreach($items as $item)$this->ingresaItem2($item,$id);
			}
			private function ingresarItems2($items,$id)
			{
				foreach($items as $item)$this->ingresaItem($item,$id);
			}
			private function ingresaItem2($item,$id)
			{
				$model=new ComprobantesItems;
				$model->idComprobante=$id;
				$model->detalle=$item['detalle'];
				$model->cantidad=$item['cantidad'];
				$model->importe=$item['importe'];
				$model->decuentoInteres=0;
				$model->idParaCobrar=null;
				$model->save();
			}
			public function modificarItems($items)
			{

				foreach($items as $item){
					$model=Comprobantes::model()->findByPk($item['id']);
					$model->importe=0;
					$model->save();
				}
			}
			public function modificarCreditos($creditos)
			{
				foreach($creditos as $credito){
					$comp=Comprobantes::model()->findByPk($credito['id']);
					$comp->estado=Comprobantes::CANCELADO;
					$comp->save();

					$model=new Pagos;
					$model->fecha=Date('Y-m-d');
					$model->idComprobante=$credito['id'];
					$model->importe=$comp->importe;

					$model->save();
				}
			}
			private function ingresaItem($item,$id)
			{
				$pc=ParaCobrar::model()->findByPk($item['id']);
				$model=new ComprobantesItems;
				$model->idComprobante=$id;
				$model->detalle=$pc->detalle;
				$model->cantidad=1;
				$model->importe=$item['saldo'];
				$model->decuentoInteres=$item['interes'];
				$model->idParaCobrar=$item['id'];
				$model->save();
				$model->ingresarParaCobrar();
			}
			public function ultimos($idEntidad,$cantidad)
			{
				$criteria=new CDbCriteria;
				$criteria->compare('idEntidad',$idEntidad,false);
				$criteria->limit=$cantidad;
				$criteria->order='t.id desc';
				return self::model()->findAll($criteria);
			}
			public function getCreditos($idEntidad)
			{
				$criteria=new CDbCriteria;
				$criteria->compare('idEntidad',$idEntidad,false);
				$criteria->compare('idTipoComprobante',ComprobantesTipos::ID_NOTACREDITO,false);
				$criteria->compare('estado',Comprobantes::PENDIENTE,false);
				$criteria->order='t.id desc';
				return self::model()->findAll($criteria);
			}
			private function ingresarComp($hayElectronico,$idEntidad,$importe,$fecha,$detalle,$interesDescuento,$estado,$idTalonario,$idTipoComprobante,$nroComprobante,$importeFavor)
			{
				$mod=new Comprobantes;
				$mod->idEntidad=$idEntidad;
				$mod->importe=$importe;
				$mod->fecha=$fecha;
				$mod->estado=$estado;
				$mod->detalle=$detalle;

				$mod->esElectronica=$hayElectronico?1:0;
				
				$mod->idTalonario=$idTalonario;
				$mod->nroComprobante=$nroComprobante;
				$mod->interesDescuento=$interesDescuento;
				$mod->idTipoComprobante=$idTipoComprobante;
				$mod->importeFavor=$importeFavor;
				
				$mod->save();
//print_r($mod->getErrors());
//				die();
				return $mod->id;

			}
			public function ingresarCredito($idEntidad,$importeCredito)
			{
				if($importeCredito>0)
					$id=$this->ingresarComp($idEntidad,$importeCredito,'Nota de crédito por el pago de expensas',ComprobantesTipos::ID_NOTACREDITO,self::PENDIENTE);
		///Pagos::model()->ingresaPago($id);
			}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comprobantes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idEntidad,idTalonario,esElectronica, idTipoComprobante', 'numerical', 'integerOnly'=>true),
			array('importe,idTalonario,esElectronica,importeFavor', 'numerical'),

			array('estado, nroComprobante', 'length', 'max'=>255),
			array('detalle, fecha,esElectronica,fechaVencimiento,importeFavor', 'safe'),
			array('idEntidad,importe,estado, fecha', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idTalonario, esElectronica,buscar,id,fechaVencimiento, idEntidad, importe,importeFavor, detalle, fecha, estado, nroComprobante, idTipoComprobante', 'safe', 'on'=>'search'),
			);
	}

	/**
	 * @return array relational rules.
	 */
	public function getSaldo()
	{
		$tot=0;
		foreach($this->pagos as $pago)
			$tot+=$pago->importe;
		return $tot-$this->importe;
	}
	public function getImportePagado()
	{
		$tot=0;
		foreach($this->pagos as $pago)
			$tot+=$pago->importe;
		return $tot;
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'entidad' => array(self::BELONGS_TO, 'Entidades', 'idEntidad'),
			//'tipoEntidad' => array(self::BELONGS_TO, 'EntidadesTipos',array('idTipoEntidad'=>'id'),'through'=>'entidad'),
			
			'tipo' => array(self::BELONGS_TO, 'TalonariosTipos', 'idTipoComprobante'),
			'comprobantesComprobantes' => array(self::HAS_MANY, 'ComprobantesComprobantes', 'idComprobante'),
			'comprobantesComprobantes1' => array(self::HAS_MANY, 'ComprobantesComprobantes', 'idComprobanteHijo'),
			'gastoses' => array(self::HAS_MANY, 'Gastos', 'idComprobante'),
			'items' => array(self::HAS_MANY, 'ComprobantesItems', 'idComprobante'),
			'item' => array(self::HAS_ONE, 'ComprobantesItems', 'idComprobante'),
			'comprobanteElectronico' => array(self::HAS_ONE, 'ComprobantesRespuestaElectronica', 'idComprobante'),
			'pagos' => array(self::HAS_MANY, 'Pagos', 'idComprobante'),

			'liquidacionesItemsComprobantes' => array(self::HAS_MANY, 'LiquidacionesItemsComprobantes', 'idComprobante'),
			);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idEntidad' => 'Entidad',
			'importe' => 'Importe',
			'detalle' => 'Detalle',
			'fecha' => 'Fecha',
			'estado' => 'Estado',
			'idTalonario' => 'Talonario',
			'nroComprobante' => 'Nro Comprobante',
			'idTipoComprobante' => 'Tipo Comprobante',
			);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->with=array('entidad');
		$criteria->join="left join entidades on entidades.id=t.idEntidad 
		left join entidades_tipos on entidades_tipos.id=entidades.idTipoEntidad";
		$criteria->compare('entidades.razonSocial',$this->buscar,true,'OR');
		$criteria->compare('nroComprobante',$this->buscar,true,'OR');
		$criteria->compare('estado',$this->estado);
		$criteria->order='t.id desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			));
	}
	public function importeMes($mes,$ano)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select='SUM(t.importe) as importe';

		$criteria->addCondition('t.estado="ACTIVA" AND MONTH(t.fecha)="'.$mes.'" AND YEAR(t.fecha)="'.$ano.'"');
		$res=self::model()->findAll($criteria);
		$res=count($res)>0?$res[0]:null;
		if($res)return $res->importe;
		return $res;
	}
}