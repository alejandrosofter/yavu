<?php

/**
 * This is the model class for table "solicitudesServicio".
 *
 * The followings are the available columns in table 'solicitudesServicio':
 * @property integer $id
 * @property string $fechaHora
 * @property integer $idCliente
 * @property string $requerimiento
 * @property integer $idEstado
 * @property integer $esUrgencia
 */
class SolicitudesServicio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SolicitudesServicio the static model class
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
		return 'solicitudesServicio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idCliente, idEstado, esUrgencia', 'numerical', 'integerOnly'=>true),
			array('fechaHora, idCliente, requerimiento', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, fechaHora, idCliente, requerimiento, idEstado, esUrgencia', 'safe', 'on'=>'search'),
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
			'entidad' => array(self::BELONGS_TO, 'Entidades', 'idCliente'),
			'estado' => array(self::BELONGS_TO, 'SolicitudesServicioNombreEstados', 'idEstado'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechaHora' => 'Fecha',
			'idCliente' => 'Cliente',
			'requerimiento' => 'Requerimiento',
			'idEstado' => 'Estado',
			'esUrgencia' => 'Es Urgencia',
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
		$criteria->compare('fechaHora',$this->buscar,true,'OR');
		$criteria->compare('idCliente',$this->buscar,'OR');
		$criteria->compare('requerimiento',$this->buscar,true,'OR');
		$criteria->compare('idEstado',$this->buscar,'OR');
		$criteria->compare('esUrgencia',$this->buscar,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getImpresion($id)
	{
		$model=SolicitudesServicio::model()->findByPk($id);
		$date = date_create($model->fechaHora);
		$logo=Imagenes::model()->getImagen("LOGOEMPRESA",true,"width:300px");
	$params['fecha']= date_format($date, 'd/m/Y');
	$params['requerimiento']=$model->requerimiento;
	$params['cliente']=$model->entidad->razonSocial;
	$params['logo']=$logo;
	Yii::app()->controller->layout="//layouts/layoutSoloSolo";
	$texto=Yii::app()->controller->renderPartial('modeloComprobante',array('params'=>$params),true);
	
	return $texto.$texto;
	}
	public function getNombreClassColor()
	{
		if($this->idEstado==1)return "ingresado";
		if($this->idEstado==2)return "pendiente";
		if($this->idEstado==3)return "finalizado";
		return "";
	}
	public function consultar($nomCli)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('entidad','estado');
		$criteria->addCondition("entidad.razonSocial like '%".$nomCli."%'");
	$criteria->order="t.id desc";
		return self::model()->findAll($criteria);
	}
}