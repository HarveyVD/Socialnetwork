<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Viet</a>
        </div>

        <div class="collapse navbar-collapse">
            <!-- @if (Auth::check()) -->
            <ul class="nav navbar-nav">
                <li><a href="#">Timeline</a></li>
                <li><?php echo $this->Html->link(__('Friends'),array('controller'=>'Friends','action'=>'index'))?></li>
            </ul>

            <?php
            echo $this->Form->create('Users', array(
                'url' => array('controller' => 'Search', 'action' => 'Results'),
                'role' => 'search',
                'type' => 'get',
                'class' => 'navbar-form navbar-left',
                'inputDefaults' => array(
                    'label' => false,
                    'error' => true,
                    'required' => false))
            );
            ?>
            <div class="form-group">
                <?php
                echo $this->Form->input('query', array(
                    'templates' => [
                        'inputContainer' => "{{content}}"
                    ],
                    'class' => 'form-control',
                    'placeholder' => 'Find people',
                    'type' => 'text',
                    'label' => false,
                        )
                );
                ?>
            </div>
            <div class="submitNav">
                <?php
                echo $this->Form->input('Search', array(
                    'type' => 'submit',
                    'class' => 'btn btn-default',
                    'templates' => [
                        'inputContainer' => "{{content}}"
                    ],
                        )
                );
                ?>
            </div>

            <?php
            echo $this->Form->end();
            ?>


            <!-- @endif -->

            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->request->session()->read('Auth')): ?>

                    <li><?php echo $this->Html->link(__($this->request->session()->read('getname')), array('controller'=>'Profile','action'=>'Profile','username'=> $this->request->session()->read('username'))) ?></li>

                    <li><?php echo $this->Html->link(__('Update Profile'),array('controller'=>'Profile','action'=>'Edit','id'=> $this->request->session()->read('id')))?></li>
                    <li><?php echo $this->Html->link(__('Sign out'), array('controller' => 'auth', 'action' => 'Signout')) ?></li>
                <?php else: ?>
                    <li><?php echo $this->Html->link(__('Sign up'), array('controller' => 'auth', 'action' => 'Signup')) ?></li>
                    <li><?php echo $this->Html->link(__('Sign in'), array('controller' => 'auth', 'action' => 'Signin')) ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
