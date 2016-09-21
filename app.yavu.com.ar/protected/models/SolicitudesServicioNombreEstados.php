<?php

/**
 * This is the model class for table "solicitudesServicio_nombreEstados".
 *
 * The followings are the available columns in table 'solicitudesServicio_nombreEstados':
 * @property integer $id
 * @property string $nombreEstadoSolicitud
 */
class SolicitudesServicioNombreEstados extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SolicitudesServicioNombreEstados the static model class
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
		return 'solicitudesServicio_nombreEstados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombreEstadoSolicitud', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, nombreEstadoSolicitud', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombreEstadoSolicitud' => 'Nombre Estado Solicitud',
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
		$criteria->compare('nombreEstadoSolicitud',$this->buscar,true,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}