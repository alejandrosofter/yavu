<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'liquidaciones-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
<div class='span12'>
	<div class='span3'>
			<?php echo $form->datepickerRow($model,'fecha',array('options' => array('autoclose' => true,'format' => 'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'')); ?>

			<?php echo $form->select2row($model,'idEdificio',array(
				'data'=>CHtml::listData(Edificios::model()->findAll(), 'id', 'nombreEdificio'),
				'options'=>array('placeholder'=>'Seleccione...'),
				'htmlOptions'=>array('onchange'=>'consultarItems()'))
			); 
			?>

			<?php echo $form->textAreaRow($model,'detalle',array('rows'=>5, 'cols'=>0, 'class'=>'span3')); ?>
	</div>
	<div class='span2'>
			<?php echo $form->datepickerRow($model,'fechaVto',array('options' => array('autoclose' => true,'format' => 'yyyy-mm-dd'),'htmlOptions'=>array('class'=>'span2')),array('prepend'=>'')); ?>
			<span class="muted">Es la fecha que comenzara a contar el interes propuesto (en variables de sistema).</span>
			<?php echo $form->textFieldRow($model,'importe',array('class'=>'span2')); ?>

			<?php echo $form->textFieldRow($model,'importeFondoReserva',array('class'=>'span2')); ?>

	
	</div>

<div id='paraLiquidar' class='span6'><i>No se ha seleccionado edificio</i></div>

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
<script>
consultarItems();
function consultarItems()
{
	$.getJSON( "index.php?r=gastos/getParaLiquidar",{idEdificio:$('#Liquidaciones_idEdificio').val()}, function( data ) {
		$("#paraLiquidar").html(data.data);
		});
}
</script>