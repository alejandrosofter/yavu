<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('razonSocial')); ?>:</b>
	<?php echo CHtml::encode($data->razonSocial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('domicilio')); ?>:</b>
	<?php echo CHtml::encode($data->domicilio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuit')); ?>:</b>
	<?php echo CHtml::encode($data->cuit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idCondicionIva')); ?>:</b>
	<?php echo CHtml::encode($data->idCondicionIva); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombreUsuario')); ?>:</b>
	<?php echo CHtml::encode($data->nombreUsuario); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('claveAcceso')); ?>:</b>
	<?php echo CHtml::encode($data->claveAcceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombreDominio')); ?>:</b>
	<?php echo CHtml::encode($data->nombreDominio); ?>
	<br />

	*/ ?>

</div>