<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Controller\Component\AuthComponent;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Description of HomeController
 *
 * @author Professional
 */
class HomeController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Friends');
    }

    public function index() {
        if ($this->Auth->user('id')) {
            return $this->redirect(array('controller' => 'Timeline', 'action' => 'index'));
        }
               
    }

}
