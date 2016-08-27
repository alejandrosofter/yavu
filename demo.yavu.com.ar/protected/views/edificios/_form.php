<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'edificios-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span3'>
			<?php echo $form->textFieldRow($model,'nombreEdificio',array('class'=>'span3','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'domicilio',array('class'=>'span2','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'telefono',array('class'=>'span3','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'nombrePortero',array('class'=>'span2','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'email',array('class'=>'span3','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'cuit',array('class'=>'span3','maxlength'=>255)); ?>
	</div>
	<div class='span3'
			<?php echo $form->textAreaRow($model,'lugarPago',array('rows'=>5, 'cols'=>50, 'class'=>'span3')); ?>

			<?php echo $form->select2Row($model,'idCondicionIva',array('data'=>CHtml::listData(CondicionesIva::model()->findAll(), 'id', 'nombreIva')),array('class'=>'span5')); ?>


			<?php echo $form->textFieldRow($model,'proximoRecibo',array('class'=>'span1')); ?>

			<?php echo $form->textFieldRow($model,'localidad',array('class'=>'span3','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'provincia',array('class'=>'span2','maxlength'=>255)); ?>
	</div>
	<div class='span3'>
			<?php echo $form->textFieldRow($model,'cp',array('class'=>'span1','maxlength'=>255)); ?>

			<?php echo $form->textFieldRow($model,'interes',array('class'=>'span1')); ?>

			<?php echo $form->textFieldRow($model,'interesDiaDesde',array('class'=>'span1')); ?>

			<?php echo $form->datepickerRow($model,'fechaInicio',array('options'=>array(),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'')); ?>

			<?php echo $form->select2Row($model,'idTalonario',array('data'=>CHtml::listData(Talonarios::model()->findAll(), 'id', 'nombreTalonario')),array('class'=>'span5')); ?>

			<?php echo $form->textFieldRow($model,'importeFondoReserva',array('class'=>'span2')); ?>

		</div>
</div>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'htmlOptions'=>array('data-loading-text'=>'Cargando...'),
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Aceptar' : 'Guardar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
