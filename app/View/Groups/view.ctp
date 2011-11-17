<?php 
echo $this->Html->script('datatables'.DS.'jquery.dataTables.min',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'datatables_custom',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'tabletools'.DS.'js'.DS.'TableTools.min',array('inline'=>false));
echo $this->Html->script('datatables'.DS.'tabletools'.DS.'js'.DS.'ZeroClipboard',array('inline'=>false));
echo $this->Html->css(array(
	'..'.DS.'js'.DS.'datatables'.DS.'tabletools'.DS.'css'.DS.'TableTools_JUI',
	'datatables'.DS.'datatables'
		),'stylesheet', array('inline' => false ) );
?>
<div id="group-page">
	<div id="group-header">
		<div id="join-group" class="right grey margin-top">
			
		<?php if($this->Session->read('Auth.User')): ?>
			<h4 class="right">
			<?php if($userRole == 'Admin') : ?>

			<?php echo $this->Html->link('Edit Group', array(
	                'controller' => 'Groups',
	                'action' => 'edit', $group['Group']['id'] 
			)) . ' |';
			?>

			<?php echo $this->Html->link('Delete Group', array(
	                'controller' => 'Groups',
	                'action' => 'delete', $group['Group']['id'] 
			));
			?>	

			<?php echo   '| ' . $this->Html->link('Waiting List', array(
	                'controller' => 'Groups',
	                'action' => 'waitingList', $group['Group']['id'] 
			));
			?>	
			
			<?php elseif($userRole == 'Member') : ?>
			
			<?php echo $this->Html->link('> Leave this Group', array(
	                'controller' => 'Groups',
	                'action' => 'unjoin', $group['Group']['id'] 
			));
			?>
			<?php else: ?>
			<?php echo $this->Html->link('> Join this Group', array(
	                'controller' => 'Groups',
	                'action' => 'join', $group['Group']['id'] 
			));
			?>
			<p>Only by joining you can add contents to campaigns</p>
			<?php endif; ?>
			</h4>
			<div class="clear"></div>
			
			
			
    
    	<?php else: ?>
   		<div id="group-not-logged">
			<?php echo $this->Html->link('Login', array(
                'controller' => 'Users',
                'action' => 'login' 
            ));
            ?>  
             or
              <?php echo $this->Html->link('Sign up' , array(
                'controller' => 'Users',
                'action' => 'signup'
            ));
            ?>   to join this group.
		</div>
		<p>Only by joining you can add contents to campaigns</p>
		<?php endif; ?>
	</div>
	</div>
	<div class="clear"></div>
	<div id="group_home_info">
		<h3>
		<?php echo $this->Html->link(__('Info'), '#');
		?>
		</h3>
		<p>
		<?php echo $group['Group']['lead']?>
		</p>
	</div>
	<div id="group_home_body">
	<h3>
	<?php echo $this->Html->link(__('Description'), '#');
	?>
			</h3>
			<p>
			<?php echo $group['Group']['body']?>
			</p>
		</div>
	<?php if($campaign_count):?>
	<div id="group_home_campaigns">
		<h3>
			 <?php  echo __('Latest') . ' ' . $this->Html->link(
			 		__('campaigns') . " ($campaign_count)", array(
		                'controller' => 'Campaigns',
		                'action' => 'view', $group['Group']['id']
		)) ;
		?>
		</h3>	
		<ul>
		<?php foreach ($group['Campaign'] as $campaign): ?>
			<li>
			<?php echo $this->Html->link( $campaign['name'], array(
	                'controller' => 'Campaigns',
	                'action' => 'view',  $campaign['id']
			));
			?>
			</li>
		<?php endforeach;?>
		</ul>	
	</div>

<?php endif;?>
	<?php if($linked_group_count):?>
	<div id="group-home-linkedgroups">
		<h3>
			 <?php echo __('Latest') . ' ' . $this->Html->link(
			 		__('linked groups') . " ($linked_group_count)", array(
		                'controller' => 'Groups',
		                'action' => 'linkedGroups' 
		));
		?></a>
		</h3>
		<ul>
		<?php foreach ($group['LinkedGroups'] as $linkedGroup): ?>
			<li>
			<?php echo $this->Html->link( $linkedGroup['name'], array(
	                'controller' => 'Groups',
	                'action' => 'view',  $linkedGroup['id']
			));
			?>
			</li>
		<?php endforeach;?>
		</ul>	
	</div>
	<?php endif;?>

</div>
<div class="clear"></div>
<?php 
echo $this->element('groups'.DS.'linked_groups', array('cache' => false));
echo $this->element('groups'.DS.'campaigns', array('cache' => false));
echo $this->element('groups'.DS.'members', array('cache' => false));
echo $this->element('groups'.DS.'admins', array('cache' => false));
?>
