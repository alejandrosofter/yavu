<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'solicitudes-servicio-form',
	'enableAjaxValidation'=>false,
	'focus'=>array($model,"requerimiento")
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span7'>
			<?php $this->widget(
    'bootstrap.widgets.TbDatePicker',
    array(
				'model'=>$model,
        'attribute' => 'fechaHora',
	'options' => array('format' => 'yyyy-mm-dd'),
        'htmlOptions' => array('class'=>'col-md-4'),
    )
); ?>

				<?php echo $form->select2Row($model,'idCliente',array('data'=>CHtml::listData(Entidades::model()->findAll(), 'id', 'razonSocial'),'htmlOptions'=>array('onchange'=>'cambiaEntidad()'),'options'=>array('placeholder'=>'Seleccione...')),array('class'=>'span5')); ?>
	

			<?php echo $form->textAreaRow($model,'requerimiento',array('rows'=>6, 'cols'=>40, 'class'=>'span8')); ?>

			<?php echo $form->select2Row($model,'idEstado',array('data'=>CHtml::listData(SolicitudesServicioNombreEstados::model()->findAll(), 'id', 'nombreEstadoSolicitud')),array('class'=>'span5')); ?>
	
		<br>Urgencia?
			<?php echo $form->checkBox($model,'esUrgencia',array()); ?>

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
	$( window ).load(function() {
		resizeCliente();
	});
	
	function resizeCliente(){
		
		$("#s2id_SolicitudesServicio_idCliente").attr("style", 'width:400px' );
	}

</script>