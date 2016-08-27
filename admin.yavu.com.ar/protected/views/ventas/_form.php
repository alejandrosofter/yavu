<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ventas-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span3'>
			<?php echo $form->select2Row($model,'idCliente',array('data'=>CHtml::listData(Clientes::model()->findAll(), 'id', 'razonSocial'),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span2')); ?>


			<?php echo $form->select2Row($model,'idServicio',array('data'=>CHtml::listData(Servicios::model()->findAll(), 'id', 'nombreServicio'),'options'=>array('placeholder'=>'seleccione','onchange'=>'cambiaServicio()')),array('class'=>'span2','onchange'=>'cambiaServicio()')); ?>

			<?php echo $form->textFieldRow($model,'periodicidad',array('class'=>'span1')); ?>

			

			<?php echo $form->datepickerRow($model,'fechaInicio',array('options'=>array('format'=>'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>

			<?php echo $form->textFieldRow($model,'cantidadMeses',array('class'=>'span1')); ?>
<?php echo $form->textFieldRow($model,'proximaFacturacion',array('class'=>'span1')); ?>
			</div>
<div class='span3'>
<?php echo $form->select2Row($model,'estado',array('data'=>CHtml::listData(Estados::model()->findAll(), 'id', 'nombreEstado'),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span3')); ?>

			<?php echo $form->textFieldRow($model,'nombreUsuario',array('class'=>'span3')); ?>
			<?php echo $form->textFieldRow($model,'claveAcceso',array('class'=>'span2')); ?>
			<?php echo $form->textFieldRow($model,'nombreDominio',array('class'=>'span3')); ?>
			

		</div>
</div>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('data-loading-text'=>'Cargando...'),
			'label'=>$model->isNewRecord ? 'Aceptar' : 'Guardar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
<script>
function cambiaServicio()
{
alert('sdf');

}
</script>