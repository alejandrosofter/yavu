<?php

/**
 * This is the model class for table "ventas_deuda".
 *
 * The followings are the available columns in table 'ventas_deuda':
 * @property integer $id
 * @property integer $idVenta
 * @property string $fechaVto
 * @property double $importe
 * @property double $importeSaldo
 * @property string $estado
 *
 * The followings are the available model relations:
 * @property PagosDeudas[] $pagosDeudases
 * @property Ventas $idVenta0
 */
class VentasDeuda extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VentasDeuda the static model class
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
		return 'ventas_deuda';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idVenta', 'numerical', 'integerOnly'=>true),
			array('importe, importeSaldo', 'numerical'),
			array('estado', 'length', 'max'=>255),
			array('fechaVto,detalle,fecha,', 'safe'),
			array('idVenta,detalle,importeSaldo,importe', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, idVenta,detalle,fecha, fechaVto, importe, importeSaldo, estado', 'safe', 'on'=>'search'),
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
			'pagos' => array(self::HAS_MANY, 'PagosDeudas', 'idServicioDeuda'),
			'venta' => array(self::BELONGS_TO, 'Ventas', 'idVenta'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idVenta' => 'Venta',
			'fechaVto' => 'Fecha Vto',
			'importe' => 'Importe',
			'importeSaldo' => 'Importe Saldo',
			'estado' => 'Estado',
			
		);
	}
	public function estados()
	{
		return array('PENDIENTE'=>'PENDIENTE','CANCELADO'=>'CANCELADO');
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
		$criteria->compare('idVenta',$this->buscar,'OR');
		$criteria->compare('fechaVto',$this->buscar,true,'OR');
		$criteria->compare('importe',$this->buscar,'OR');
		$criteria->compare('importeSaldo',$this->buscar,'OR');
		$criteria->compare('estado',$this->buscar,true,'OR');
		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}