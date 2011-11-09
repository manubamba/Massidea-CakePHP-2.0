<?php echo $this->Html->tag('h1', __('Massidea.org account verification', true)); ?>
<p><?php echo sprintf(__('Hello, %s', true), $this->Html->tag('strong', $name)); ?></p>
<p>
<?php echo __('Your account registration is almost done.', true); ?><br />
<?php echo __('Please activate your account in the next 24 hours by visiting the following link: ', true); ?>
<?php echo $this->Html->link($this->Html->url($link, true)); ?> 
</p>