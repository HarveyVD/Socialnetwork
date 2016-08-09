<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('Statuses', [
            'className' => 'Statuses',
            'foreignKey' => 'user_id',            
            'joinType' => 'INNER'
        ]);
//        $this->hasMany('friendsOfMine', [
//            'className' => 'Friends',
//            'foreignKey' => 'user_id'
//        ]);
        $this->belongsToMany('friendOf', [
            'className' => 'Users',
            'joinTable' => 'friends',
            'foreignKey' => 'friend_id',
            'targetForeignKey' => 'user_id',
            'conditions' => array(
                'accepted' => true
            )
        ]);
        
        $this->belongsToMany('friendsOfMine', [
            
            'className' => 'Users',
            'joinTable' => 'Friends',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'friend_id',
        ]);
        
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->allowEmpty('first_name')
                ->add('first_name', 'length', [
                    'rule' => ['maxLength', 50],
                    'message' => "Your first name can't contain more than 50 characters."
                ])
                ->add('first_name', 'char', [
                    'rule' => array('custom', '|^[a-zA-Z ]*$|'),
                    'message' => 'First name must be letters'
        ]);
        $validator
                ->email('email')
                ->requirePresence('email', 'create')
                ->notEmpty('email', 'The email field is required')
                ->add('email', 'length', [
                    'rule' => ['maxLength', 255],
                    'message' => "Your email can't contain more than 255 characters."
        ]);
        $validator
                ->requirePresence('username', 'create')
                ->notEmpty('username')
                ->add('username', 'length', [
                    'rule' => ['maxLength', 50],
                    'message' => "The username can't more than 50 characters."
                ])
                ->add('username', 'validFormat', [
                    'rule' => array('custom', '|^[a-zA-Z ]*$|'),
                    'message' => 'Username must be letters'
        ]);

        $validator
                ->requirePresence('password', 'create')
                ->notEmpty('password', 'The password field is required')
                ->add('password', 'length', [
                    'rule' => ['minLength', 6],
                    'message' => 'The password must be at least 6 characters.'
        ]);



        $validator
                ->allowEmpty('last_name')
                ->add('last_name', 'length', [
                    'rule' => ['maxLength', 50],
                    'message' => "Your last name can't contain more than 50 characters."
                ])
                ->add('last_name', 'length', [
                    'rule' => array('custom', '|^[a-zA-Z ]*$|'),
                    'message' => 'Last name must be letters'
        ]);
        $validator
                ->allowEmpty('location')
                ->add('location', 'length', [
                    'rule' => ['maxLength', 20],
                    'message' => "Location can't contain more than 20 characters."
        ]);

        $validator
                ->allowEmpty('remember_token');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }

}
