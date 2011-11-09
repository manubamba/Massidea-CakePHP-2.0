<?php 

$url_add_challenge = $this->Html->url(array('controller' => 'contents', 'action' => 'add', 'challenge', $contentId));
$url_add_idea = $this->Html->url(array('controller' => 'contents', 'action' => 'add', 'idea', $contentId));
$url_add_vision = $this->Html->url(array('controller' => 'contents', 'action' => 'add', 'vision', $contentId));
?>

<div id="add_new_link">
	<?php echo $this->Form->create('Content', array('url' => array('controller' => 'linked_contents', 'action' => 'contentLinkSearch'),
												'id' => 'ContentsLinkForm', 'class' => 'left')); ?>
	<?php echo $this->Form->hidden('id', array('value' => $contentId)); ?>
	<?php echo $this->Form->input('title',array('label' => 'Search: ')); ?>
	<?php echo $this->Form->end(); ?>
	<div id="add_new_link_buttons" class="right">
		<a href="<?php echo $url_add_vision; ?>" class="margin border-vision " ><?php __('New vision') ?></a>
		<a href="<?php echo $url_add_idea; ?>" class="margin border-idea " ><?php __('New idea') ?></a>
		<a href="<?php echo $url_add_challenge; ?>" class="margin border-challenge " ><?php __('New challenge') ?></a>
	</div>
	<div class="clear"></div>
	<?php echo $this->Form->create('LinkSearchOptions', array('class' => "small-padding-left-right")); ?>
	<?php echo $this->Form->input('challenge',array('type' => 'checkbox', 'label' => 'Challenge', 'div' => '', 'checked' => true)); ?>
	<?php echo $this->Form->input('idea',array('type' => 'checkbox', 'label' => 'Idea', 'div' => '', 'checked' => true)); ?>
	<?php echo $this->Form->input('vision',array('type' => 'checkbox', 'label' => 'Vision', 'div' => '', 'checked' => true)); ?>
	<?php echo $this->Form->end(); ?>
	<div class="add_new_link_list">
		<h2 class="margin"><?php __('Available contents to link') ?></h2>
		<span class="shrinkFontMore bold small-padding-left-right"><?php __('View') ?></span>|<span class="shrinkFontMore bold small-padding-left-right"><?php __('Link content by clicking') ?></span>
		<ul>
			<li><?php echo $this->Html->image('ajax-loader-black.gif'); ?></li>
		</ul>
	</div>
	<div class="clear"></div>
	<div class="box shrinkFont">
        <h4><?php __('What is content linking?') ?></h4>
        <div class="box-content">
            <span><?php __('Combining different contents together boost creativity and increase the likelihood of unexpected findings.
			By linking you can create logical relationships between different contents.
			You can link your own published content to other users or to your own contents.
			One content can be linked to multiple contents.
			If you want, you can remove links later on from your content page.') ?></span>
            <div class="clear"></div>
        </div>
    </div>
</div>