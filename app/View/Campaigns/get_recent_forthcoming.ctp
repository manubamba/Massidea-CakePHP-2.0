
<div id="forthcoming_campaigns">
<?php foreach($forthcomingCampaigns as $campaign): ?>
<div id="campaignid_<?php echo $campaign['Campaign']['id']; ?>" class="campaign_row">
	<div class="campaign">
	
		<div class="context">
			<h3>
				<strong>
					<a href="<?php echo $this->Html->url(array('controller' => 'campaigns', 'action' => 'view', $campaign['Campaign']['id'])); ?>">
						<?php echo $campaign['Campaign']['name']; ?>
					</a>
				</strong>
			</h3>
			<p><?php echo $campaign['Campaign']['lead']; ?></p>
			<p>
			<strong>
				<?php echo __('Forthcoming'); ?>
			</strong>
				<?php echo $campaign['Campaign']['end_time']; ?>
			</p>
			
		</div>
	</div>
	<div class="clear"></div>
</div>
	
<? endforeach; ?>
</div>

