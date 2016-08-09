<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Status Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $parent_id
 * @property string $body
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ParentStatus $parent_status
 * @property \App\Model\Entity\ChildStatus[] $child_statuses
 */
class Status extends Entity
{

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
    public function getTime($checkTime){
        
        // Biến $created_time là thời gian đem ra so sánh
        $convert_time = $checkTime->format('Y-m-d H:i:s');
        $created_time = new \DateTime($convert_time);  
        // Biến $current_time là thời gian hiện tại
        $current_time = new \DateTime(); 
        
        // Biến $compare là kết quả so sánh
        $compare = $current_time->diff($created_time);
        
        if($compare->y != 0 && $compare->m != 0 && $compare->d != 0 && $compare->h != 0 && $compare->i != 0 && $compare->s != 0){
            if($compare->y > 1){
                return $compare->y . " years ago";
            }
            return $compare->y . " year ago";
        }
        if($compare->m != 0 && $compare->d != 0 && $compare->h != 0 && $compare->i != 0 && $compare->s != 0){
            if($compare->m > 1){
                return $compare->m . " months ago";
            }
            return $compare->m . " month ago";
        }
        if($compare->d != 0 && $compare->h != 0 && $compare->i != 0 && $compare->s != 0){
            if($compare->d > 1){
                return $compare->d . " days ago";
            }
            return $compare->d . " day ago";
        }
        if($compare->h != 0 && $compare->i != 0 && $compare->s != 0){
            if($compare->h > 1){
                return $compare->h . " hours ago";
            }
            return $compare->h . " hours ago";
        }
        if($compare->i != 0 && $compare->s != 0){
            if($compare->i > 1){
                return $compare->i . " minutes ago";
            }
            return $compare->i . " minute ago";
        }
        if($compare->s != 0){
            if($compare->s > 1){
                return $compare->s . " seconds ago";
            }
            return $compare->s . " second ago";
        }
        
       
    }
}
