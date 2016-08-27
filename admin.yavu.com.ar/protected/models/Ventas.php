<?php

/**
 * This is the model class for table "ventas".
 *
 * The followings are the available columns in table 'ventas':
 * @property integer $id
 * @property integer $idCliente
 * @property integer $idServicio
 * @property integer $periodicidad
 * @property double $importe
 * @property integer $idFormaPago
 * @property string $estado
 * @property string $fechaInicio
 * @property integer $cantidadMeses
 * 

 * The followings are the available model relations:
 * @property VentasDeuda[] $ventasDeudas
 */
class Ventas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ventas the static model class
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
		return 'ventas';
	}
	public function getNombreCliente()
	{
		return $this->cliente->apellido.' '.$this->cliente->nombre.'('.$this->cliente->razonSocial.')';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idCliente, idServicio, periodicidad, idFormaPago, cantidadMeses', 'numerical', 'integerOnly'=>true),
			array('importe,proximaFacturacion', 'numerical'),
			array('estado', 'length', 'max'=>255),
			array('fechaInicio', 'safe'),
				array('nombreUsuario,nombreDominio',  'unique'),
			array('idCliente, idServicio, periodicidad, nombreUsuario,nombreDominio,claveAcceso,cantidadMeses,estado,fechaInicio', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, idCliente,proximaFacturacion, idServicio, periodicidad, importe, idFormaPago, estado, fechaInicio, cantidadMeses', 'safe', 'on'=>'search'),
		);
	}

	public function getColor()
	{
		if($this->estado==2)return "muted";
		return '';
	}
	public function getNombreVenta()
	{
		return $this->cliente->razonSocial.' - '.$this->servicio->nombreServicio;
	}
	
	public function getDiasVence()
	{
		$fin=new DateTime($this->fechaInicio, new DateTimeZone("UTC"));
		$actual=new DateTime(Date('Y-m-d'), new DateTimeZone("UTC"));
		$fin->add(new DateInterval('P'.$this->periodicidad.'M'));
		$interval = date_diff($actual, $fin);
		$diferencia=($interval->format('%R%a'));
		return $diferencia;
	}
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'ventasDeudas' => array(self::HAS_MANY, 'VentasDeuda', 'idVenta'),
			'ultimaDeuda' => array(self::HAS_ONE, 'VentasDeuda', 'idVenta','order'=>'id desc'),
			'formaPago' => array(self::BELONGS_TO, 'FormasPago', 'idFormaPago'),
			'cliente' => array(self::BELONGS_TO, 'Clientes', 'idCliente'),
			'ultimoPago' => array(self::HAS_ONE, 'Pagos', 'idVenta','order'=>'id desc'),
			'servicio' => array(self::BELONGS_TO, 'Servicios', 'idServicio'),
				'est' => array(self::BELONGS_TO, 'Estados', 'estado'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idCliente' => 'Cliente',
			'idServicio' => 'Servicio',
			'periodicidad' => 'Periodicidad',
			'importe' => 'Importe',
			'idFormaPago' => 'Forma de Pago',
			'estado' => 'Estado',
			'fechaInicio' => 'Fecha Inicio',
			'cantidadMeses' => 'Cantidad Meses',
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
		$criteria->compare('idCliente',$this->buscar,'OR');
		$criteria->compare('idServicio',$this->buscar,'OR');
		$criteria->compare('periodicidad',$this->buscar,'OR');
		$criteria->compare('importe',$this->buscar,'OR');
		$criteria->compare('idFormaPago',$this->buscar,'OR');
		$criteria->compare('estado',$this->buscar,true,'OR');
		$criteria->compare('fechaInicio',$this->buscar,true,'OR');
		$criteria->compare('cantidadMeses',$this->buscar,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function activos($idCliente=null)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('estado',1,false);
		if($idCliente!=null)$criteria->compare('idCliente',$idCliente,false);
		return self::model()->findAll();
	}
}