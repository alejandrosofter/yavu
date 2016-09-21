<?php

/**
 * This is the model class for table "solicitudServicio_estados".
 *
 * The followings are the available columns in table 'solicitudServicio_estados':
 * @property integer $id
 * @property integer $idSolicitudServicio
 * @property integer $idEstado
 * @property string $detalle
 * @property string $fechaHora
 */
class SolicitudServicioEstados extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SolicitudServicioEstados the static model class
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
		return 'solicitudServicio_estados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idSolicitudServicio, idEstado', 'numerical', 'integerOnly'=>true),
			array('detalle, fechaHora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, idSolicitudServicio, idEstado, detalle, fechaHora', 'safe', 'on'=>'search'),
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
			'idSolicitudServicio' => 'Id Solicitud Servicio',
			'idEstado' => 'Id Estado',
			'detalle' => 'Detalle',
			'fechaHora' => 'Fecha Hora',
		);
	}
public function getNombreClassColor()
	{
		if($this->idEstado==1)return "ingresado";
		if($this->idEstado==2)return "pendiente";
		if($this->idEstado==3)return "finalizado";
		return "";
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function ingresar($idSolicitud,$idEstado,$fecha,$detalle)
	{
		$model=new SolicitudServicioEstados();
		$model->fechaHora=$fecha;
		$model->idEstado=$idEstado;
		$model->detalle=$detalle;
		$model->idSolicitudServicio=$idSolicitud;
		$res=$model->save(); 
		$modelSolicitud=SolicitudesServicio::model()->findByPk($idSolicitud);
		$modelSolicitud->idEstado=$idEstado;
		$modelSolicitud->save();
		return $res;
	}
	public function consultar($idSolicitud)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('estado');
		$criteria->addCondition("idSolicitudServicio=".$idSolicitud);
	$criteria->order="t.id desc";
		return self::model()->findAll($criteria);
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->buscar,'OR');
		$criteria->compare('idSolicitudServicio',$this->buscar,'OR');
		$criteria->compare('idEstado',$this->buscar,'OR');
		$criteria->compare('detalle',$this->buscar,true,'OR');
		$criteria->compare('fechaHora',$this->buscar,true,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}