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
 * Description of SearchController
 *
 * @author Professional
 */
class SearchController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        
    }

    public function Results() {
        $query = $this->request->query('query');
        if (!$query) {
            return $this->redirect(array('controller' => 'home', 'action' => 'index'));
        }
        
        //Search      
        $usersTable = TableRegistry::get('Users');
        
        $results = $usersTable->find('all',[
            'conditions' => array(
                'OR' => array(
                    'Users.username' . ' LIKE' => '%'.$query.'%',
                    'Users.first_name' . ' LIKE' => '%'.$query.'%',
                    'Users.last_name' . ' LIKE' => '%'.$query.'%'
                )
            )
        ]);
        $user = $this->Users->newEntity();
        
        $results = $results->all()->toArray();
        foreach($results as $key => $value){
            
            
            $value->getNameOrUsername = $user->getNameOrUsername($value);    
            $value->getAvatar = $user->getAvatarUrl($value);
        }
        
        $this->set('users', $results);
    }

}
