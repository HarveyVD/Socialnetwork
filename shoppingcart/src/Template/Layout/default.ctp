
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        
        Social Network
    </title>
    
    <?php
        echo $this->Html->meta('icon');
 
        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css('style.css');
 
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
    
</head>
<body>
    <?= $this->element('partials/navigation') ?>
    
    <div class="container">
        <?= $this->Flash->render('flash',['element' => 'Flash/success']) ?>
        <?= $this->fetch('content') ?>
    </div>
    
</body>
</html>
