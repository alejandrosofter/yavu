<h3>GENERAL</h3>
<div class="content-form">
<h4>Intereses</h4>

		<p><?php echo 'Días activación interes' ?>
		<?php echo CHtml::textField('GENERALES_DIASNTERES',Settings::model()->getValorSistema('GENERALES_DIASNTERES'),array('class'=>'span1','maxlength'=>64));
		
		 ?>
		</p>
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
		
	</p>
</div>