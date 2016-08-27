<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clientes-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span3'>
	
			<?php echo $form->textFieldRow($model,'recomendado',array('class'=>'span3','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span3','maxlength'=>255)); ?>
			<?php echo $form->textFieldRow($model,'apellido',array('class'=>'span3','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'domicilio',array('class'=>'span3','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'telefono',array('class'=>'span3','maxlength'=>255)); ?>
			<?php echo $form->textFieldRow($model,'versionYavu',array('class'=>'span3','maxlength'=>255)); ?>
			<?php echo $form->textFieldRow($model,'estado',array('class'=>'span3','maxlength'=>255)); ?>

</div>
<div class='span3'>
			<?php echo $form->select2Row($model,'idCondicionIva',array('data'=>CHtml::listData(CondicionesIva::model()->findAll(), 'id', 'nombreIva'),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model,'email',array('class'=>'span3','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'nombreUsuario',array('class'=>'span3','maxlength'=>255)); ?>
			<?php echo $form->textFieldRow($model,'claveAcceso',array('class'=>'span3','maxlength'=>255)); ?>
			<?php echo $form->textFieldRow($model,'verificado',array('class'=>'span2','maxlength'=>255)); ?>
			<?php echo $form->textFieldRow($model,'cuit',array('class'=>'span2','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'importeSaldo',array('class'=>'span2','maxlength'=>255)); ?>
<?php echo $form->datepickerRow($model,'fechaVto',array('options'=>array('format'=>'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>
			


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
