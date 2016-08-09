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
use Cake\I18n\Time;
/**
 * Description of TimeLineController
 *
 * @author Professional
 */
class TimelineController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Statuses');
        $this->loadModel('Users');
        $this->loadModel('Friends');       
        $this->loadComponent('Paginator');
    }

    public $paginate = [
        'limit' => 5,
        'order' => [
            'created' => 'DESC'
        ]
    ];
    public function postReply($statusId){    
        
        $new_status = $this->Statuses->newEntity();
        
        // Nếu request gửi lên dưới dạng post
        if($this->request->is('post')){                       
            $new_status = $this->Statuses->patchEntity($new_status,$this->request->data);
            
            // Nếu có lỗi liên quan đến validate, hiển thị nó trên view
            if(!empty($new_status->errors())){
                $this->Flash->set(array_values($new_status->errors()['reply-'.$statusId])['0'], [                    
                ]);          
                $this->render($this->referer()) ;
                die;
            }
            
            $status = $this->Statuses->find('all')->where(['parent_id IS' => null]);
            
            // Nếu không có status nào
            if(empty($status->toArray())){
                return $this->redirect(array('controller' => 'home', 'action' => 'index'));
            }
            
            // Nếu người đăng nhập không phải là bạn với người đăng status và đồng thời id của 2 người khác nhau - dòng check này liên quan đến bảo mật
            $checkisFriend = $this->Statuses->find('all',array(
                'conditions' => array(
                    'user_id IN' => function(){
                        $array = array();                
                        $friends_id = $this->Friends->find('all',array('fields' => array('friend_id')))
                                ->where(['user_id' => $this->Auth->user('id'), 'accepted' => 1])->toArray(); 
                        foreach($friends_id as $value){
                            array_push($array, $value->friend_id);
                        }
                        return $array;
                    }
                )
            ))->toArray();
            
            
            if(empty($checkisFriend) && $status->where(['user_id !=' => $this->Auth->user()])){
                $this->Flash->set('Yeah yeah yeah', [
                    'element' => 'success'
                ]);
                return $this->redirect(array('controller' => 'home', 'action' => 'index'));
            }
            
            // Save
            
            $new_reply = $this->Statuses->newEntity();
          
            $array = array(
                
                'user_id' => $this->Auth->user(),
                'parent_id' => $statusId,
                'body' => $this->request->data['reply-'.$statusId]
            );
                        
            $new_reply = $this->Statuses->patchEntity($new_reply,$array);
            
            // Nếu có lỗi liên quan đến validate, hiển thị nó trên view
            
           
            if($this->Statuses->save($new_reply)){
                $this->Flash->set('reply posted', [
                    'element' => 'success'
                ]);
                return $this->redirect(array('controller' => 'home', 'action' => 'index'));
            }
        }
        
    }
    public function postStatus(){
        $new_status = $this->Statuses->newEntity();
        // Nếu request gửi lên dưới dạng post
        if($this->request->is('post')){            
            $this->request->data['user_id'] = $this->Auth->user('id');
            $new_status = $this->Statuses->patchEntity($new_status,$this->request->data);
            
            // Nếu có lỗi liên quan đến validate, hiển thị nó trên view
            if(!empty($new_status->errors())){             
                $this->Flash->set(array_values($new_status->errors()['body'])['0'], [
                    
                ]);          
                return $this->redirect($this->referer())    ;                            
            }
            
            // Nếu validate được thông qua, thực hiện lưu status và chuyển hướng tới home
            if($this->Statuses->save($new_status)){
                $this->Flash->set('Status posted', [
                    'element' => 'success'
                ]);
                return $this->redirect(array('controller' => 'home', 'action' => 'index'));
            }
            
            // Nếu validation hợp lệ mà vẫn ko save được, có thể do 1 lỗi khác 
            
            
        }
    }
    public function index() {
        /**
         * Show Statuses
         */       
        // Lấy về status do user đã đăng nhập , và bạn bè đã post lên
        $friends = $this->Friends->find('all',array('fields' => array('friend_id')))
                                ->where(['user_id' => $this->Auth->user('id'), 'accepted' => 1])->toArray();
        
        $getFriend_ids = array();
        foreach($friends as $friend){
            
            array_push($getFriend_ids, $friend->friend_id);
        }
        $statuses = array();
        
        if(!empty($getFriend_ids)){
            $statuses = $this->Statuses->find('all', [
                'conditions' => array(
                    'OR' => array(
                        'Statuses.user_id' => $this->Auth->user('id'),
                    
                        'Statuses.user_id IN' => $getFriend_ids,                                     
                    ),
                    'Statuses.parent_id IS' => NULL
                )
            ])->contain(['Users','Reply']);
        }
        if(empty($getFriend_ids)){
            $statuses = $this->Statuses->find('all', [
                'conditions' => array(
                    'OR' => array(
                        'Statuses.user_id' => $this->Auth->user('id'),                                                            
                    ),
                    'Statuses.parent_id IS' => NULL
                )
            ])->contain(['Users','Reply']);
        }
        
        
        // Thêm vào 1 số thuộc tính cho Status như : Avatar , Firstname...
        if(!empty($statuses->toArray())){
        $statuses = $this->paginate($statuses);       
            foreach($statuses->toArray() as $status){
                $status->avatar = $this->Users->newEntity()->getAvatarUrl($status->user);
                $status->NameorUsername = $this->Users->newEntity()->getNameOrUsername($status->user);
                $status->Time = $this->Statuses->newEntity()->getTime($status->created);
                foreach($status->reply as $reply){
                    $reply->avatar = $this->Users->newEntity()->getAvatarUrl($this->Users->find()->where(['id' => $reply->user_id])->first());
                    $reply->NameOrUsername = $this->Users->newEntity()->getNameOrUsername($this->Users->find()->where(['id' => $reply->user_id])->first());
                    $reply->Time = $this->Statuses->newEntity()->getTime($reply->created);
                    $reply->username = $this->Users->find()->where(['id' => $reply->user_id])->first()->username;
                };            
            }            
        }
        
        $this->set('statuses', $statuses);  
        
        /**
         * show Replys
         */
        
    }
    
}
