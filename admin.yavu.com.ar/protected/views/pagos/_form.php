<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pagos-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span5'>
			<?php echo $form->datepickerRow($model,'fecha',array('options'=>array('format'=>'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>
			<?php echo $form->select2Row($model,'idCliente',array('data'=>CHtml::listData(Clientes::model()->findAll(), 'id', 'nombreUsuario'),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span2')); ?>

			<?php echo $form->select2Row($model,'idFormaPago',array('data'=>CHtml::listData(FormasPago::model()->findAll(), 'id', 'nombreFormaPago'),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model,'estado',array('class'=>'span2')); ?>
<?php echo $form->textFieldRow($model,'idReferenciaMP',array('class'=>'span2')); ?>
			<?php echo $form->textFieldRow($model,'importe',array('class'=>'span2')); ?>
<?php echo $form->textAreaRow($model,'detalleRtaMP',array('class'=>'span6','rows'=>10)); ?>
			

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
