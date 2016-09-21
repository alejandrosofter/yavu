<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaHora')); ?>:</b>
	<?php echo CHtml::encode($data->fechaHora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idCliente')); ?>:</b>
	<?php echo CHtml::encode($data->idCliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requerimiento')); ?>:</b>
	<?php echo CHtml::encode($data->requerimiento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idEstado')); ?>:</b>
	<?php echo CHtml::encode($data->idEstado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('esUrgencia')); ?>:</b>
	<?php echo CHtml::encode($data->esUrgencia); ?>
	<br />


</div>