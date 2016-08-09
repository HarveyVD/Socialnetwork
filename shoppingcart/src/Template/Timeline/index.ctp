<div class="row">
    <div class="col-lg-6">
        <?php
        echo $this->Form->create('Status', array(
            'url' => array('controller' => 'Timeline', 'action' => 'postStatus'),
            'type' => 'post',
            'role' => 'form',
            'inputDefaults' => array(
                'error' => false
            )
        ));
        ?>
        <div class="form-group">
            <?php echo $this->Form->input('body', ['placeholder' => "What's up " . $this->request->session()->read('getFirstNameorUsername') . "?", 'type' => 'textarea', 'label' => false, 'escape' => false, 'class' => 'form-control', 'rows' => '2']); ?>
        </div>
        <!--error-->
        <?php
        if (isset($errors['body'])) {
            ?>
            <div class='form-group has-error'>
                <span class='help-block'><?php
        foreach ($errors['body'] as $key => $value) {
            echo $value;
        }
            ?></span>
            </div>
        <?php } ?>

        <?php
        echo $this->Form->submit('Update status', array(
            'class' => 'btn btn-default',
        ))
        ?> 

<?php echo $this->Form->end(); ?>

        <hr>
    </div>
</div>
<div class="row">
    <div class="col-lg-5">
        <?php if (empty($statuses->toArray())): ?>
            <p>There's nothing in your timeline, yet.</p>
        <?php else: ?>
            <?php foreach ($statuses as $status): ?>
            
                <div class="media">
                    <?php
                    echo $this->Html->link(
                        $this->Html->image($status->avatar,array('alt'=>$status->NameorUsername,'class'=>'media-object')),
                                array(
                                    'controller' => 'Profile',
                                    'action' => 'Profile',
                                    'username' => $status->user->username
                                ),array(
                                    'class' => 'pull-left',
                                    'escape' =>FALSE
                                )
                                );
                    ?>
                    
                    <div class="media-body">
                        <h4 class="media-heading">
                            <?php echo $this->Html->link($status->NameorUsername, array('controller' => 'Profile','action' => 'Profile','username' => $status->user->username))?>             
                        </h4>
                        <p><?php echo $status->body?></p>
                        <ul class="list-inline">
                            
                            <li><?php echo $status->Time?></li>
                            <li><a href="#">Like</a></li>
                            <li>10 likes</li>
                        </ul>
                        <?php foreach($status->reply as $reply):?>
                        <div class="media">
                            <?php
                            echo $this->Html->link(
                                $this->Html->image($reply->avatar,array('alt'=>$reply->NameorUsername,'class'=>'media-object')),
                                    array(
                                        'controller' => 'Profile',
                                        'action' => 'Profile',
                                        'username' => $reply->username
                                    ),array(
                                        'class' => 'pull-left',
                                        'escape' =>FALSE
                                    )
                                );
                            ?>
                            <div class="media-body">
                                <h5 class="media-heading"><a href="#"><?php echo $reply->NameOrUsername?></a></h5>
                                <p>Yes, it is lovely!</p>
                                <ul class="list-inline">
                                    <li><?php echo $reply->Time?></li>
                                    <li><a href="#">Like</a></li>
                                    <li>4 likes</li>
                                </ul>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <?php 
                        echo $this->Form->create('Status', array(
                            'url' => array('controller' => 'Timeline', 'action' => 'postReply','statusId' => $status->id),
                            'type' => 'post',
                            'role' => 'form',
                            'inputDefaults' => array(
                                'error' => false
                            )
                        ));
                        ?>
                        <div class="form-group">                      
                            <?php echo $this->Form->textarea("reply-".$status->id,['class'=>'form-control','placeholder'=>'Reply to this status', 'rows' => '2'])?>
                        </div>
                        <?php echo $this->Form->input("Reply",['type'=>'submit','class'=>'btn btn-default btn-sm'])?>                        
                        <?php echo $this->Form->end() ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <p><?= $this->Paginator->counter(); ?></p>
            <div class="pagination pagination-lg">
                <ul class="pagination">
                <?php        
                echo $this->Paginator->prev('< ' . __('previous'));
                echo $this->Paginator->numbers();
                echo $this->Paginator->next(__('next') . ' >');
        ?>
        </ul>
            </div>
        <?php endif; ?>
    </div>
</div>