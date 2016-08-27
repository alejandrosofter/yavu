<?php

/**
 * This is the model class for table "imagenes".
 *
 * The followings are the available columns in table 'imagenes':
 * @property integer $id
 * @property string $nombre
 * @property string $imagen
 * @property string $key
 */
class Imagenes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Imagenes the static model class
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
		return 'imagenes';
	}
	public function guardaLogo($ruta,$nombre)
	{
		$anchoLogo=200;
    	$anchoLogoTh=50;

    	$arr=explode('.',$nombre);
		$pos=count($arr)-1;
		$ext=$arr[$pos];

		include dirname(__FILE__).'/../extensions/SimpleImage.php';
    	$im=new SimpleImage;
    	$im->load($ruta);
		$im->resizeToWidth($anchoLogo);
		$im->save($ruta,$this->getTipo($ext));
		$imagen = (file_get_contents ($ruta));
		$key='LOGOEMPRESA';
		$img=$this->getImagen($key);
		
		if($img==false){
			$model=new Imagenes;
			$model->imagen=$imagen;
			$model->nombre=$nombre;
			$model->key=$key;
			$model->extension=$ext;
			$model->save();
		}else{
			$img->imagen=$imagen;
			$img->nombre=$nombre;
			$img->extension=$ext;
			$img->save();
		}
		return $this->getImagen($key,true);
	}
	private function getTipo($ext)
	{
		if($ext=="png")return "IMAGETYPE_PNG";
		if($ext=="gif")return "IMAGETYPE_GIF";
		return "IMAGETYPE_JPEG";
	}
	public function getImagen($key,$html=false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$ret=false;
		$criteria=new CDbCriteria;

		$criteria->addCondition('`key` = "'.$key.'"');

		$res= self::model()->findAll($criteria);
		if(count($res)>0)$ret= $res[0];
		if($ret)
		if($html)return $ret->getHtml();
		return $ret;
	}
	public function getHtml()
	{
		$arr=explode('.',$this->nombre);
		$pos=count($arr)-1;
		$ext=$arr[$pos];
		return '<img class="img-rounded" src="data:image/'.$ext.';base64,'.stripslashes(base64_encode( $this->imagen )).'"/>';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, imagen, key, extension', 'required'),
			array('nombre, key', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buscar,id, nombre, imagen, key', 'safe', 'on'=>'search'),
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
			'nombre' => 'Nombre',
			'imagen' => 'Imagen',
			'key' => 'Key',
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
		$criteria->compare('nombre',$this->buscar,true,'OR');
		$criteria->compare('imagen',$this->buscar,true,'OR');
		$criteria->compare('key',$this->buscar,true,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}