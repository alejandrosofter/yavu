<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id
 * @property string $nombreUsuario
 * @property string $clave
 * @property string $fechaAlta
 * @property string $email
 * @property string $imagen
 * @property integer $esAdministrativo
 * @property integer $idEstado
 *
 * The followings are the available model relations:
 * @property AsociadosUsuario[] $asociadosUsuarios
 * @property Mensajes[] $mensajes
 * @property Estados $idEstado0
 */
class Usuarios extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultarServer($func)
	{
		$estado=Settings::model()->getValorSistema('SOAP_ESTADO_CUENTA')*1;
		if($estado!=0){
			$data=trim(file_get_contents('estado'));
			$arrData=explode(';',$data);
			$idVenta=(int)trim($arrData[0]);
			ini_set ( 'soap.wsdl_cache_enable' , 0 ); ini_set ( 'soap.wsdl_cache_ttl' , 0 );
			$ip=gethostbyname(Settings::model()->getValorSistema('HOST_WEB_SOAP'));
			$client=new SoapClient('http://'.$ip.'/index.php?r=Clientes/servicios3');
			return $client->$func($idVenta);
		}return 0;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}
	public function menuPrincipal($menu)
	{
		$tipo='menu'.Yii::app()->user->versionYavu;
		return $this->$tipo($menu);
	}
	private function menucomercial($menu)
	{
		return array(
			array('label'=>'Inicio','icon'  => 'home', 'url'=>'index.php?r=usuarios/cuenta'),
			array('label'=>'Entidades','icon'  => 'icon-user', 'url'=>'#', 'items'=>array(                   
                    array('label'=>'Ver Entidades', 'url'=>'index.php?r=entidades'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=entidades/create'),
                )),
			 array('label'=>'Pagos','icon'  => 'icon-list-alt', 'url'=>'#', 'items'=>array(
                   
                    array('label'=>'Ver Pagos', 'url'=>'index.php?r=Pagos'),
                    //array('label'=>'Agregar', 'url'=>'index.php?r=Pagos/create'),
                    '',
                    array('label'=>'Forma de Pagos', 'url'=>'index.php?r=PagosFormas/'),
                )),
			 array('label'=>'Comprobantes','icon'  => 'icon-plus', 'url'=>'#', 'items'=>array(
                   
                    array('label'=>'Ver Comprobantes', 'url'=>'index.php?r=Comprobantes'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=Comprobantes/agregarComprobante'),
                    '',
                    array('label'=>'Tipo de Comprobantes', 'url'=>'index.php?r=TalonariosTipos'),
                 // '---',
                 // array('label'=>'Ver Pagos','visible'=>Yii::app()->user->checkAccess("Pagos.Index"), 'url'=>'index.php?r=Pagos'),
                 //  array('label'=>'Agregar','visible'=>Yii::app()->user->checkAccess("Pagos.Create"),  'url'=>'index.php?r=Pagos/create'),
            
                )),
			  array('label'=>'Envio de Mails','icon'  => 'envelope', 'url'=>'index.php?r=mail'),
			  null,
count($menu)>0?array('label'=>'<span class="label label-info">'.count($menu).' acción</span>','type'=>'html', 'url'=>'#','activeCssClass'=>'icon-user', 'items'=>$menu):null,



			);
        
	}
	private function menuinmobiliaria($menu)
	{
		return array(
			array('label'=>'Entidades','icon'  => 'icon-user', 'url'=>'#', 'items'=>array(                   
                    array('label'=>'Ver Entidades', 'url'=>'index.php?r=entidades'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=entidades/create'),
                )),
			 array('label'=>'Para Cobrar','icon'  => 'icon-list-alt', 'url'=>'#', 'items'=>array(
                   
                    array('label'=>'Ver Para Cobrar', 'url'=>'index.php?r=ParaCobrar'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=ParaCobrar/create'),
                    '--',
                     array('label'=>'Liquidar Deuda', 'url'=>'index.php?r=Comprobantes/LiquidarItems'),
                )),
			 array('label'=>'Comprobantes','icon'  => 'icon-plus', 'url'=>'#', 'items'=>array(
                   
                    array('label'=>'Ver Comprobantes', 'url'=>'index.php?r=Comprobantes'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=Comprobantes/agregarComprobante'),
                    '',
                    array('label'=>'Tipo de Comprobantes', 'url'=>'index.php?r=TalonariosTipos'),
                 // '---',
                 // array('label'=>'Ver Pagos','visible'=>Yii::app()->user->checkAccess("Pagos.Index"), 'url'=>'index.php?r=Pagos'),
                 //  array('label'=>'Agregar','visible'=>Yii::app()->user->checkAccess("Pagos.Create"),  'url'=>'index.php?r=Pagos/create'),
            
                )),
			  array('label'=>'Expensas','icon'  => 'icon-minus', 'url'=>'#', 'items'=>array(
                  
                   array('label'=>'Gastos Frecuentes','icon'  => 'icon-retweet', 'url'=>'#', 'items'=>array(
                    array('label'=>'Gastos Frecuentes', 'url'=>'index.php?r=edificiosGastosFrecuentes'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=edificiosGastosFrecuentes/create'),
                    '---',
                     array('label'=>'Aplicar Gastos Frecuentes',  'url'=>'index.php?r=edificiosGastosFrecuentes/aplicar'),
                   
                   
                )),

                  
                     array('label'=>'Gastos','icon'  => 'icon-upload', 'url'=>'#', 'items'=>array(
                    array('label'=>'Gastos', 'url'=>'index.php?r=Gastos'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=Gastos/create'),
               
                   
                   
                )),
                     array('label'=>'Liquidaciones','icon'  => 'icon-book', 'url'=>'#', 'items'=>array(
                    array('label'=>'Liquidaciones', 'url'=>'index.php?r=Liquidaciones'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=Liquidaciones/create'),
               
                   
                   
                )),
                   array('label'=>'Estadisticas','icon'  => 'icon-signal', 'url'=>'index.php?r=Estadisticas/expensas'), 
                )),
				//PROP
array('label'=>'Propiedades','icon'  => 'icon-home', 'url'=>'#', 'items'=>array(
                    array('label'=>'Propiedades','icon'  => 'icon-home', 'url'=>'#', 'items'=>array(
                    array('label'=>'Consultar', 'url'=>'index.php?r=Propiedades'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=Propiedades/create'),
               
                   
                   
                )),
                   array('label'=>'Contratos','icon'  => 'icon-file', 'url'=>'#', 'items'=>array(                   
                    array('label'=>'Contratos','icon'  => 'icon-file', 'url'=>'#', 'items'=>array(
                    array('label'=>'Contratos','url'=>'index.php?r=Contratos'),
                    array('label'=>'Agregar', 'url'=>'index.php?r=Contratos/create'),
               
                   
                   
                )),
                    array('label'=>'Estadisticas','icon'  => 'icon-signal', 'url'=>'index.php?r=Estadisticas/contratos'), 
                )),
                     array('label'=>'Consultas','icon'  => 'icon-comment', 'url'=>'#', 'items'=>array(
                    array('label'=>'Consultas', 'url'=>'index.php?r=PropiedadesConsultas'),
                    array('label'=>'Agregar',  'url'=>'index.php?r=PropiedadesConsultas/create'),
               
                   
                   
                )),
                     array('label'=>'Edificios', 'icon'  => 'icon-th-large', 'url'=>'#', 'items'=>array(
                    array('label'=>'Edificios', 'url'=>'index.php?r=Edificios'),
                    array('label'=>'Agregar',  'url'=>'index.php?r=Edificios/create'),
               
                   
                   
                )),
                     array('label'=>'Localidades', 'icon'  => 'icon-', 'url'=>'#', 'items'=>array(
                    array('label'=>'Localidades', 'url'=>'index.php?r=Localidades'),
                    array('label'=>'Agregar',  'url'=>'index.php?r=Localidades/create'),
               
                   
                   
                )),
                      array('label'=>'Ubicaciones','icon'  => 'icon-', 'url'=>'#', 'items'=>array(
                    array('label'=>'Ubicaciones', 'url'=>'index.php?r=Ubicaciones'),
                    array('label'=>'Agregar',  'url'=>'index.php?r=Ubicaciones/create'),
               
                   
                   
                )),
                )),
array('label'=>'','encodeLabel'=>true,'icon'  => 'arrow-down white', 'url'=>'#','activeCssClass'=>'icon-user', 'items'=>$menu),



			);
        
	}

	public function asignarPrivilegios($esAdmin,$id)
	{
		$connection=Yii::app()->getDb();
		if($esAdmin)
        $command=$connection->createCommand(
			"INSERT INTO  `AuthAssignment` (
			`itemname` ,
			`userid` ,
			`bizrule` ,
			`data`
			)
			VALUES (
			'Admin',  '".$id."', NULL ,'N;'
			);");
        else 
        $command=$connection->createCommand(
			"INSERT INTO  `AuthAssignment` (
			`itemname` ,
			`userid` ,
			`bizrule` ,
			`data`
			)
			VALUES (
			'asociados',  '".$id."', NULL , NULL
			);");
            
            return $command->query();
	}
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('esAdministrativo, idEstado', 'numerical', 'integerOnly'=>true),
			array('nombreUsuario, clave, email,fechaAlta', 'length', 'max'=>255),
			array('nombreUsuario, clave', 'required'),
			array('nombreUsuario', 'unique'),
			array('email', 'email'),
			array('imagen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombreUsuario, clave, fechaAlta, email, imagen, esAdministrativo, idEstado', 'safe', 'on'=>'search'),
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
			'asociadosUsuarios' => array(self::HAS_MANY, 'AsociadosUsuario', 'idUsuario'),
			'mensajes' => array(self::HAS_MANY, 'Mensajes', 'idUsuarioEmisor'),
			'idEstado0' => array(self::BELONGS_TO, 'Estados', 'idEstado'),
			'asociado' => array(self::HAS_ONE, 'AsociadosUsuario', 'idUsuario'),
		);
	}
	public function getNombreUsuarioAsociado()
	{
		if(isset($this->asociado))
			return $this->asociado->asociado->apellido.' '.$this->asociado->asociado->nombre;
		return $this->nombreUsuario;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombreUsuario' => 'Nombre Usuario',
			'clave' => 'Clave',
			'fechaAlta' => 'Fecha Alta',
			'email' => 'Email',
			'imagen' => 'Imagen',
			'esAdministrativo' => 'Es Administrativo?',
			'idEstado' => 'Estado',
		);
	}

	public function validarUsuario ($usuario,$clave)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('t.nombreUsuario', $usuario, false);
		$criteria->compare('t.clave', $clave, false);
		
		return self::model()->findAll($criteria);
	}
	public function administrativos()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('esAdministrativo',1,false);
		return self::model()->findAll($criteria);

	}
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombreUsuario',$this->nombreUsuario,true);
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('fechaAlta',$this->fechaAlta,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('imagen',$this->imagen,true);
		$criteria->compare('esAdministrativo',$this->esAdministrativo);
		$criteria->compare('idEstado',$this->idEstado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}