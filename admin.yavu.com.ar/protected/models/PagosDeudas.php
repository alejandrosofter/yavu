<?php

/**
 * This is the model class for table "pagos_deudas".
 *
 * The followings are the available columns in table 'pagos_deudas':
 * @property integer $id
 * @property integer $idPago
 * @property integer $idServicioDeuda
 *
 * The followings are the available model relations:
 * @property VentasDeuda $idServicioDeuda0
 * @property Pagos $idPago0
 */
class PagosDeudas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PagosDeudas the static model class
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
		return 'pagos_deudas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idPago, idServicioDeuda', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, idPago, idServicioDeuda', 'safe', 'on'=>'search'),
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
			'idServicioDeuda0' => array(self::BELONGS_TO, 'VentasDeuda', 'idServicioDeuda'),
			'idPago0' => array(self::BELONGS_TO, 'Pagos', 'idPago'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idPago' => 'Id Pago',
			'idServicioDeuda' => 'Id Servicio Deuda',
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
		$criteria->compare('idPago',$this->buscar,'OR');
		$criteria->compare('idServicioDeuda',$this->buscar,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}