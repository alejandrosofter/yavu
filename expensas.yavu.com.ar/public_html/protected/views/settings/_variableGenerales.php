<h3>GENERAL</h3>
<div class="content-form">
<h4>Intereses</h4>

		<p><?php echo 'Interes diario' ?>
		<?php echo CHtml::textField('GENERALES_INTERESDIARIO',Settings::model()->getValorSistema('GENERALES_INTERESDIARIO'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
<h4>Redondeo</h4>

		<p><?php echo 'Redondeo de Importes' ?>
		<?php echo CHtml::textField('REDONDEO_IMPORTES',Settings::model()->getValorSistema('REDONDEO_IMPORTES'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
		 <span class='help-block'><b>NOTA: </b>Por favor ingresar la cantidad de decimales para el redondeo.</span>
		</p>
<h4>Liquidaciones</h4>

		<p><?php echo 'Resta Mes Resumen Expensas' ?>
		<?php echo CHtml::textField('RESTA_MES_EXPENSAS',Settings::model()->getValorSistema('RESTA_MES_EXPENSAS'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
		</p>	
		<span class='help-block'><b>NOTA: </b>Indica que si el mes es el numero 8 (AGOSTO), le restara la cantidad de meses ingresada. Ej. si es AGOSTO y se pone como valor 1, quedara en JULIO.</span>
		
<h4>Impresiones</h4>
<p><?php echo 'Mensaje MAIL de EXPENSAS' ?>
	<?php
	$this->widget(
    'boostrap.widgets.TbCKEditor',
    array(
        'name' => 'MENSAJE_MAIL_EXPENSAS',
        'id' => 'MENSAJE_MAIL_EXPENSAS',
        'value'=>Settings::model()->getValorSistema('MENSAJE_MAIL_EXPENSAS'),
        'editorOptions' => array(
            // From basic `build-config.js` minus 'undo', 'clipboard' and 'about'
            'plugins' => 'basicstyles,toolbar,enterkey,entities,floatingspace,wysiwygarea,indentlist,link,list,dialog,dialogui,button,indent,fakeobjects'
        )
    )
);
	?>
	 VARIABLES PERMITIDAS: %nombreEmpresa, %direccion,%telefono,%emailAdmin,%horarios,%lugarPago
		</p>
<p><?php echo 'Imprime Duplicado en Comprobantes?' ?>
		<?php echo CHtml::textField('IMPRESION_DUPLICADO',Settings::model()->getValorSistema('IMPRESION_DUPLICADO'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
		 1 en caso verdadero 0 para falso.
		</p>
<p><?php echo 'Tamaño FUENTE expensas' ?>
		<?php echo CHtml::textField('SIZE_EXPENSAS_FUENTE',Settings::model()->getValorSistema('SIZE_EXPENSAS_FUENTE'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
		</p>
		<p><?php echo 'Tamaño FUENTE comprobantes' ?>
		<?php echo CHtml::textField('SIZE_COMPROBANTES_FUENTE',Settings::model()->getValorSistema('SIZE_COMPROBANTES_FUENTE'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
		</p>
	<h4>Generales</h4>

		<p><?php echo 'Cantidad dias DESDE VENCIMIENTOS' ?>
		<?php echo CHtml::textField('CANTIAD_DESDE_VENC',Settings::model()->getValorSistema('CANTIAD_DESDE_VENC'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
		</p>
		<p><?php echo 'Cantidad dias HASTA VENCIMIENTOS' ?>
		<?php echo CHtml::textField('CANTIAD_HASTA_VENC',Settings::model()->getValorSistema('CANTIAD_HASTA_VENC'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
		</p>

</div>