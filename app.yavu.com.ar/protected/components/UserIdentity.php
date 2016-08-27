<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id;
	public $usuario;
	public function authenticate()
	{
		//VALIDO CON LA BASE YAVU $this->password
		$clave=hash('ripemd160', $this->password);
		$usuario=trim(strtolower($this->username));
		$sql="select * from clientes where nombreUsuario='".$usuario."' AND claveAcceso='".$clave."'";
		$data = Yii::app()->dbYavu->createCommand($sql)->query();
		$usuarioValido=count($data)>0?true:false;
		$datosUsuario=$this->getBase($data);

		$sql="select * from clientes_deudas inner join servicios on servicios.id = clientes_deudas.idServicio where idCliente=".$datosUsuario['id']." order by clientes_deudas.id desc,estado asc"; // el ultimo activo esta arriba
		$dataVenta = Yii::app()->dbYavu->createCommand($sql)->query();
		$dataVenta=$this->getBase($dataVenta);
		if (!$usuarioValido)  $this->errorCode= self::ERROR_PASSWORD_INVALID;
			else { 
				$this->_id= $datosUsuario['id'];
				
				setcookie("logueadoYAVU",$datosUsuario['nombreUsuario'],time()+1400);
				
				$this->errorCode=self::ERROR_NONE; 
				
				$this->setState('usuario', $usuario);
				$this->setState('versionYavu', $datosUsuario['versionYavu']);
				$this->setState('emailCliente', $datosUsuario['email']);
				$this->setState('condicionFiscal', $datosUsuario['idCondicionIva']);
				$this->setState('celular', $datosUsuario['telefono']);
				$this->setState('nombre', $datosUsuario['nombre']);
				$this->setState('apellido', $datosUsuario['apellido']);
				$this->setState('recomendado', $datosUsuario['recomendado']);
				$this->setState('idCliente', $datosUsuario['id']); 
				$this->setState('saldo', $datosUsuario['importeSaldo']); 

				$this->setState('fechaInicio', $dataVenta['fechaInicio']);
				$this->setState('idServicio', $dataVenta['idServicio']);
				$this->setState('estado', $dataVenta['estado']);
				$this->setState('nombreServicio', $dataVenta['nombreServicio']);
				$this->setState('importeServicio', $dataVenta['importeSaldo']);
				$this->setState('fechaFin', $dataVenta['fechaFin']);
			return;
			      }
		
			return !$this->errorCode; 
	}
	private function getCondicionFiscal($iva)
	{
		if($iva==1)return 'Monotributo';
		if($iva==2)return 'Responsable Insc.';
		if($ival==3)return 'Excento';
	}
	private function getBase($data)
	{
		foreach($data as $item)return $item;
	}
	public function getId()
        {
                return $this->_id;
        }
        public function getEsWeb()
        {
        	return $this->_esWeb;
        }
        public function getUsuario()
        {
                return $this->usuario;
        }
}