<?php 
$tabMenu = array(
	'Posts' => '#tabs-1',
	'Views' => '#tabs-2',
	'Favourites' => '#tabs-3',
	'Groups' => '#tabs-4',
	'Readers' => '#tabs-5',
);
?>

<div id="user-view-leftside" >
	<div id="profileimage">
		<?php echo $this->Html->image('/img/no_profile_img_placeholder.png'); ?>
	</div>
	<div id="metadata">
		<span class="data-label">Joined</span>
		<span class="data-value"><?php echo $this->Time->timeAgoInWords($joinedDate); ?></span>
		<span class="data-label">Last logged in</span>
		<span class="data-value"><?php echo $this->Time->timeAgoInWords($loggedDate); ?></span>
	</div>
</div>
<div id="user-view-rightside">
	<h2><?php echo $username;?></h2>
	<div id="profiledata">
		<?php foreach($profileData as $child => $array): ?>
		<span class="data-label"><?php echo ucfirst($array['key']); ?></span>
		<span class="data-value"><?php echo ucfirst($array['value']); ?></span>
		<?php endforeach; ?>
	</div>
</div>
<?php if($owner): ?>
<div id="user-view-editaccount">
	<?php echo $this->Html->link(__('Edit account', true), '/users/edit/'); ?>
</div>
<?php endif;?>
<div class="clear"></div>
<div id="user-view-activity">
	<div id="activityMenu">
		<ul>
			<?php foreach($tabMenu as $text => $id): ?>
			<li><?php echo $this->Html->link($text, $id); ?></li>
			<?php endforeach;?>
		</ul>
	</div>
	<div id="activityContent">
		<?php 
			$i = 1;
			foreach($tabMenu as $text => $id) {
				echo $this->Html->div('', 'test', array(
					'id' => 'tab-'.$i,
					'style' => ($i>1 ? 'display: none;' : '')
				));
				$i++; 
			}
		?>
	</div>
</div>

<?php
?>