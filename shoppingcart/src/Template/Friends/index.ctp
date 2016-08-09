
<div class="row">
    <div class="col-lg-6">
        <h4>Ban be hien tai cua <?php echo $this->request->session()->read('getFirstNameorUsername') ?></h4>
        <?php if(empty($friendsOfMine)):?>
        <p><?php echo $this->request->session()->read('getFirstNameorUsername') ?> không có bạn bè nào </p>
        <?php else:?>
        <?php foreach($friendsOfMine as $key=>$value): ?>
            <div class="media">
                <?php 
                echo $this->Html->link(
                        $this->Html->image($value['getAvatar'],array('alt'=>'','class'=>'media-object')),
                                array(
                                    'controller' => 'Profile',
                                    'action' => 'Profile',
                                    'username' => $value['username']
                                ),array(
                                    'class' => 'pull-left',
                                    'escape' =>FALSE
                                )
                                );
                        
                ?>

            <div class="media-body">
                <h4 class="media-heading">
                        <?php echo $this->Html->link(__($value['getNameOrUsername']),array('controller'=>'Profile','action'=>'Profile','username'=> $value['username']));?>                    
                </h4>
                <?php echo $value['location'];?>                 
            </div>
        </div>
        <?php endforeach;?>
        <?php endif;?>
    </div>
    <div class="col-lg-6">
        <h4>Friend requests</h4>
        
        <?php if(!count($checkFriendRequests)):?>
        <p> Bạn không có yêu cầu kết bạn nào! </p>
        <?php else:?>
                <?php foreach($ListFriendRequests as $key => $value):?>
                
        <div class="media">
                <?php 
                echo $this->Html->link(
                        $this->Html->image($value['0']['getAvatar'],array('alt'=>'','class'=>'media-object')),
                                array(
                                    'controller' => 'Profile',
                                    'action' => 'Profile',
                                    'username' => $value['0']['username']
                                ),array(
                                    'class' => 'pull-left',
                                    'escape' =>FALSE
                                )
                                );
                        
                ?>

            <div class="media-body">
                <h4 class="media-heading">
                        <?php echo $this->Html->link(__($value['0']['getNameOrUsername']),array('controller'=>'Profile','action'=>'Profile','username'=> $value['0']['username']));?>                    
                </h4> 
                    <?php echo $value['0']['location'];?>                  
            </div>
        </div>
        
        <?php endforeach;?>

        <?php endif;?>
    </div>
</div>