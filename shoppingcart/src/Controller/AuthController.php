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
class AuthController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->Auth->allow(['Signup','Signout']);
    }

    public function Signup() {
        
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            
            $user = $this->Users->patchEntity($user, $this->request->data());
            
            if ($this->Users->save($user)) {
                $this->Flash->set('Your account has been created and you can now sign in', [
                    'element' => 'success'
                ]);

                return $this->redirect(array('controller' => 'home', 'action' => 'index'));
            }
            $errors = $user->errors();
            $this->set('errors', $errors);
            $this->Flash->error(__('Unable to add user'));
        }
    }

    public function Signin() {
        
        if ($this->request->is('post')) {           
            
            $user = $this->Auth->identify();
            
            if ($user) {
                    $this->Auth->setUser($user);
                    
                    /**
                     * Store username of user logged in
                     */
                    $session = $this->request->session();                  
                    $user = $this->Users->newEntity();
                    debug($this->Auth->user());
                    $session->write('id', $this->Auth->user('id'));
                    $session->write('username', $this->Auth->user('username'));
                    $session->write('getname', $user->getNameOrUsername($this->Auth->user())); 
                    $session->write('getFirstNameorUsername', $user->getFirstNameOrUsername($this->Auth->user())); 
                    return $this->redirect(array('controller' => 'home', 'action' => 'index'));
                    $this->Flash->success(__('ok'));
                } else {
                    $this->Flash->error(__('Your username or password is incorrect.'));
                    
                }
            
        }
    }
    public function Signout(){
        $this->Flash->set("You're logged out!");
        return $this->redirect($this->Auth->logout());
    }
}
