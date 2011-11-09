<?php 
// echo $this->Html->script('infinitecarousel'.DS.'jquery.infinitecarousel2.min',array('inline' => false));
echo $this->Html->script(strtolower($this->name).DS.$this->action,array('inline' => false));
echo $this->element('global'.DS.'private_message', array('cache' => false)); 
echo $this->element('global'.DS.'flag', array('cache' => false));
echo $this->element('contents'.DS.'add_new_link_to_content', array('cache' => false));
?>


<div id="content-page-head" class="left">
	<div class="border-<?php echo $content['class']; ?> margin-top">
		<h2><?php echo $content['title']; ?></h2>
		<span class="grey"><?php echo __('Published') ?>: <?php echo $content['created']; ?>,
						 <?php echo __('Last updated') ?>: <?php echo $content['modified']; ?>
		 </span>
		<p class="italic magnifyFont"><?php echo $content['lead']; ?></p>
	</div>
	<p>
		<a href="#" class="bold"><?php echo __('Tags') ?>: </a>
		<?php $tagSize = sizeof($tags); foreach($tags as $k => $tag): ?>
			<a href="#" class="<?php echo ($k % 2) ? "blue" : "deepblue"; ?>"><?php echo $tag['name']; ?></a><?php if($tagSize != $k+1):?>, <?php endif; ?>
		<?php endforeach; ?>
	</p>
	<?php 
		$companySize = sizeof($relatedCompanies);
		if($companySize > 0):
	?>
	<p>
		<a href="#" class="bold"><?php echo __('Related Companies') ?>: </a>
		<?php foreach($relatedCompanies as $k => $company): ?>
			<a href="#" class="<?php echo ($k % 2) ? "blue" : "deepblue"; ?>"><?php echo $company['name']; ?></a><?php if($companySize != $k+1):?>, <?php endif; ?>
		<?php endforeach;?>
	</p>
	<?php endif; ?>

	<div class="clear"></div>
	<div id="content-page-context">
			
		<?php if($content['body'] != ''): ?>
		<p><?php echo nl2br($content['body']); ?></p>
		<?php endif; ?>
		
		<?php foreach($specific as $type => $spec): ?>
			<h3><?php 
			if($type == 'research') { echo __("Research question"); }
			elseif($type == 'solution') { echo __("Idea/Solution in one sentence"); }
			elseif($type == 'opportunity') { echo __("Opportunities"); }
			elseif($type == 'threat') {echo __("Threats"); }
			?>:</h3>
			<p><?php echo $spec; ?></p>
		<?php endforeach; ?>
		
		<h3><?php echo __('References') ?>: </h3>
		<p><?php echo ($content['references'] != '') ? $content['references'] : __('No references'); ?></p>
		
	</div>
</div>

<div class="clear"></div>
	

