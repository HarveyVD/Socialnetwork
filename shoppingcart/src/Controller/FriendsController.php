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
class FriendsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Friends');
    }

    public function index() {
        /**
         * Config
         */
        $friendsTable = TableRegistry::get('Friends');
        $usersTable = TableRegistry::get('Users');
        $setuser = $this->Users->newEntity();

        /*
         * Tim kiem ban be cua User hien tai
         */
        
        $getFriendsID = $this->Friends->find('all', ['fields' => 'friend_id'])->where(['Friends.user_id' => $this->Auth->user('id'), 'Friends.accepted' => true]);
        $friendsOfMine = array();
        $array = array();
        if (!empty($getFriendsID->toArray())) {
            foreach ($getFriendsID->toArray() as $friendId) {
                array_push($array, $friendId->friend_id);
            }

            $friendsOfMine = $this->Users->find('all', ['conditions' => array(
                    'Users.id IN' => $array
                )
            ]);

            foreach ($friendsOfMine->toArray() as $friend) {
                $friend->getNameOrUsername = $setuser->getNameOrUsername($friend);
                $friend->getAvatar = $setuser->getAvatarUrl($friend);
            }
            
            $this->set('friendsOfMine', $friendsOfMine->toArray());
        }
        


        /**
         * check friends request
         */
        
        
        $checkFriendRequests = $this->Friends->find('all', [
                    'conditions' => array(
                        'Friends.friend_id' => $this->Auth->user('id'),
                        'Friends.accepted' => 0
                    )
                ]);
       
        $this->set('checkFriendRequests', $checkFriendRequests);


        /**
         * List friend requests
         */
        $ListFriendRequests = [];

        foreach ($checkFriendRequests as $key => $value) {

            array_push($ListFriendRequests, $usersTable->find('all', [
                        'conditions' => array(
                            'Users.id' => $value['user_id']
                        )
                    ])->all()->toArray());
        }
        foreach ($ListFriendRequests as $key => $value) {
            $value['0']->getNameOrUsername = $setuser->getNameOrUsername($value['0']);
            $value['0']->getAvatar = $setuser->getAvatarUrl($value['0']);
        }
        $this->set('ListFriendRequests', $ListFriendRequests);
    }

    public function AddFriend($username = NULL) {
        $friendsTable = TableRegistry::get('Friends');
        $usersTable = TableRegistry::get('Users');

        $user = $usersTable->find('all', [
                    'conditions' => array(
                        'Users.username' => $username
                    )
                ])->toArray();


        // Nếu không tồn tại User , redirect ngược lại về trang chủ
        if (empty($user)) {
            $this->Flash->error(__('That user could not be found'));
            return $this->redirect(array('controller' => 'home', 'action' => 'index'));
            
        };
        if($this->Auth->user('id') === $user['0']['id']){
            
            return $this->redirect(array('controller' => 'home', 'action' => 'index'));
        }
        // Nếu đã tồn tại request pending, trả về profile của user đó
        $checkIsPending = $friendsTable->find('all', [
            'conditions' => array(
                'OR' => array(
                    array(
                        'Friends.user_id' => $this->Auth->user('id'),
                        'Friends.friend_id' => $user['0']['id']
                    ),
                    array(
                        'Friends.user_id' => $user['0']['id'],
                        'Friends.friend_id' => $this->Auth->user('id')
                    )
                ),
                'Friends.accepted' => 0
            )
        ]);

        if (!empty($checkIsPending->toArray())) {
            return $this->redirect(array('controller' => 'profile', 'action' => 'profile', 'username' => $user['0']['username']));
            $this->Flash->error(__('Friend request already pending'));
        }

        //Neu ca 2 la friend, tra ve profile cua nguoi do
        $checkIsFriend = $friendsTable->find('all', [
            'conditions' => array(
                'Friends.user_id' => $this->Auth->user('id'),
                'Friends.friend_id' => $user['0']['id'],
                'Friends.accepted' => 1
            )
        ]);
        if (!empty($checkIsPending->toArray())) {
            return $this->redirect(array('controller' => 'profile', 'action' => 'profile', 'username' => $user['0']['username']));
            $this->Flash->error(__('You are already friends'));
        }

        // Ok, click vao nut se dong y ket ban
        $array = array(
            'user_id' => $this->Auth->user('id'),
            'friend_id' => $user['0']['id'],
            'accepted' => 0,
        );
        $friend = $this->Friends->newEntity();
        $friend = $this->Friends->patchEntity($friend, $array);       
        if ($this->Friends->save($friend)) {
            $this->Flash->set('Sent request successfully', [
                'element' => 'success'
            ]);

            return $this->redirect(array('controller' => 'profile', 'action' => 'profile', 'username' => $user['0']['username']));
        }
        return $this->redirect(array('controller' => 'profile', 'action' => 'profile', 'username' => $user['0']['username']));
    }

    public function AcceptFriendRequest($username = null) {
        $friendsTable = TableRegistry::get('Friends');
        $usersTable = TableRegistry::get('Users');

        $user = $usersTable->find('all', [
                    'conditions' => array(
                        'Users.username' => $username
                    )
                ])->toArray();

        if (empty($user)) {
            return $this->redirect(array('controller' => 'home', 'action' => 'index'));
        }

        //check neu user ko nhan duoc friend request
        $check = $friendsTable->find('all', [
                    'conditions' => array(
                        'Friends.user_id' => $user['0']['id'],
                        'Friends.friend_id' => $this->Auth->user('id'),
                        'Friends.accepted' => 0
                    )
                ])->toArray();

        if (empty($check)) {
            return $this->redirect(array('controller' => 'home', 'action' => 'index'));
        }

        $getID = $check['0']['id'];
        debug($getID);
        $friend = $this->Friends->get($getID);
        
        $array = array(
            'user_id' => $user['0']['id'],
            'friend_id' => $this->Auth->user('id'),
            'accepted' => 1,           
        );

        $this->Friends->patchEntity($friend, $array);
        debug($this->Friends->patchEntity($friend, $array)); 
        debug($this->Friends->save($friend));
        
        if ($this->Friends->save($friend)) {
            $this->Flash->success(__('Ban da tro thanh ban voi ' . $user['0']['username']));


            return $this->redirect(array('controller' => 'profile', 'action' => 'profile', 'username' => $user['0']['username']));
        }
        
        
        $this->Flash->error(__('Unable to add user'));
    }

}
