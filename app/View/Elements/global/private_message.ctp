<?php echo $this->Html->script('elements'.DS.'private_message',array('inline' => false)); ?>

<div id="send_private_message" title="Send private message"	class="hidden">


	<p>
		You have <span id="privateMessageCharacters">1000</span> characters
		left.
	</p>	
	
	<?php echo $this->Form->create('PrivateMessage', array('url' => '#','inputDefaults' => array('div' => true), 'id' => 'PrivateMessageForm')); ?>
	
	<label for="PrivateMessageTo">To</label>
	<p id="PrivateMessageTo"></p>
	
	<?php echo $this->Form->hidden('UserPrivateMessage.receiver_id', array('value' => 0)); ?>
	<?php echo $this->Form->hidden('PrivateMessage.parent_id', array('value' => 0)); ?>
	<?php echo $this->Form->input('title', array('type' => 'text',
											'label' => 'Title')
	); ?>
	<?php echo $this->Form->input('message', array('type' => 'textarea',
											'rows' => 6,
											'cols' => 40,
											'label' => 'Message',
											'div' => array('class' => 'margin-top'))
	); ?>	
	
	<?php echo $this->Form->end(); ?>
</div>
