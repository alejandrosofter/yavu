
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),

	'method'=>'get','htmlOptions'=>array('class'=>'')
)); ?>

<div class="input-append">
	<?php echo $form->textField($model,'buscar',array('class'=>'text','size'=>50,'maxlength'=>255,'placeholder'=>'Buscar por nro o por entidad...')); ?>
		
		<?php echo $form->dropDownList($model,'estado',array('ACTIVA'=>'ACTIVA','INACTIVA'=>'INACTIVA'),array ('style'=>'width:150px')); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Buscar',
		)); ?>
</div>

<?php $this->endWidget(); ?>

<script>

</script>