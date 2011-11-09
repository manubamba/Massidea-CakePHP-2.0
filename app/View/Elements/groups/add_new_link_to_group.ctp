
<div id="add_new_link">
	<?php echo $this->Form->create('Group', array('url' => array('controller' => 'linked_groups', 'action' => 'groupLinkSearch'),
												'id' => 'GroupsLinkForm', 'class' => 'left')); ?>
	<?php echo $this->Form->hidden('id', array('value' => $group['Group']['id'])); ?>
	<?php echo $this->Form->input('title',array('label' => 'Search: ')); ?>
	<?php echo $this->Form->end(); ?>
	<div id="add_new_link_buttons" class="right">
		<?php $url_add_group = $this->Html->url(array('controller' => 'groups', 'action' => 'add', $group['Group']['id'])); ?>
		<a href="<?php echo $url_add_group; ?>" class="margin border-group " ><?php echo __('New Group') ?></a>
	</div>
	<div class="clear"></div>
	<?php echo $this->Form->create('LinkSearchOptions', array('class' => "small-padding-left-right")); ?>
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
        <h4><?php __('What is Group linking?') ?></h4>
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