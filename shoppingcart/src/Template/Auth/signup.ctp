<h3>Sign Up</h3>
<div class="row">
    <div class="col-lg-6">
        <br>
        <br>
        <br><br><br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br><br><br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        
        
        
        
        
        <?php echo $this->Form->create('users', array('class' => 'form-vertical', 
            'inputDefaults' => array(
                'error' => false
            )
            ));             
        ?>
        
        <?php echo $this->Form->input('email', array(              
            'label' => array('text' => 'Your email address', 'class' => 'control-label'),
            'class' => 'form-control',
            'div' => array('class' => 'form-group '.($this->Form->isFieldError('email') ? 'has-error' : '')),
            'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-block'))));   
        
        ?>
        <?php
        if(isset($errors['email'])){
        ?>
        <div class='form-group has-error'>
            <span class='help-block'><?php foreach($errors['email'] as $key => $value){
                echo $value;
            }?></span>
        </div>
        <?php } ?>
        
        <br>
        <?php echo $this->Form->input('username', array(
                'label' => array('text' => 'Choose a username', 'class' => 'control-label'),
                'class' => 'form-control',
                'div' => array('class' => 'form-group '.($this->Form->isFieldError('username') ? 'has-error' : '')),
                'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-block'))));
        ?>
        <?php
        if(isset($errors['username'])){
        ?>
        <div class='form-group has-error'>
            <span class='help-block'><?php foreach($errors['username'] as $key => $value){
                echo $value;
            }?></span>
        </div>
        <?php } ?>
         <br>          
        <?php echo $this->Form->input('password', array(
                'label' => array('text' => 'Choose a password', 'class' => 'control-label'),
                'class' => 'form-control',
                'div' => array('class' => 'form-group '.($this->Form->isFieldError('password') ? 'has-error' : '')),
                'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-block'))));
       
        ?>   
         <?php
        if(isset($errors['password'])){
        ?>
        <div class='form-group has-error'>
            <span class='help-block'><?php foreach($errors['password'] as $key => $value){
                echo $value;
            }?></span>
        </div>
        <?php } ?>
        <br>
        <?php echo $this->Form->submit('Signup',array(
            'class'=>'btn btn-default',
            'div' => array('class' => 'form-group')))
        ?> 
            
        <?php echo $this->Form->end();?>
    </div>
</div>