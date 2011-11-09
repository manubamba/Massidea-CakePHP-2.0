<ul>
    <li><?php echo $this->Html->link(
                               $html->image('icon_message_off.png',array('class' => 'middle', 'id'=>'compose_message_link')).
                                            'Compose Message',
                               array('controller'=>'private_messages', 'action'=>'browse'),
                               array('escape' => false)); ?>

        <div class="dot-line-200"> </div>
    </li>

    <li class="margin-top small-padding-top-bottom">
        <div class="hoverLink">
                <?php echo $this->Html->link('Inbox '.'<span class="grey">('.$messages_in_count.') </span>',
                               '#',
                               array('escape' => false)); ?>
        </div>
    </li>
    <li class="margin-top small-padding-top-bottom">
        <div class="hoverLink">
                <?php echo $this->Html->link('Notifications '.'<span class="grey">('.$notifications_count.') </span>',
                               '#',
                               array('escape' => false)); ?>
        </div>
    </li>
    <li class="margin-top small-padding-top-bottom">
        <div class="hoverLink">
                <?php echo $this->Html->link('Sent'.'<span class="grey">('.$messages_out_count.') </span>',
                               'sent',
                               array('escape' => false,'class' => 'sent_box')); ?>
        </div>
    </li>

</ul>
