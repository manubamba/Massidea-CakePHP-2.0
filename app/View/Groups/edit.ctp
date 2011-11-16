<?php
echo $this->Html->script(strtolower($this->name).DS.$this->action,array('inline' => false));


?>




<?php echo $this->Form->create('Group', array('type' => 'file',
						 				'url' => array('controller' => 'groups', 'action' => 'edit'),
						 				'inputDefaults' => array('label' => false,
																'div' => false)
));
echo $this->Form->hidden('id');
?>


<div class="clear"></div>

<div id="group_name" class="row">
	<div class="field-label">
		<label for="GroupName"><?php echo __('Name') ?> </label> <small
			class="right"><?php // echo __('(Explaination)') ?>
		</small>
	</div>
	<div class="field">
<?php echo $this->Form->input('name', array('type' => 'textarea',	'rows' => '1' , 'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
		
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>

<div id="group_type" class="row">
	<div class="field-label">
		<label for="GroupLead"><?php echo __('Type') ?> </label> <small
			class="right"><?php // echo __('(Open/closed)') ?>
		</small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('closed', array('type' => 'select',
											 'selected' => "Open",
											 'options' => array('Open', 'Closed'), )); ?></div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>
<div class="clear"></div>

<div id="group_lead" class="row">
	<div class="field-label">
		<label for="GroupLead"><?php echo __('Lead Paragraph') ?> </label> <small
			class="right"><?php // echo 'Explaination'; ?> </small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('lead', array('type' => 'textarea',	'rows' => '6' , 'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">

	<?php echo __('required') ?></div>
</div>





<div id="group_body" class="row">
	<div class="field-label">
		<label for="GroupBody"><?php echo __('Body text') ?> </label> <small
			class="right"><?php // echo 'Explaination' ?> </small>
	</div>
	<div class="field">


	<?php echo $this->Form->input('body', array('type' => 'textarea',	'rows' => '20' , 'error' => array('wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	
<div class="clear"></div>



<?php echo $this->Form->end(array('div' => array('class' => 'row',
											'id' => 'group_send'),
							'value' => 'Send',
							'label' => __('Send',true),
							'after'	=> '</div><div class="clear">'
));
 ?>







