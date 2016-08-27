<?php

/**
 * This is the model class for table "pagos".
 *
 * The followings are the available columns in table 'pagos':
 * @property integer $id
 * @property integer $idComprobante
 * @property string $fecha
 * @property double $importe
 *
 * The followings are the available model relations:
 * @property Comprobantes $idComprobante0
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
	public function week($anterior=false,$resultadosArray=false)
	{
		$dias=$anterior?"-7":"0";
		$anterior="DATE_ADD(curdate(),INTERVAL ".$dias." DAY)";
		$resultados=$resultadosArray?"*":"sum(t.importe) as importe";
		$connection=Yii::app()->getDb();
        $sql="SELECT ".$resultados." from pagos t inner join comprobantes on comprobantes.id=t.idComprobante WHERE yearweek(t.fecha)=yearweek(".$anterior.") AND comprobantes.estado='ACTIVA'";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        if($resultadosArray) return $res;
        if(count($res)>0)return $res[0]['importe'];
        return 0;
	}
	public function mes($anterior=false,$resultadosArray=false)
	{
		$dias=$anterior?"-31":"0";
		$anterior="DATE_ADD(curdate(),INTERVAL ".$dias." DAY)";
		$resultados=$resultadosArray?"*":"sum(t.importe) as importe";
		$connection=Yii::app()->getDb();
        $sql="SELECT ".$resultados." from pagos t inner join comprobantes on comprobantes.id=t.idComprobante WHERE month(t.fecha)=month(".$anterior.") AND comprobantes.estado='ACTIVA'";
        $command=$connection->createCommand($sql);
        $res= $command->queryAll();
        if($resultadosArray) return $res;
        if(count($res)>0)return $res[0]['importe'];
        return 0;
	}
	public function ingresaPago($idComp,$importe,$idFormaPago)
	{
		$modelCom=Comprobantes::model()->findByPk($idComp);
		$model=new Pagos;
		$model->idComprobante=$idComp;
		$model->fecha=$modelCom->fecha;
		$model->idFormaPago=$idFormaPago;
		$model->importe=$importe;
		$model->save();
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
			array('idComprobante', 'numerical', 'integerOnly'=>true),
			array('importe,idFormaPago', 'numerical'),
			array('fecha,idFormaPago', 'safe'),
			array('fecha,importe', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, idComprobante,idFormaPago, fecha, importe', 'safe', 'on'=>'search'),
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
			'comprobante' => array(self::BELONGS_TO, 'Comprobantes', 'idComprobante'),
			'formaPago' => array(self::BELONGS_TO, 'PagosFormas', 'idFormaPago'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idComprobante' => 'Comprobante',
			'fecha' => 'Fecha',
			'importe' => 'Importe',
			'idFormaPago' => 'Forma de Pago',
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

		$criteria->compare('idComprobante',$this->idComprobante,false);
		$criteria->compare('fecha',$this->buscar,true,'OR');
		$criteria->compare('importe',$this->buscar,'OR');

		return Pagos::model()->findAll($criteria);
	}
	public function buscar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idComprobante',$this->idComprobante,false);
		$criteria->compare('fecha',$this->buscar,true,'OR');
		$criteria->compare('importe',$this->buscar,'OR');
		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
