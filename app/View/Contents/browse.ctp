<h2>
	<?php echo __('Recent posts'); ?>
	<a href="#">
		<?php echo $this->Html->image('icon_rss_28x28.png',array('alt' => 'RSS', 'class' => 'rsslogo')); ?>
	</a>
	<a href="#">
		<?php echo $this->Html->image('podcasts.png',array('alt' => 'RSS', 'class' => 'rsslogo')); ?>
	</a>
</h2>

<?php foreach($contents as $content): ?>
<div id="postid_<?php echo $content['Content']['id']; ?>" class="user_content_row">
	<div class="user">
		<div class="photo <?php echo $content['Content']['class']; ?>">
			<a href="#"><?php echo $this->Html->image('no_profile_img_placeholder.png'); ?></a>
		</div>
		<div class="context">
			<h3>
				<a class="username" href="#"><?php echo $content['User']['username']; ?> (<?php echo isset($contentCounts[$content['User']['id']]) ? $contentCounts[$content['User']['id']] : 0; ?>)</a>
				<strong><a href="<?php echo $this->Html->url(array('controller' => 'contents', 'action' => 'view', $content['Content']['id'])); ?>"><?php echo $content['Content']['title']; ?></a></strong>
			</h3>
			<p><?php echo $content['Content']['lead']; ?></p>
			<p>
				<a href="#"><?php echo __('Tags') ?>: </a>
				<?php if(isset($content['Child'])): $i=0; foreach($content['Child'] as $child):
						if($child['type'] == 'Tag'): $i++;
				?>
				<a href="#"><span class="<?php echo ($i%2)?'deepblue':'blue'; ?>"><?php echo $child['name']; ?></span></a>
				<?php endif; endforeach; endif; ?>
			</p>
			<p class="translate">
				<span class="summary_translatelink_meta"><?php echo json_encode(array('id' => $content['Content']['id'], 'language_name' => $content['Language']['name'])); ?></span>
				<span class="summary_translatelink_text">[<a onclick="toggleTranslation('<?php echo $content['Content']['id']; ?>'); return false;" href="#"><?php echo __('Show original') ?></a>, <?php echo __('translated from') ?> <?php echo $content['Language']['name']; ?>]</span>
			</p>
		</div>
	</div>
	<div class="clear"></div>
</div>
<? endforeach; ?>