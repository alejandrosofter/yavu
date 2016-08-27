<?php

/**
 * This is the model class for table "propiedades".
 *
 * The followings are the available columns in table 'propiedades':
 * @property integer $id
 * @property string $nombrePropiedad
 * @property integer $idTipoPropiedad
 * @property integer $idEdificio
 *
 * The followings are the available model relations:
 * @property LiquidacionesItems[] $liquidacionesItems
 * @property Edificios $idEdificio0
 * @property PropiedadesTipos $idTipoPropiedad0
 * @property PropiedadesEntidades[] $propiedadesEntidades
 * @property PropiedadesPorcentajes[] $propiedadesPorcentajes
 */
class Propiedades extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Propiedades the static model class
	 */
	 public $buscar;
	 public $ordenar;
	 public $hijo;
	 public $padre;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	const ACTIVA='ACTIVA';
	const BAJA='BAJA';
	const NODISPONIBLE='NO DISPONIBLE';
	const IDPROPIEDAD=1;
	public function propiedadesEntidad($idEntidad,$agrupa=true)
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('entidades');
		$criteria->compare('entidades.idEntidad',$idEntidad,false);
		if($agrupa)$criteria->group='t.idEdificio';
		$criteria->order='t.nombrePropiedad';
		
		return Propiedades::model()->findAll($criteria);
		
	}
	public function buscarPropiedades($idEntidad,$idEdificio)
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('entidades');
		if($idEdificio!=null)$criteria->addCondition('idEdificio='.$idEdificio);
		if($idEntidad!='null')$criteria->addCondition('entidades.idEntidad='.$idEntidad);
		$criteria->order='t.nombrePropiedad';
		
		return Propiedades::model()->findAll($criteria);
	}
	
	public function getValores($porcentajes,$idPropiedad=null)
	{
		$arr=array();
		if($idPropiedad==null){
			$arr[]=100;
			for($i=1;$i<count($porcentajes);$i++)$arr[]=0;

		}
		else
		for($i=0;$i<count($porcentajes);$i++)$arr[]=PropiedadesPorcentajes::model()->getValor($idPropiedad,$porcentajes[$i]->id);
		return $arr;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'propiedades';
	}
	public function getEstados()
	{
		return array(self::ACTIVA=>'ACTIVA',self::BAJA=>'BAJA',self::NODISPONIBLE=>'NO DISPONIBLE');
	}
	public function cambiarEstado($estado)
	{
		$this->estado=$estado;
		$this->save();
	}
	public function getEntidadPaga()
	{
		foreach($this->entidades as $entidad)
			if($entidad->paga) return $entidad->entidad->id;
		if(count($this->entidades)>0)return $entidades[0]->entidad->id;
	}
	public function getColor()
	{
		if(isset($this->padre))return 'hijo';
		if(isset($this->hijo))return 'padre';
		if($this->estado==self::NODISPONIBLE)return "muted";
		if($this->estado==self::BAJA)return "muted";
		return '';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idTipoPropiedad, idEdificio,cantidadHabitacion,tieneCochera', 'numerical', 'integerOnly'=>true),
			array('nombrePropiedad,domicilio,estado', 'length', 'max'=>255),
			array('nombrePropiedad,porcentaje,idEntidadPaga, idTipoPropiedad','required'),
			array('detalle,provincia,domicilio,idPropiedadPadre,idEntidadPaga,porcentajeCochera','safe'),
			array('idUbicacion,provincia,idLocalidad,idPropiedadPadre,cantidadHabitacion,porcentajeCochera,cantidadBano,importe,mapsDireccion,puntuacion,tienePatio,tieneQuincho','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id,estado,provincia,domicilio,detalle, nombrePropiedad, idTipoPropiedad, idEdificio', 'safe', 'on'=>'search'),
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
			'liquidacionesItems' => array(self::HAS_MANY, 'LiquidacionesItems', 'idPropiedad'),
			'edificio' => array(self::BELONGS_TO, 'Edificios', 'idEdificio'),
			'ubicacion' => array(self::BELONGS_TO, 'Ubicaciones', 'idUbicacion'),
			'propiedadPadre' => array(self::BELONGS_TO, 'Propiedades', 'idPropiedadPadre'),
			'propiedadHijo' => array(self::HAS_ONE, 'Propiedades','idPropiedadPadre'),
			'tipoPropiedad' => array(self::BELONGS_TO, 'PropiedadesTipos', 'idTipoPropiedad'),
			'entidades' => array(self::HAS_MANY, 'PropiedadesEntidades', 'idPropiedad'),
			'deudas' => array(self::HAS_MANY, 'ParaCobrar', 'idPropiedad'),
			'media' => array(self::HAS_MANY, 'PropiedadesMedia', 'idPropiedad'),
			'localidad' => array(self::BELONGS_TO, 'Localidades', 'idLocalidad'),
			'porcentajes' => array(self::HAS_MANY, 'PropiedadesPorcentajes', 'idPropiedad'),
			'entidadPaga'=>array(self::BELONGS_TO, 'Entidades', 'idEntidadPaga'),
			'propietario' => array(self::HAS_ONE, 'Entidades', array('idEntidad'=>'id'),'through'=>'entidades','on'=>'idTipoEntidadPropiedad=1'),
			'inquilino' => array(self::HAS_ONE, 'Entidades', array('idEntidad'=>'id'),'through'=>'entidades','on'=>'idTipoEntidadPropiedad=2'),
		);
	}
	public function getPorcentaje($tipo)
	{
		$val=0;
		foreach($this->porcentajes as $porc)
			if($porc->idTipoPropiedad==$tipo)$val+= $porc->porcentaje;
		return $val;
	}
	public function getEntidad($tipo)
	{
		foreach($this->entidades as $item)
			if($item->idTipoEntidadPropiedad==$tipo)return $item->idEntidad;
		return null;
	}
	public function setPorcentajeAnterior()
	{
		$this->porcentaje=$this->getPorcentaje(1);
		$this->porcentajeCochera=$this->getPorcentaje(2);
		if($this->porcentajeCochera!=0)$this->tieneCochera=1;
		$this->idEntidadPaga=$this->getEntidad(1);
		if($this->idEntidadPaga==null)$this->idEntidadPaga=$this->getEntidad(2);
		$this->save();
	}
	public function quitarPadre()
	{
		$model=$this->propiedadHijo;
		if($model!=null)$model->delete();
	}
	public function quitarDeuda()
	{
		foreach($this->deudas as $item){
			$item->quitarComprobantes();
			$item->quitarLiquidaciones();
			$item->delete();

		}
	}

	public function getLabelEntidades()
	{
		$cad='';
		foreach($this->entidades as $entidad)
			$cad.=$entidad->entidad->razonSocial.' ('.$entidad->tipo->nombreEntidadTipo.')'.($entidad->paga?" <b>PAGA</b>":"").'<br>';
		return $cad;
	}
	public function getLabelEntidades2()
	{
		$cad='';
		foreach($this->entidades as $entidad)
			$cad.=$entidad->entidad->razonSocial.' ('.$entidad->tipo->nombreEntidadTipo.')'.($entidad->paga?"":"").' - ';
		return $cad;
	}
	public function getPorcentajePorTipo($idTipoPropiedad)
	{
		foreach($this->porcentajes as $porc)
		if($porc->idTipoPropiedad==$idTipoPropiedad)return $porc->porcentaje;
		return 0;
	}
	public function getLabelPorcentajes()
	{
		$cad='';
		foreach($this->porcentajes as $porcentaje)
			$cad.=$porcentaje->porcentaje.' % ('.$porcentaje->tipo->nombreTipoPropiedad.')'.'<br>';
		return $cad;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombrePropiedad' => 'Nombre Propiedad',
			'idTipoPropiedad' => 'Tipo Propiedad',
			'idEdificio' => 'Edificio',
			'idPropiedadPadre' => 'Ligado a...',
			'idLocalidad' => 'Localidad',
			'idUbicacion' => 'Ubicacion',
			'cantidadBano' => 'Banos',
			'porcentajeCochera' => '% cochera',
			'idEntidadPaga' => 'Quien Paga?',
		);
	}
	public function inmuebles($estado=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addCondition('isNull(idEdificio)');
		if($estado!=null)$criteria->addCondition('estado="'.$estado.'"');
		$criteria->order='t.nombrePropiedad';
		return self::model()->findAll($criteria);
	}
	public function searchInmuebles()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addCondition('isNull(idEdificio)');
		$criteria->order='t.nombrePropiedad';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getNombreGrilla()
	{
		if(isset($this->idPropiedadPadre))return ''.$this->nombrePropiedad;
		return  $this->nombrePropiedad;
	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->with=array('propiedadHijo');
		
		$criteria->compare('t.idEdificio',$this->idEdificio,false);
		$criteria->addCondition('!isNull(t.idEdificio)');//para que no se me mezcle con lo de los contratos
		$criteria->order='nombrePropiedad';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>array(
        'pageSize'=>30,
    ),
		));
	}
}