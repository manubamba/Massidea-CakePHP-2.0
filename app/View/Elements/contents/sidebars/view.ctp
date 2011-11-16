<!-- AddThis Button BEGIN -->
<a href="http://www.addthis.com/bookmark.php?v=250&amp;pub=xa-4b12c6f671039279" class="addthis_button_expanded small-padding-left-right" title="View more services">
	<img class="icon" height="16" width="125" style="border: 0pt none;" alt="Bookmark and Share" src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif">
</a>
<script src="http://s7.addthis.com/js/250/addthis_widget.js#pub=xa-4b12c6f671039279" type="text/javascript"></script>
<!-- AddThis Button END -->
<p>
<?php echo __('Language') ?>: <?php echo $language['name']; ?>
<br/>
<?php echo __('Content views') ?>: 3452
<br/>
<?php echo __('Content votes') ?>: 143
</p>
<?php if($this->Session->read('Auth.User')): ?>
<ul>
	<li>
		<a href="#" id="content_vote_up" class="hoverLink">
		<?php echo __('Like') ?>
		<?php echo $this->Html->image('icon_thumb_up.png',array('class' => 'icon')); ?>
		</a>
		<span class="big-padding-left-right bold green">64%</span>
		<a href="#" id="content_vote_down" class="hoverLink">
		<?php echo $this->Html->image('icon_thumb_down.png',array('class' => 'icon')); ?>
		<?php echo __('Dislike') ?>
		</a>
	</li>
	
	<li class="margin-top small-padding-top-bottom">
		<div class="hoverLink">
			<a href="#" id="add_to_favourites_link" class="blockLink">
			<?php echo $this->Html->image('icon_fav_off.png',array('class' => 'icon size16')); ?>
			<?php echo __('Add content to favourites') ?>
			</a>
		</div>
	</li>
	
	<li class="small-padding-top-bottom">
		<a href="#" id="give_gift_link" class="hoverLink blockLink">
		<?php echo $this->Html->image('cake.icon.png',array('class' => 'icon size16')); ?>
		<?php echo __('Give gift to content') ?>
		</a>
	</li>
	
	<li class="send-message blockLink small-padding-top-bottom">
		<input type="hidden" value="<?php echo $contentUserId ?>" class="send-message-id" />
		<input type="hidden" value="<?php echo $contentUsername ?>" class="send-message-name" />
		<a href="#" class="hoverLink blockLink">
		<?php echo $this->Html->image('icon_message_off.png',array('class' => 'icon size16')); ?>
		<?php echo __('Send private message') ?>
		</a>
	</li>
	
	<li class="flag-page small-padding-top-bottom">
		<a href="#" class="hoverLink blockLink">
		<?php echo $this->Html->image('icon_flag.png',array('class' => 'icon')); ?>
		<?php echo __('Flag as inappropriate') ?></a>
	</li>

	<?php if($isOwner): ?>
	<li class="small-padding-top-bottom">
		<a href="<?php echo $this->Html->url(array('action' => 'edit',$content['id'])); ?>" class="hoverLink blockLink">
		<?php echo $this->Html->image('icon_edit.png',array('class' => 'icon')); ?>
		<?php echo __('Edit content') ?>
		</a>
	</li>
	<?php endif; ?>

</ul>
<?php endif; ?>

<?php 
$expandIcons = array('block' => 'icon_minus_tiny.png',
					'none' => 'icon_plus_tiny.png');
 ?>

<div id="linked-container" class="margin-top" >

	<h3 class="grey left small-padding-top-bottom pointerCursor noBackground nomargin">
	<?php echo $this->Html->image($expandIcons[$cookies['linked']],array('class' => 'icon')); ?>
	<?php echo __('Linked') ?> (<span><?php echo $linkedContentsCount; ?></span>)
	</h3>
	
	<?php if($this->Session->read('Auth.User')): ?>
	<a href="#" id="linked-addnewlink-link" class="hoverLink right small-padding-top-bottom ">
		<?php echo $this->Html->image('icon_link.png',array('class' => 'icon')); ?>
		<?php echo __('Add link') ?>
	</a>
	<?php endif; ?>
	
	<div class="clear dot-line-720"></div>
	<ul style="display: <?php echo $cookies['linked']; ?>">
	
	<?php if(!empty($linkedContents) && $linkedContentsCount > 0): foreach($linkedContents as $content): ?>
		<li class="border-<?php echo $content['class']; ?> small-margin-top-bottom">
			<a href="#" class="bold"><?php echo (empty($content['User']['username'])) ? 'Anonymous' : $content['User']['username']; ?>: </a>
			
			<?php echo ($isOwner) ? $this->Html->image('icon_red_cross.png',array('class' => 'size16 right pointerCursor', 'id' => "delete_linked_content-".$content['id'])) : null; ?>
			
			<a href="<?php echo $this->Html->url(array('action' => 'view',$content['id'])); ?>" class="hoverLink blockLink"><?php echo $content['title']; ?></a>
		</li>
	<?php endforeach; endif;?>
	
	</ul>
	
</div>

