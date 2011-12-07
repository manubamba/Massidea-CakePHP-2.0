

<!-- the tabs "active, fothcoming, ended" files are  seperated from here -->
<h2>
	<?php echo __('Campaigns'); ?>
	

</h2>

<div id="tabs">

	<ul>
		<li><a href=<?php echo $this->Html->url(array('controller' => 'campaigns', 'action' => 'getRecentActive')); ?>>Active</a></li>
		<li><a href=<?php echo $this->Html->url(array('controller' => 'campaigns', 'action' => 'getRecentForthcoming')); ?>>Forthcoming</a></li>
		<li><a href=<?php echo $this->Html->url(array('controller' => 'campaigns', 'action' => 'getRecentEnded')); ?>>Ended</a></li>
	</ul>
	
	
	




</div>