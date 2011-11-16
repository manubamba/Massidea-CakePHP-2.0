<h2>
	<?php echo __('Groups'); ?>
	<span class="right">
		<?php echo $this->Html->link( __('> Create new group'), array(
                'controller' => 'Groups',
                'action' => 'add'
			));
			?>	
	</span>
</h2>

<?php foreach($groups as $group): ?>
<div id="groupid_<?php echo $group['Group']['id']; ?>" class="group_row">
	<div class="group">
		<div class="context">
			<h3>
				<strong>
					<a href="<?php echo $this->Html->url(array('controller' => 'Groups', 'action' => 'view', $group['Group']['id'])); ?>">
						<?php echo $group['Group']['name']; ?>
					</a>
				</strong>
			</h3>
			<p><?php echo $group['Group']['lead']; ?></p>
			<strong>
				<p class="grey">
					<?php 
						echo __('Campaigns') . ': ' . $campaignCount[$group['Group']['id']];
						echo " ";
						echo __('Memebers') . ': ' . $memberCount[$group['Group']['id']];
					?>
				</p>
			</strong>
		</div>
	</div>
	<div class="clear"></div>
</div>
<? endforeach; ?>