<div class='row'>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'propiedades-form',
    'focus'=>array($model,'nombrePropiedad'),
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son requeridos</p>
<?php echo $form->errorSummary($model); ?>
<?php
$this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type' => 'tabs', // 'tabs' or 'pills'
        'tabs' => array(
            array('label' => 'General','active'=>true, 'content' => $this->renderPartial('_datosGral',array('form'=>$form,'model'=>$model),true)),
            array('label' => 'Otros Datos', 'content' => $this->renderPartial('_otrosDatos',array('form'=>$form,'model'=>$model),true)),
             array('label' => 'Imagenes', 'content' => $this->renderPartial('_imagenes',array('form'=>$form,'model'=>$model),true)),
             )
        )
    );
    

?>

    
</div>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
            'htmlOptions'=>array('data-loading-text'=>'Cargando...'),
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Aceptar' : 'Guardar',
		));
         ?>
</div>

<?php $this->endWidget(); ?>
