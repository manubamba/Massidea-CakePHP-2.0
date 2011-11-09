<?php echo $this->Html->tag('h2', __('Account activation', true)); ?>

<?php if($message == 'sent'): ?>
<?php echo sprintf(__('A verification mail has been sent to %s.', true), $address); ?><br />
<?php echo __('Check your inbox and follow the instructions.', true); ?>
<?php endif; ?>

<?php if($message == 'invalid'): ?>
<?php echo __('Invalid or expired activation link. Please sign up again.', true); ?>
<?php endif; ?>

<?php if($message == 'activated'): ?>
<?php echo __('Account activated successfully, you may now log in.', true); ?>
<?php endif;?>