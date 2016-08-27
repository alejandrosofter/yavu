<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'mail-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span5'>
			<?php echo $form->textFieldRow($model,'emisor',array('class'=>'span5','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'receptor',array('class'=>'span5','maxlength'=>255)); ?>

			<?php echo $form->textAreaRow($model,'mensaje',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

			<?php echo $form->textFieldRow($model,'fecha',array('class'=>'span5')); ?>

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
