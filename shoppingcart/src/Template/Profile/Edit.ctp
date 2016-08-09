<h3>Update your profile</h3>
<div class="row">
    <div class="col-lg-6">
        <?php
        echo $this->Form->create('User', array(
            'url' => array('controller' => 'Profile', 'action' => 'Edit',$this->request->session()->read('id')),
            'error' => false
        ));
        ?>
        <div class="row">
            <div class="col-lg-6">
                <?php
                echo $this->Form->input('first_name', array(
                    'label' => array('text' => 'First name', 'class' => 'control-label'),
                    'class' => 'form-control',
                ));
                ?>
                <?php
                if (isset($errors['first_name'])) {
                ?>
                <div class='form-group has-error'>
                    <span class='help-block'><?php
                foreach ($errors['first_name'] as $key => $value) {
                    echo $value;
                }
                ?></span>
                </div>
                <?php } ?>
            </div>
            
            <div class="col-lg-6">
                <?php
                echo $this->Form->input('last_name', array(
                    'label' => array('text' => 'Last name', 'class' => 'control-label'),
                    'class' => 'form-control',
                ));
                ?>
                <?php
                    if (isset($errors['last_name'])) {
                        ?>
                <div class='form-group has-error'>
                    <span class='help-block'><?php
                        foreach ($errors['last_name'] as $key => $value) {
                            echo $value;
                        }
                        ?></span>
                </div>
        <?php } ?>
            </div>
                    
        </div>

        <?php
        echo $this->Form->input('location', array(
            'label' => array('text' => 'Location', 'class' => 'control-label'),
            'class' => 'form-control',
        ));
        ?>
        <br>
<?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $this->request->session()->read('id'))); ?>
<?php
echo $this->Form->submit('Update', array(
    'class' => 'btn btn-default',
    'div' => array('class' => 'form-group')))
?> 
<?php echo $this->Form->end(); ?>


    </div>
</div>