<?php

/**
 * This is the model class for table "certificadosElectronicos".
 *
 * The followings are the available columns in table 'certificadosElectronicos':
 * @property integer $id
 * @property string $fechaCreacion
 * @property string $fechaExpira
 * @property string $archivoCertificado
 * @property string $archivoCsr
 * @property string $archivoKey
 * @property string $estado
 *
 * The followings are the available model relations:
 * @property Talonarios[] $talonarioses
 */
class CertificadosElectronicos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CertificadosElectronicos the static model class
	 */
	const ARCHIVO_KEY="pkServidor.key";
	const ARCHIVO_PEDIDO='pedidoServidor.csr';
	const ARCHIVO_CERTIFICADO='certificado.crt';
	 public $buscar;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function crear($fechaVto)
	{
		$feArr=explode('/',$fechaVto);
		$model=new CertificadosElectronicos;
		$model->fechaCreacion=Date('Y-m-d');
		$model->fechaExpira=$feArr[2].'-'.$feArr[1].'/'.$feArr[0];
		$model->estado="ACTIVO";
		$model->save();
		return $model->id;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'certificadosElectronicos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('archivoCertificado, archivoCsr, archivoKey, estado', 'length', 'max'=>255),
			array('fechaCreacion, fechaExpira', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, fechaCreacion, fechaExpira, archivoCertificado, archivoCsr, archivoKey, estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'talonarioses' => array(self::HAS_MANY, 'Talonarios', 'idCertificadoElectronico'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechaCreacion' => 'Fecha Creacion',
			'fechaExpira' => 'Fecha Expira',
			'archivoCertificado' => 'Archivo Certificado',
			'archivoCsr' => 'Archivo Csr',
			'archivoKey' => 'Archivo Key',
			'estado' => 'Estado',
		);
	}
	public function getCertificadoActivo()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('estado',"ACTIVO",false);
		$res=self::model()->findAll($criteria);
		if(count($res)>0)return $res[0];
		return null;
	}
	public function getRutaCertificado()
	{
		$cert=$this->getCertificadoActivo();
		$nomArchivo=$cert->id.'_'.Yii::app()->user->usuario.'_'.self::ARCHIVO_CERTIFICADO;
        $ruta=dirname(__FILE__).'/../../certificadosElectronicos/'.Yii::app()->user->usuario.'/'.$nomArchivo;
        return $ruta;
	}
	public function getRutaKey()
	{
		$cert=$this->getCertificadoActivo();
		$nomArchivo=$cert->id.'_'.Yii::app()->user->usuario.'_'.self::ARCHIVO_KEY;
        $ruta=dirname(__FILE__).'/../../certificadosElectronicos/'.Yii::app()->user->usuario.'/'.$nomArchivo;
        return $ruta;
	}
	public function hayCertificadoActivo()
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition('estado="ACTIVO"');
		$res=self::model()->findAll($criteria);
		return count($res)>0;
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->buscar,'OR');
		$criteria->compare('fechaCreacion',$this->buscar,true,'OR');
		$criteria->compare('fechaExpira',$this->buscar,true,'OR');
		$criteria->compare('archivoCertificado',$this->buscar,true,'OR');
		$criteria->compare('archivoCsr',$this->buscar,true,'OR');
		$criteria->compare('archivoKey',$this->buscar,true,'OR');
		$criteria->compare('estado',$this->buscar,true,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}