<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clientes-deudas-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span3'>
			<?php echo $form->select2Row($model,'idServicio',array('data'=>CHtml::listData(Servicios::model()->findAll(), 'id', 'nombreServicio'),'htmlOptions'=>array('onchange'=>'cambiaEntidad()'),'options'=>array('placeholder'=>'Seleccione...')),array('class'=>'span5')); ?>

<?php echo $form->select2Row($model,'idCliente',array('data'=>CHtml::listData(Clientes::model()->findAll(), 'id', 'nombreUsuario'),'htmlOptions'=>array('onchange'=>'cambiaEntidad()'),'options'=>array('placeholder'=>'Seleccione...')),array('class'=>'span5')); ?>

			<?php echo $form->datepickerRow($model,'fecha',array('options'=>array('format'=>'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>
<?php echo $form->textFieldRow($model,'importe',array('class'=>'span2')); ?>

			</div>
<div class='span3'>
			

			<?php echo $form->textFieldRow($model,'estado',array('class'=>'span3','maxlength'=>255)); ?>
<?php echo $form->datepickerRow($model,'fechaInicio',array('options'=>array('format'=>'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>

			<?php echo $form->datepickerRow($model,'fechaFin',array('options'=>array('format'=>'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'')); ?>
			
			

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
