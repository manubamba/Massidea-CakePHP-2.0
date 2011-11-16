<?php 
echo $this->Html->script('datatables'.DS.'jquery.dataTables.min',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'datatables_custom',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'tabletools'.DS.'js'.DS.'TableTools.min',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'tabletools'.DS.'js'.DS.'ZeroClipboard',array('inline'=>false));
echo $this->Html->css(array(
	'..'.DS.'js'.DS.'datatables'.DS.'tabletools'.DS.'css'.DS.'TableTools_JUI',
	'..'.DS.'js'.DS.'farbtastic'.DS.'farbtastic' ),'stylesheet', array('inline' => false ) );
 ?>

<h2>
<?php echo $group['Group']['name']?></h2>
<div>

<?php echo __('Founded') . ': ';
$date_created = new DateTime($group['Group']['created']);
echo date_format($date_created, 'j F, Y');
?></div>
<div id="administrators_div">
	<h3 class="margin-top">

	<?php echo __('Administrators') . "($admin_count)" ?>
	<a href="#"><span class="right"><?php echo __('See all'); ?> </span></a>
	</h3>
	<ul id="administrators_list">


	<?php foreach($administrators as $admin):?>
		<li>
		<?php 	echo $this->Html->link($admin['User']['username'], array(
	                'controller' => 'Users',
	                'action' => 'view',  $admin['User']['username']  
		));
		?>
		</li>		 
		<?php endforeach; ?>
	</ul>
	<p> </p>
</div>
<div id="profile-meta">
	<ul id="group-menu">
		<li id="home_link">
		<?php echo $this->Html->link( __('Home'), array(
	                'controller' => 'Groups',
	                'action' => 'view', $group['Group']['id']
		));
		?>
		</li>
		<li id="members_link">
		<?php echo $this->Html->link( __('Members'), array(
	                'controller' => 'Groups',
	                'action' => 'members', $group['Group']['id']
		));
		?>
		</li><li id="campaigns_link">
		<?php echo $this->Html->link( __('Campaigns'), array(
	                'controller' => 'Groups',
	                'action' => 'campaigns', $group['Group']['id']
		));
		?>
		</li><li id="linked_link">
		<?php echo $this->Html->link( __('Linked Groups'), array(
	                'controller' => 'Groups',
	                'action' => 'linkedGroups', $group['Group']['id']
		));
		?>
		</li><li id="feeds_link">
		<?php echo $this->Html->link( __('Feeds'), array(
	                'controller' => 'Groups',
	                'action' => 'feeds', $group['Group']['id']
		));
		?>
		</li>
			
	</ul>
</div>
