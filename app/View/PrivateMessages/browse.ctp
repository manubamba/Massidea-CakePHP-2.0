<?php 
echo $this->Html->script('datatables'.DS.'jquery.dataTables.min',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'datatables_custom',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'tabletools'.DS.'js'.DS.'TableTools.min',array('inline'=>false));
echo $this->Html->script('farbtastic'.DS.'farbtastic',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'tabletools'.DS.'js'.DS.'ZeroClipboard',array('inline'=>false));
echo $this->element('global'.DS.'private_message', array('cache' => false));
echo $this->element('global'.DS.'private_message_compose', array('cache' => false));
echo $this->element('privatemessages'.DS.'create_tag', array('cache' => false));
echo $this->Html->css(array(
	'..'.DS.'js'.DS.'datatables'.DS.'tabletools'.DS.'css'.DS.'TableTools_JUI',
	'..'.DS.'js'.DS.'farbtastic'.DS.'farbtastic' ),'stylesheet', array('inline' => false ) );
 ?>
<h2 class="title_inbox "><?php __('Inbox') ?></h2>
<h2 class="title_sent hidden"><?php __('Sent Messages') ?></h2>
<h2 class="title_notifications hidden"><?php __('Notofications') ?></h2>
<h2 class="title_conversation hidden"><?php __('Conversation') ?></h2>
<h2 class="title_thread hidden"><?php __('Thread') ?></h2>
<h2 class="title_myNotes hidden"><?php __('My Notes') ?></h2>
<table id="PrivateMessages-table" width="100%" class="fixed-table display">
	<thead>
		<tr>
			
			<th >Id</th>
			<th width="4%" class="checkbox-header"><input type="checkbox"/></th>
			<th width="22%">
				<p class="title_from"><?php __('From') ?></p>
				<p class="title_to hidden"><?php __('To') ?></p>
			</th>
			<th width="55%"><?php __('Title') ?></th>
			<th>Time</th>
			<th width="18%"><?php __('Received') ?></th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
	<tfoot>
	<tr>			
			<th >Id</th>
			<th width="4%" class="checkbox-header"><input type="checkbox"/></th>
			<th width="22%">
				<span class="title_from"><?php __('From') ?></span>
				<span class="title_to hidden"><?php __('To') ?></span>
			</th>
			<th width="55%"><?php __('Title') ?></th>
			<th>Time</th>
			<th width="18%"><?php __('Received') ?></th>
			<th>Message</th>
		</tr>
	</tfoot>
</table>

