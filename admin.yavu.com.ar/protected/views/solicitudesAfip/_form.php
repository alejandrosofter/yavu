<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'solicitudes-afip-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span5'>
			
			<?php echo $form->select2Row($model,'idCliente',array('data'=>CHtml::listData(Clientes::model()->findAll(), 'id', 'nombreUsuario'),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span2')); ?>


			<?php echo $form->textFieldRow($model,'claveAFIP',array('class'=>'span2','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'cuitAFIP',array('class'=>'span2','maxlength'=>255)); ?>

			<?php echo $form->select2Row($model,'estado',array('data'=>SolicitudesAfip::getEstados(),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span2')); ?>
<?php echo $form->datepickerRow($model,'fecha',array('options'=>array(),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>


			<?php echo $form->datepickerRow($model,'fechaPago',array('options'=>array(),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>

			<?php echo $form->datepickerRow($model,'fechaAlta',array('options'=>array(),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>

			<?php echo $form->textAreaRow($model,'observaciones',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

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
