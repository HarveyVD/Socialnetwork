<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $location
 * @property string $remember_token
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class User extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
    protected function _getFullName()
    {
        return $this->_properties['first_name'] . '  ' .
            $this->_properties['last_name'];
    }
    public function getName($user = array()) {
        if ($user['first_name'] && $user['last_name']) {
            return $user['first_name'] . ' ' . $user['last_name'];
        }
        if ($user['first_name']) {
            return $user['first_name'];
        }

        return null;
    }

    public function getNameOrUsername($user = array()) {
        return $this->getName($user) ? : $user['username'];
    }

    public function getFirstNameOrUsername($user = array()) {
        return $user['first_name'] ? : $this->getNameOrUsername($user);
    }
    public function getAvatarUrl($user){
        
        $md5 = md5($user['email']);
        return "https://www.gravatar.com/avatar/.$md5.?d=mm&s=40";
    }
    protected function _setPassword($password) {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

}
