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
class ProfileController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Friends');
    }

    public function profile($username) {
        /**
         * Config..
         */
        $friendsTable = TableRegistry::get('Friends');
        $usersTable = TableRegistry::get('Users');
        $setuser = $this->Users->newEntity();

        /**
         * Hiển thị thông tin cá nhân
         */
        $result = $usersTable->find('all', [
            'conditions' => array(
                'Users.username' => $username
            )
        ]);
        $user = $result->first();
        if (!$user) {
            throw new NotFoundException('404');
        }

        $user->getFirstNameOrUsername = $setuser->getFirstNameOrUsername($user);
        $user->getAvatar = $setuser->getAvatarUrl($user);
        $user->getNameOrUsername = $setuser->getNameOrUsername($user);

        $this->set('user', $user);

        /**
         * Hiển thị danh sách bạn bè
         */
        $getFriendsID = $this->Friends->find('all', [
            'conditions' => array(
                'OR'=> array(
                    'Friends.user_id' => $user->id,
                    'Friends.friend_id' => $user->id,                    
                ),
                'Friends.accepted' => TRUE
            )
        ]);
        
        $friendsOfUser = array();
        $array = array();
        if (!empty($getFriendsID->toArray())) {
            
            foreach ($getFriendsID->toArray() as $friendId) {
                if($friendId->friend_id == $user->id){
                    array_push($array, $friendId->user_id);
                }
                
                if($friendId->user_id == $user->id){
                    array_push($array, $friendId->friend_id);
                }
            }
            
            $friendsOfUser = $this->Users->find('all', ['conditions' => array(
                    'Users.id IN' => $array
                )
            ]);
            
            foreach ($friendsOfUser->toArray() as $friend) {
                $friend->getNameOrUsername = $setuser->getNameOrUsername($friend);
                $friend->getAvatar = $setuser->getAvatarUrl($friend);
            }
            
            $this->set('friendsOfUser', $friendsOfUser->toArray());
        }
        

        /**
         * Waiting for response request
         */
        $checkPeding = $friendsTable->find('all', [
            'conditions' => array(
                'Friends.user_id' => $this->Auth->user('id'),
                'Friends.friend_id' => $user['id'],
                'Friends.accepted' => 0
            )
        ]);

        $this->set('checkPending', $checkPeding->toArray());

        /**
         *  Accept friend request
         */
        $checkReceive = $friendsTable->find('all', [
            'conditions' => array(
                'Friends.user_id' => $user->id,
                'Friends.friend_id' => $this->Auth->user('id'),
                'Friends.accepted' => 0
            )
        ])->contain(['Users']);
       
        $this->set('checkReceive', $checkReceive->all());

        /**
         * Check both are friends
         */
        $isFriends = $friendsTable->find('all', [
            'conditions' => array(
                'OR' =>
                array(array(
                        'Friends.user_id' => $this->Auth->user('id'),
                        'Friends.friend_id' => $user['id']
                    ), array('Friends.user_id' => $user['id'],
                        'Friends.friend_id' => $this->Auth->user('id'))),
                'Friends.accepted' => 1
            )
        ]);
        $this->set('isFriends', $isFriends->all());
    }

    public function Edit($id) {
        $user = $this->Users->get($id);

        if ($this->request->is('post', 'put')) {

            $this->Users->patchEntity($user, $this->request->data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your user has been updated.'));


                return $this->redirect(array('controller' => 'home', 'action' => 'index'));
            }
            $errors = $user->errors();
            $this->set('errors', $errors);
            $this->Flash->error(__('Unable to add user'));
        }
    }

}
