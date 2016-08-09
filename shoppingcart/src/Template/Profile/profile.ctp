
<div class="row">
    <div class="col-lg-5">
        <h4>Thong tin ca nhan cua <?php echo $user['getFirstNameOrUsername']; ?></h4>
        <div class="media">
                <?php 
                echo $this->Html->link(
                        $this->Html->image($user['getAvatar'],array('alt'=>'','class'=>'media-object')),
                                array(
                                    'controller' => 'Profile',
                                    'action' => 'Profile',
                                    'username' => $user['username']
                                ),array(
                                    'class' => 'pull-left',
                                    'escape' =>FALSE
                                )
                                );
                        
                ?>

            <div class="media-body">
                <h4 class="media-heading">
                        <?php echo $this->Html->link(__($user['getNameOrUsername']),array('controller'=>'Profile','action'=>'Profile','username'=> $user['username']));?>                    
                </h4>
                <?php echo $user['location'];?>                 
            </div>
        </div>

    </div>
    
    <div class="col-lg-4 col-lg-offset-3">
        <?php if(count($checkPending)):?>
        
        <p>Waiting for <?php echo $user['getNameOrUsername']?> to accept</p>
        <?php elseif(count($checkReceive)) :?>
        <?php echo $this->Html->link(__('Accept friend request'),array('controller' => 'Friends', 'action' => 'AcceptFriendRequest','username' => $user['username']),array('class' => 'btn btn-primary'))?>
        <?php elseif(count($isFriends)):?>
        <p> You and <b><?php echo $user['getNameOrUsername']?></b> are friends </p>
        <?php elseif($this->request->session()->read('id') !== $user['id']):?>
        <?php echo $this->Html->link(__('Add as friends'),array('controller' => 'Friends','action' => 'AddFriend','username' => $user['username']),array('class' => 'btn btn-primary'))?>
        <?php endif;?>
        <h4>Ban be hien tai cua <?php echo $user['getFirstNameOrUsername'] ?></h4>
        <?php if(empty($friendsOfUser)):?>
        <p> <b><?php echo $user['getFirstNameOrUsername'] ?> </b> không có bạn bè nào </p>
        <?php else:?>
        <?php foreach($friendsOfUser as $key=>$value): ?>
            <div class="media">
                <?php 
                echo $this->Html->link(
                        $this->Html->image($value->getAvatar,array('alt'=>'','class'=>'media-object')),
                                array(
                                    'controller' => 'Profile',
                                    'action' => 'Profile',
                                    'username' => $value->username
                                ),array(
                                    'class' => 'pull-left',
                                    'escape' =>FALSE
                                )
                                );
                        
                ?>

            <div class="media-body">
                <h4 class="media-heading">
                        <?php echo $this->Html->link(__($value->getNameOrUsername),array('controller'=>'Profile','action'=>'Profile','username'=> $value->username ))?>                    
                </h4>
                <?php echo $value->location;?>                 
            </div>
        </div>
        <?php endforeach;?>
        <?php endif;?>
        
        
    </div>
</div>