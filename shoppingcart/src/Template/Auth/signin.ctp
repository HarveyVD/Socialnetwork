<h3>Sign in</h3>
<div class="row">
    <div class="col-lg-6">
            <?php echo $this->Form->create('User', array(
                'url' => array('controller' => 'auth','action'=>'Signin'),
                'class' => 'form-vertical', 
                'inputDefaults'=>array(
                'label' =>false,   
                'error' => true,
                'required'=>false)));             
    ?>
    <?php echo $this->Form->input('email', array(              
            'label' => array('text' => 'Email', 'class' => 'control-label'),
            'class' => 'form-control',
            'div' => array('class' => 'form-group '.($this->Form->isFieldError('email') ? 'has-error' : '')),
            'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-block'))));                      
    ?>
    <br>
    <?php echo $this->Form->input('password', array(              
            'label' => array('text' => 'Password', 'class' => 'control-label'),
            'class' => 'form-control',
            'div' => array('class' => 'form-group '.($this->Form->isFieldError('password') ? 'has-error' : '')),
            'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-block'))));                      
    ?>
        <div class="checkbox">
            <label>
                <?php echo $this->Form->input('remember',array(
                    'type' => 'checkbox',
                    'label' => array('text' => 'Remember me')            
                    ));?>             
            </label>
        </div>

        <?php echo $this->Form->submit('Signin',array(
            'class'=>'btn btn-default',
            'div' => array('class' => 'form-group')))
        ?> 
        <?php echo $this->Form->end();?>

    </div>
</div>