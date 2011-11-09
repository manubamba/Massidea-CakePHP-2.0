<br />
<br />
<ul>
	<li id="compose_message_link"><?php echo $this->Html->link(
	$this->Html->image('icon_message_off.png',array('class' => 'middle')).
                                            'Compose Message',
											'#',
											array('escape' => false)); ?>

		<div class="dot-line-200"></div></li>
</ul>
<div class="boxLinks">
<ul >
	<li class="margin-top small-padding-top-bottom">
		<div class="hoverLink">
			
		<?php echo $this->Html->link('Inbox '.'<span class="grey messages_in_count">('.$messages_in_count.') </span>',
                               '#',
		array('escape' => false, 'class' => 'inbox_link')); ?>
		</div></li>
	<li class="margin-top small-padding-top-bottom">
		<div class="hoverLink">
			
		<?php echo $this->Html->link('Sent'
// 				 .'<span class="grey messages_out_count">('.$messages_out_count.') </span>'
				 ,'#', 
				array('escape' => false, 'class' => 'sentbox_link')); ?>
		</div></li>
	<li class="margin-top small-padding-top-bottom">
		<div class="hoverLink">
			
		<?php echo $this->Html->link('My Notes'
// 				.'<span class="grey messages_myNotes_count">('.$messages_myNotes_count.') </span>'
				,'#', 
		array('escape' => false, 'class' => 'myNotes_link')); ?>
		</div></li>

</ul>

<div class="dot-line-200 margin-top"></div>
<h3 class="grey left small-padding-top-bottom noBackground nomargin"><?php __('Tags') ?></h3>
<a href="#" id="linked-addnewlink-link" class="hoverLink right small-padding-top-bottom tagCreate">
 		<?php // echo $html->image('icon_plus_tiny.png',array('class' => 'icon')); ?>
		<?php __('Create Tag') ?>
</a>
<div class="clear"></div>
<div id="tags-container" class="margin-top">
	<ul>
		<?php foreach ($allTags as $tag): ?>
		<li class="small-margin-top-bottom block hover border-tag" style="border-color:<?php echo $tag['PrivateMessageTag']['color'] ?>">
		<?php echo $this->Html->link(
			$tag['PrivateMessageTag']['name'],
			'#',
			array(
				'escape' => false,
				'class' => 'wide inline-block tagOpener_link'
											
		));			
		 ?> 
		 <?php echo $this->Html->link(
				$html->image('icon_link.png',array('class' => 'hoverDarker icon right small-padding-left-right ')).
                                            null,
											'#',
											array('escape' => false,
		 										  'class' => 'tagAddLink inline-block',
		 ));
		 ?>	
		 <input type="hidden" value="<?php echo $tag['PrivateMessageTag']['id'] ?>" class="tagId" />	
		 	<div class="hidden clear tag-options">		 	
		<?php echo $this->Html->link(
				$html->image('icon_edit.png',array('class' => 'inline hoverDarker icon small-padding-left-right')).
                                            null,
											'#',
											array('escape' => false,
		 										  'class' => 'tagEditLink'));
		 ?>	
		 <?php echo $this->Html->link(
				$html->image('icon_red_cross.png',array('class' => 'inline hoverDarker icon small-padding-left-right')).
                                            null,
											'#',
											array('escape' => false,
		 										  'class' => 'tagDeleteLink'));
		 ?>
		 		
		
		 	</div>	
		</li>
		
		<?php endforeach; ?>
	</ul>
</div>
</div>
