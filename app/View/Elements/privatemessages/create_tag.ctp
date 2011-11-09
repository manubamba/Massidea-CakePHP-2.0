<div id="create_message_tag" title="Create new tag"	class="hidden">
	<?php echo $this->Form->create('PrivateMessageTag',
				 array('url' => '#',
				 		'id' => 'PrivateMessageTagsAddForm',
						'inputDefaults' => array('div' => true))); ?>

	<?php echo $this->Form->input('name', array('type' => 'text',
											'label' => 'Title ')
	); ?>
	<div id="colorpicker"></div>
	<?php echo $this->Form->input('color', array('type' => 'text',
											'label' => 'Color ',
											'value' => '#ccc')
	); ?>
	
	<?php echo $this->Form->end(); ?>

		

</div>