<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombreTipoTalonario')); ?>:</b>
	<?php echo CHtml::encode($data->nombreTipoTalonario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoOperacion')); ?>:</b>
	<?php echo CHtml::encode($data->tipoOperacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('letraTalonario')); ?>:</b>
	<?php echo CHtml::encode($data->letraTalonario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoElectronico')); ?>:</b>
	<?php echo CHtml::encode($data->tipoElectronico); ?>
	<br />


</div>