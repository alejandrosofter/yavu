<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombreServicio')); ?>:</b>
	<?php echo CHtml::encode($data->nombreServicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peridiocidad')); ?>:</b>
	<?php echo CHtml::encode($data->peridiocidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('importeServicio')); ?>:</b>
	<?php echo CHtml::encode($data->importeServicio); ?>
	<br />


</div>