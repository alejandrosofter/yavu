<?php

/**
 * This is the model class for table "movimientos".
 *
 * The followings are the available columns in table 'movimientos':
 * @property integer $id
 * @property string $registro_id
 * @property string $fecha
 * @property string $area_id
 * @property string $tipoMovimiento
 * @property string $estado
 * @property string $comentario
 * @property string $created_at
 * @property string $updated_at
 */
class Movimientos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Movimientos the static model class
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
		return 'movimientos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registro_id, area_id, tipoMovimiento, estado', 'length', 'max'=>255),
			array('fecha, comentario, created_at, updated_at', 'safe'),
			array('registro_id, area_id', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, registro_id, fecha, area_id, tipoMovimiento, estado, comentario, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
	public function getTipoMovimientos()
	{
		return array('Entrada'=>'Entrada','Salida'=>'Salida');
	}
	public function cargar($modelRegistro)
	{
		$model=new Movimientos;
		$model->registro_id=$modelRegistro->id;
		$model->area_id=$modelRegistro->comision_id;
		$model->tipoMovimiento='Entrada';
		$model->estado='Tramitando';
		$model->comentario='Ingreso Inicial';
		$model->fecha=$modelRegistro->fechaIngreso;
		$model->save();
	}
	public function getEstados()
	{
		return array('Aceptado'=>'Aceptado','En Espera'=>'En Espera');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'area' => array(self::BELONGS_TO, 'Areas', 'area_id'),
			'registro' => array(self::BELONGS_TO, 'Registros', 'registro_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'registro_id' => 'Registro',
			'fecha' => 'Fecha',
			'area_id' => 'Area',
			'tipoMovimiento' => 'Tipo Movimiento',
			'estado' => 'Estado',
			'comentario' => 'Comentario',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->with=array('registro','area');
		$criteria->compare('registro.id',$this->buscar,true,'OR');
		$criteria->compare('area.nombreArea',$this->buscar,true,'OR');
		$criteria->compare('t.comentario',$this->buscar,true,'OR');
		$criteria->order='t.id desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}