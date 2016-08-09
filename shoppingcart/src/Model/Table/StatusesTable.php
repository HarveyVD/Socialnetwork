<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Statuses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $ParentStatuses
 * @property \Cake\ORM\Association\HasMany $ChildStatuses
 *
 * @method \App\Model\Entity\Status get($primaryKey, $options = [])
 * @method \App\Model\Entity\Status newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Status[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Status|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Status patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Status[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Status findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatusesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('statuses');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('Reply',[
            'className' => 'Statuses',
            'foreignKey' => 'parent_id',
            'joinType' => 'INNER'
        ]);
       $this->belongsTo('Users', [
           'className' => 'Users',
          'foreignKey' => 'user_id',
           'joinType' => 'INNER'
       ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            
            ->notEmpty('body', 'The status field is required')
                
            ->add('body', 'length', [
                    'rule' => ['maxLength', 1000],
                    'message' => "Your status can't more than 1000 characters."
            ]);
        foreach($this->getValue() as $ids){
            $validator                    
                    ->notEmpty('reply-'.$ids->id,'The reply field is required');
        }
        
        return $validator;
    }
    public function getValue(){
        return $this->find('all',[
            'fields' => array('id')
        ])->toArray();
    }
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
//        $rules->add($rules->existsIn(['parent_id'], 'ParentStatuses'));

        return $rules;
    }
}
