<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ventas-deuda-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span3'>
		<?php echo $form->textAreaRow($model,'detalle',array('class'=>'span3','maxlength'=>255)); ?>
			<?php echo $form->select2Row($model,'idVenta',array('data'=>CHtml::listData(Ventas::model()->findAll(), 'id', 'nombreVenta'),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span2')); ?>
<?php echo $form->datepickerRow($model,'fecha',array('options'=>array(),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>

			<?php echo $form->datepickerRow($model,'fechaVto',array('options'=>array(),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>

			
			</div>
<div class='span3'>
	<?php echo $form->textFieldRow($model,'importe',array('class'=>'span2')); ?>
			<?php echo $form->textFieldRow($model,'importeSaldo',array('class'=>'span2')); ?>

			<?php echo $form->select2Row($model,'estado',array('data'=>VentasDeuda::model()->estados(),'options'=>array('placeholder'=>'seleccione')),array('class'=>'span3')); ?>

			

			

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
