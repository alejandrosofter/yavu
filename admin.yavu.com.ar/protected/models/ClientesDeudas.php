<?php

/**
 * This is the model class for table "clientes_deudas".
 *
 * The followings are the available columns in table 'clientes_deudas':
 * @property integer $id
 * @property integer $idServicio
 * @property string $fecha
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property double $importe
 * @property double $importeSaldo
 * @property string $estado
 * @property integer $idCliente
 *
 * The followings are the available model relations:
 * @property Clientes $idCliente0
 * @property Servicios $idServicio0
 */
class ClientesDeudas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClientesDeudas the static model class
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
		return 'clientes_deudas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idServicio, idCliente', 'numerical', 'integerOnly'=>true),
			array('importe, importeSaldo', 'numerical'),
			array('estado', 'length', 'max'=>255),
			array('fecha, fechaInicio, fechaFin', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, idServicio, fecha, fechaInicio, fechaFin, importe, importeSaldo, estado, idCliente', 'safe', 'on'=>'search'),
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
			'servicio' => array(self::BELONGS_TO, 'Servicios', 'idServicio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idServicio' => 'Servicio',
			'fecha' => 'Fecha',
			'fechaInicio' => 'Fecha Inicio',
			'fechaFin' => 'Fecha Fin',
			'importe' => 'Importe',
			'importeSaldo' => 'Importe Saldo',
			'estado' => 'Estado',
			'idCliente' => 'Cliente',
		);
	}

	public function getTodos()
	{
		$criteria=new CDbCriteria;
		//$criteria->addCondition('(NOW() NOT BETWEEN fechaInicio AND fechaFin) AND estado="ACTIVO"');
		return self::model()->findAll($criteria);
	}
	public function estaVencido()
	{
		$ahora=Date('Y-m-d');
		return $ahora > $this->fechaInicio && $ahora < $this->fechaFin;
	}
	public function desactivar()
	{
		$this->cliente->estado="IMPAGO";
		$this->cliente->save();
	}
	public function saldar()
	{
		$this->estado="PAGADA";
		$this->cliente->estado="ACTIVO";
		$this->cliente->save();
		$this->save();
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->buscar,'OR');
		$criteria->compare('idServicio',$this->buscar,'OR');
		$criteria->compare('fecha',$this->buscar,true,'OR');
		$criteria->compare('fechaInicio',$this->buscar,true,'OR');
		$criteria->compare('fechaFin',$this->buscar,true,'OR');
		$criteria->compare('importe',$this->buscar,'OR');
		$criteria->compare('importeSaldo',$this->buscar,'OR');
		$criteria->compare('estado',$this->buscar,true,'OR');
		$criteria->compare('idCliente',$this->buscar,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}