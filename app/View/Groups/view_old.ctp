<?php 
echo $this->element('groups'.DS.'add_new_link_to_group', array('cache' => false));
?>
<div id="group_page_head">
	<div id="groups_body" class="margin-top">
 		<?php echo $group['Group']['body']; ?>
	</div>
	<?php if(!empty($group['Link'])):?>
	<div id="group_weblinks">
		<ul>	
			<?php foreach($group['Link'] as $weblink):?>
			<li><?php echo $weblink['name']?></li>
			<?php endforeach;?>
		</ul>
	</div>
	<?php endif;?>
	<div class="clear"> </div>
	<div id="group-campaigns" class="left grey margin-top">
                <h3>Campaigns</h3>
                <p>Group's call of contents</p>
    </div>
    <div id="join-group" class="right grey margin-top">
	    <?php if($this->Session->read('Auth.User')): ?>	    
	    <h4 class="right">
	    <?php echo $this->Html->link('> Join this Group', array(
	                'controller' => 'Groups',
	                'action' => 'join', $group['Group']['id'] 
	            ));
       	?>  
	    </h4>
	    <div class="clear"> </div>
	    <p>Only by joining you can add contents to campaigns</p>
    
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
	<div class="clear"> </div>
	<div id="campaigns_div">
		<ul><?php if(!empty($active_campaigns)):?>
			<li><a href="#active_tab"><?php echo __('Active')?></a></li>
			<?php endif;?>
			<?php if(!empty($forthcoming_campaigns)):?>
			<li><a href="#forthcoming_tab"><?php echo __('Forthcoming')?></a></li>
			<?php endif;?>
			<?php if(!empty($ended_campaigns)):?>
			<li><a href="#ended_tab"><?php echo __('Ended')?></a></li>
			<?php endif;?>
		</ul>
		<?php if(!empty($active_campaigns)):?>
		<div id="active_tab">
			<?php foreach ($active_campaigns as $campaign):?>
			<div>
		        <p class="campaign_list_paragraph">
		            <strong>
		            <?php echo $this->Html->link($campaign['name'], array(
		                'controller' => 'Campaigns',
		                'action' => 'view',  $campaign['id']  
		            ));
		            ?>            
		            </strong>
		        </p>
		        <p>        
		        	<?php echo $campaign['lead']?>
		        </p>
		        <span class="left">
		            <strong>Ending:</strong>
		            <?php echo $campaign['end_time']?>
		       	</span>
		        <span class="right">
		            <!--
		            <strong>Posts:</strong>
		            1,000,000
		            -->
		            <!-- Tähän kampanjaan liittyvien sisältöjen määrä -->
		        </span>
		        <div class="clear"></div>
		    </div>
			<?php endforeach;?>
		</div>
		<?php endif; ?>
		<?php if(!empty($forthcoming_campaigns)):?>
		<div id="forthcoming_tab">
		<?php foreach ($forthcoming_campaigns as $campaign):?>
			<div>
		        <p class="campaign_list_paragraph">
		            <strong>
		            <?php echo $this->Html->link($campaign['name'], array(
		                'controller' => 'Campaigns',
		                'action' => 'view',  $campaign['id']  
		            ));
		            ?>            
		            </strong>
		        </p>
		        <p>        
		        	<?php echo $campaign['lead']?>
		        </p>
		        <span class="left">
		            <strong>Starting:</strong>
		            <?php echo $campaign['start_time']?>
		            <strong>Ending:</strong>
		            <?php echo $campaign['end_time']?>
		       	</span>
		        <span class="right">
		            <!--
		            <strong>Posts:</strong>
		            1,000,000
		            -->
		            <!-- Tähän kampanjaan liittyvien sisältöjen määrä -->
		        </span>
		        <div class="clear"></div>
		    </div>
			<?php endforeach;?>
		</div>
		<?php endif;?>
		<?php if(!empty($ended_campaigns)):?>
		<div id="ended_tab">
		<?php foreach ($ended_campaigns as $campaign):?>
			<div>
		        <p class="campaign_list_paragraph">
		            <strong>
		            <?php echo $this->Html->link($campaign['name'], array(
		                'controller' => 'Campaigns',
		                'action' => 'view',  $campaign['id']  
		            ));
		            ?>            
		            </strong>
		        </p>
		        <p>        
		        	<?php echo $campaign['lead']?>
		        </p>
		        <span class="left">
		            <strong>Ended:</strong>
		            <?php echo $campaign['end_time']?>
		       	</span>
		        <span class="right">
		            <!--
		            <strong>Posts:</strong>
		            1,000,000
		            -->
		            <!-- Tähän kampanjaan liittyvien sisältöjen määrä -->
		        </span>
		        <div class="clear"></div>
		    </div>
			<?php endforeach;?>
		</div>
		<?php endif;?>
	</div>
</div>
<div class="clear"></div>
