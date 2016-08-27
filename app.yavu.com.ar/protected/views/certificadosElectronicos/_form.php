<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'certificados-electronicos-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span5'>
			<?php echo $form->datepickerRow($model,'fechaCreacion',array('options'=>array(),'htmlOptions'=>array('class'=>'span5')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

			<?php echo $form->datepickerRow($model,'fechaExpira',array('options'=>array(),'htmlOptions'=>array('class'=>'span5')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

			<?php echo $form->textFieldRow($model,'archivoCertificado',array('class'=>'span5','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'archivoCsr',array('class'=>'span5','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'archivoKey',array('class'=>'span5','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'estado',array('class'=>'span5','maxlength'=>255)); ?>

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
