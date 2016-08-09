<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;
use App\Controller\AppController;
use Controller\Component\AuthComponent;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
/**
 * Description of TimeLineController
 *
 * @author Professional
 */
class StatusController extends AppController {
    public function initialize() {
        parent::initialize();
        $this->loadModel('Statuses');
       
    }
    
    public function status(){
        $statusTable = TableRegistry::get('Statuses');
        
        $status = $this->Statuses->newEntity();
        $status = $this->Statuses->patchEntity($status, $this->request->data);       
        
        
        $results = $statusTable->find('all')->toArray();
        
       
    }
}
