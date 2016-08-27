<?php

/**
 * This is the model class for table "solicitudesAfip".
 *
 * The followings are the available columns in table 'solicitudesAfip':
 * @property integer $id
 * @property string $fecha
 * @property integer $idCliente
 * @property string $claveAFIP
 * @property string $cuitAFIP
 * @property string $estado
 * @property string $fechaPago
 * @property string $fechaAlta
 * @property string $observaciones
 */
class SolicitudesAfip extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SolicitudesAfip the static model class
	 */
	 public $buscar;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'solicitudesAfip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idCliente', 'numerical', 'integerOnly'=>true),
			array('claveAFIP, cuitAFIP, estado', 'length', 'max'=>255),
			array('fecha, fechaPago, fechaAlta, observaciones', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, fecha, idCliente, claveAFIP, cuitAFIP, estado, fechaPago, fechaAlta, observaciones', 'safe', 'on'=>'search'),
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
			'cliente' => array(self::BELONGS_TO, 'Clientes', 'idCliente'),
		);
	}
	public static function getEstados()
	{
		return array('PEDIDO'=>"PEDIDO",'PENDIENTE PAGO'=>"PENDIENTE PAGO",'EN PROCESO'=>"EN PROCESO",'TRAMITADO'=>"TRAMITADO");
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'idCliente' => 'Cliente',
			'claveAFIP' => 'Clave Afip',
			'cuitAFIP' => 'Cuit Afip',
			'estado' => 'Estado',
			'fechaPago' => 'Fecha Pago',
			'fechaAlta' => 'Fecha Alta',
			'observaciones' => 'Observaciones',
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

		$criteria->compare('id',$this->buscar,'OR');
		$criteria->compare('fecha',$this->buscar,true,'OR');
		$criteria->compare('idCliente',$this->buscar,'OR');
		$criteria->compare('claveAFIP',$this->buscar,true,'OR');
		$criteria->compare('cuitAFIP',$this->buscar,true,'OR');
		$criteria->compare('estado',$this->buscar,true,'OR');
		$criteria->compare('fechaPago',$this->buscar,true,'OR');
		$criteria->compare('fechaAlta',$this->buscar,true,'OR');
		$criteria->compare('observaciones',$this->buscar,true,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}