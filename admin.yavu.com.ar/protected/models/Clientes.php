<?php

/**
 * This is the model class for table "clientes".
 *
 * The followings are the available columns in table 'clientes':
 * @property integer $id
 * @property string $razonSocial
 * @property string $domicilio
 * @property string $telefono
 * @property string $cuit
 * @property integer $idCondicionIva
 * @property string $nombreUsuario
 * @property string $claveAcceso
 * @property string $nombreDominio
 */
class Clientes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Clientes the static model class
	 */
	 public $buscar;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function restaSaldo($importe)
	{
		$this->importeSaldo=$this->importeSaldo-$importe;
		$this->save();
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idCondicionIva', 'numerical', 'integerOnly'=>true),
				array('fechaVto,estado,importeSaldo',  'required'),
			
			array('recomendado, domicilio, telefono, cuit, nombreUsuario, claveAcceso, nombreDominio', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, recomendado, importeSaldo,domicilio, telefono, cuit, idCondicionIva, nombreUsuario, claveAcceso, nombreDominio', 'safe', 'on'=>'search'),
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
			'condicionIva' => array(self::BELONGS_TO, 'CondicionesIva', 'idCondicionIva'),
		);
	}
	public function bajarCliente()
	{
		$this->estado="IMPAGO";
		$this->save();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'razonSocial' => 'Razon Social',
			'domicilio' => 'Domicilio',
			'telefono' => 'Telefono',
			'cuit' => 'Cuit',
			'idCondicionIva' => 'Condicion Iva',
			'nombreUsuario' => 'Nombre de Usuario',
			'claveAcceso' => 'Clave Acceso',
			'nombreDominio' => 'Nombre Dominio',
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
		$criteria->compare('razonSocial',$this->buscar,true,'OR');
		$criteria->compare('domicilio',$this->buscar,true,'OR');
		$criteria->compare('telefono',$this->buscar,true,'OR');
		$criteria->compare('cuit',$this->buscar,true,'OR');
		$criteria->compare('idCondicionIva',$this->buscar,'OR');
		$criteria->compare('nombreUsuario',$this->buscar,true,'OR');
		$criteria->compare('claveAcceso',$this->buscar,true,'OR');
		$criteria->compare('nombreDominio',$this->buscar,true,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}