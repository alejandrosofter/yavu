<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	protected function beforeAction($event)
    {
		$usuario=YavuWeb::getCliente();
	    $editoDatosEmpresa=Settings::getValorSistema('ACTUALIZO_DATOS')*1;
		if($usuario['estado']!='ACTIVO'){
			$error=$usuario['estado']=="A_VALIDAR"?"TIENES QUE <b>VALIDAR TU CUENTA</b> DANDO CLICK EN EL CORREO QUE TE ENVIAMOS aA <b>".$usuario['email']."</b>!":'<b>EL SISTEMA ESTA ddINACTIVO</b>, POR FAVOR REGULARIZA TU CUENTA PARA TENER NUEVAMENTE EL SISTEMA ACTIVO!';
			
			Yii::app()->user->setFlash('error',$error);
			
			$this->redirect(array('/usuarios/cuenta'));

		}
		if($editoDatosEmpresa==0){
			$error="OPSS... PRIMERO QUE TODO, TIENES QUE EDITAR LOS <a data-fancybox-type='iframe' class='imprime' href='index.php?r=site/editarDatosEmpresa'><b>DATOS DE TU EMPRESA</b></a> PARA PODER COMENZAR A OPERAR!";
			
			Yii::app()->user->setFlash('error',$error);
			
			if($this->layout=='//layouts/layoutSolo') echo '';
			else $this->redirect(array('/usuarios/cuenta'));
		}
		return parent::beforeAction($event);
	}
}