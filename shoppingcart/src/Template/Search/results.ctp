<h3>Your search for <?php echo $this->request->query('query')?></h3>
<?php if(!count($users)):?>
<p>No results found, sorry.</p>
<?php else:?>

<div class="row">
    <div class="col-lg-12">
        <?php foreach($users as $user): ?>
            
        
            <div class="media">
                <?php 
                echo $this->Html->link(
                        $this->Html->image($user->getAvatar,array('alt'=>'','class'=>'media-object')),
                                array(
                                    'controller' => 'Profile',
                                    'action' => 'Profile',
                                    'username' => $user->username
                                ),array(
                                    'class' => 'pull-left',
                                    'escape' =>FALSE
                                )
                                );
                        
                ?>
                
                <div class="media-body">
                    <h4 class="media-heading">
                        <?php echo $this->Html->link(__($user->getNameOrUsername),array('controller'=>'Profile','action'=>'Profile','username'=> $user->username));?>                    
                    </h4>
                    <?php echo $user->location;?>                  
                </div>
            </div>
        
        <?php endforeach; ?>
    </div>
    <?php endif;?>
</div>