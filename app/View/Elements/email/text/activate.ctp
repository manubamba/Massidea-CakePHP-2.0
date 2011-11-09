<?php echo sprintf(__('Hello, %s', true), $name); ?>

<?php echo __('Your account registration is almost done.', true) . "\n"; ?>
<?php echo __('Please activate your account in the next 24 hours by visiting the following link: ', true); ?>
<?php echo $this->Html->url($link, true); ?> 