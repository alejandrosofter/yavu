<?php

/**
 * This is the model class for table "pagos".
 *
 * The followings are the available columns in table 'pagos':
 * @property integer $id
 * @property string $fecha
 * @property integer $idFormaPago
 * @property double $importe
 * @property integer $idCliente
 *
 * The followings are the available model relations:
 * @property PagosDeudas[] $pagosDeudases
 */
class Pagos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pagos the static model class
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
		return 'pagos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idFormaPago, idCliente', 'numerical', 'integerOnly'=>true),
			array('importe', 'numerical'),
			array('fecha', 'safe'),
			array('idCliente,idVenta,importe,fecha', 'safe'),
			array('idVenta,importe,fecha', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, fecha, idFormaPago, importe, idCliente', 'safe', 'on'=>'search'),
		);
	}
	public function agregarSaldo($idPago)
	{
			$model=Pagos::model()->findByPk($idPago);
			$importe=$model->importe;
			foreach($model->venta->ventasDeudas as $deuda){
				$resto=$importe-$deuda->importeSaldo;
				$importeDebita=$resto>0?$deuda->importeSaldo:$importe;
				$deuda->importeSaldo-=$importeDebita;
				if($deuda->importeSaldo==0)$deuda->estado="CANCELADO";
				$deuda->save();
				$importe-=$importeDebita;
			}
			$model->venta->cliente->restaSaldo(-$model->importe);//agrego el pago al saldo
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'pagosDeudases' => array(self::HAS_MANY, 'PagosDeudas', 'idPago'),
			'cliente' => array(self::BELONGS_TO, 'Clientes', 'idCliente'),
			'venta' => array(self::BELONGS_TO, 'Ventas', 'idVenta'),
			'formaPago' => array(self::BELONGS_TO, 'FormasPago', 'idFormaPago'),
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
			'fecha' => 'Fecha',
			'idFormaPago' => 'Forma de Pago',
			'importe' => 'Importe',
			'idCliente' => 'Cliente',
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
		$criteria->compare('idFormaPago',$this->buscar,'OR');
		$criteria->compare('importe',$this->buscar,'OR');
		$criteria->compare('idCliente',$this->buscar,'OR');
		$criteria->order="t.id desc";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}