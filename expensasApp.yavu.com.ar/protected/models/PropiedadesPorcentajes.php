<?php

/**
 * This is the model class for table "propiedades_porcentajes".
 *
 * The followings are the available columns in table 'propiedades_porcentajes':
 * @property integer $id
 * @property double $porcentaje
 * @property integer $idTipoGasto
 * @property integer $idPropiedad
 *
 * The followings are the available model relations:
 * @property Propiedades $idPropiedad0
 * @property GastosTipos $idTipoGasto0
 */
class PropiedadesPorcentajes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PropiedadesPorcentajes the static model class
	 */
	 public $buscar;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function cargar($idPropiedad,$porcentajes)
	{
		$this->quitarTodos($idPropiedad);
		for($i=0;$i<count($porcentajes);$i++)
			$this->cargarGasto($idPropiedad,$porcentajes[$i]['valor'],$porcentajes[$i]['idTipo']);
	}
	private function cargarGasto($idPropiedad,$valor,$idTipo)
	{
			$model=new PropiedadesPorcentajes;
			$model->idPropiedad=$idPropiedad;
			$model->idTipoPropiedad=$idTipo;
			$model->porcentaje=$valor;
			$model->save();
	}
	private function quitarTodos($idPropiedad)
	{
		$res=$this->consultar($idPropiedad);
		foreach($res as $item)$item->delete();
	}
	private function consultar($id)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('idPropiedad',$id,false);
		return self::model()->findAll($criteria);
	}
	public function getValor($idPropiedad,$idTipoGasto)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('idPropiedad',$idPropiedad,false);
		$criteria->compare('idTipoPropiedad',$idTipoGasto,false);
		$res= self::model()->findAll($criteria);
		if(count($res)>0)return $res[0]->porcentaje;
		return 0;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'propiedades_porcentajes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idTipoPropiedad, idPropiedad', 'numerical', 'integerOnly'=>true),
			array('porcentaje', 'numerical'),
			array('porcentaje', 'required'),
			array('porcentaje', 'compare','compareValue'=>0,'operator'=>'>'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, porcentaje, idTipoPropiedad, idPropiedad', 'safe', 'on'=>'search'),
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
			'propiedad' => array(self::BELONGS_TO, 'Propiedades', 'idPropiedad'),
			'tipo' => array(self::BELONGS_TO, 'PropiedadesTipos', 'idTipoPropiedad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'porcentaje' => 'Porcentaje',
			'idTipoPropiedad' => 'Tipo Propiedad',
			'idPropiedad' => 'Propiedad',
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

		$criteria->compare('idPropiedad',$this->idPropiedad,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}