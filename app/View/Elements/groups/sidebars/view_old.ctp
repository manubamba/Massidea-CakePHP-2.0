<h2><?php echo $group['Group']['name']?></h2>
<div><?php echo __('Founded') . ': ';
	$date_created = new DateTime($group['Group']['created']);
	echo date_format($date_created, 'j F, Y');	
?></div>
<div id="group_lead">
	<p>
	<?php echo $group['Group']['lead']?>
	</p>
</div>
<div id="administrators_div">
	<h3 class="margin-top"><?php echo __('Administrators')?></h3>	
	<ul id="administrators_list">
		<?php foreach($group['GroupsUser']['User'] as $user):?>
			<li>
			 <?php 	echo $this->Html->link($user['username'], array(
	                'controller' => 'User',
	                'action' => 'view',  $user['id']  
	           	 	));
            ?> 
	      	</li> 
		<?php endforeach; ?>
	</ul>
</div>
<?php if(!empty($group['GroupsUser']['User'])):?>
<div id="members_div">
	<h3 class="margin-top"><?php echo __('Members')?></h3>	
	<ul id="members_list">
		<?php foreach($group['GroupsUser']['User'] as $user):?>
			<li>
			 <?php 	echo $this->Html->link($user['username'], array(
	                'controller' => 'Users',
	                'action' => 'view',  $user['id']  
	           	 	));
            ?> 
	      	</li> 
			<?php endforeach; ?>
	</ul>
</div>
<?php endif;?>
<?php if(!empty($group['LinkedGroups'])):?>
<div id="linked_groups_div">
	<h3 class="margin-top"><?php echo __('Linked Groups')?></h3>	
	<ul id="linked_groups_list">
		<?php foreach($group['LinkedGroups'] as $group):?>
			<li>
			 <?php 	echo $this->Html->link($group['name'], array(
	                'controller' => 'Groups',
	                'action' => 'view',  $group['id']  
	           	 	));
            ?> 
	      	</li> 
			<?php endforeach; ?>
	</ul>
</div>
<?php endif;?>
<div id="linked-addnewlink-link" class="right">
<a href="#">>Link Groups</a>
</div>
