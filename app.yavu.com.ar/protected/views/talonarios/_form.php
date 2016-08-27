<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'talonarios-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>

<?php echo $form->errorSummary($model); ?>
	<div class='span3'>

			<?php echo $form->textFieldRow($model,'nombreTalonario',array('class'=>'span3','maxlength'=>255)); ?>



			
	</div>
	<div class='span3'>

			<?php echo $form->textFieldRow($model,'proximo',array('class'=>'span2')); ?>

			<?php echo $form->listBoxRow($model,'idTipoTalonario',CHtml::listData(TalonariosTipos::model()->findAll(), 'id', 'nombreTipoTalonario'),array('class'=>'span3','style'=>'height:150px')); ?>


			
	</div>
	<div class='span3'>

<?php echo $form->checkBoxRow($model,'esPedeterminado',array('class'=>'span5')); ?>

			

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
