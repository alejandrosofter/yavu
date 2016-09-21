<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'solicitud-servicio-estados-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span5'>
			<?php echo $form->textFieldRow($model,'idSolicitudServicio',array('class'=>'span5')); ?>

			<?php echo $form->textFieldRow($model,'idEstado',array('class'=>'span5')); ?>

			<?php echo $form->textAreaRow($model,'detalle',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

			<?php echo $form->textFieldRow($model,'fechaHora',array('class'=>'span5')); ?>

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
