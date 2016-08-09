

<div class="row">
    <div class="col-lg-5">
        <?php if (empty($user_statuses->toArray())): ?>
            <p>There's nothing in your timeline, yet.</p>
        <?php else: ?>
            <?php foreach ($user_statuses as $user_status): ?>
            
                <div class="media">
                    <?php
                    echo $this->Html->link(
                        $this->Html->image($user_status->avatar,array('alt'=>$user_status->NameorUsername,'class'=>'media-object')),
                                array(
                                    'controller' => 'Profile',
                                    'action' => 'Profile',
                                    'username' => $user_status->user->username
                                ),array(
                                    'class' => 'pull-left',
                                    'escape' =>FALSE
                                )
                                );
                    ?>
                    
                    <div class="media-body">
                        <h4 class="media-heading">
                            <?php echo $this->Html->link($user_status->NameorUsername, array('controller' => 'Profile','action' => 'Profile','username' => $user_status->user->username))?>             
                        </h4>
                        <p><?php echo $user_status->body?></p>
                        <ul class="list-inline">
                            
                            <li><?php echo $user_status->Time?></li>
                            <li><a href="#">Like</a></li>
                            <li>10 likes</li>
                        </ul>

                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" alt="" src="">
                            </a>
                            <div class="media-body">
                                <h5 class="media-heading"><a href="#">Billy</a></h5>
                                <p>Yes, it is lovely!</p>
                                <ul class="list-inline">
                                    <li>8 minutes ago.</li>
                                    <li><a href="#">Like</a></li>
                                    <li>4 likes</li>
                                </ul>
                            </div>
                        </div>

                        <form role="form" action="#" method="post">
                            <div class="form-group">
                                <textarea name="reply-1" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
                            </div>
                            <input type="submit" value="Reply" class="btn btn-default btn-sm">
                        </form>
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