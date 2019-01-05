<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * ActiveQuery class for app\models\Users
 *
 * @see Users
 */
class UserQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/


    /**
     * @inheritdoc
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    } // end function


    /**
     * @inheritdoc
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    } // end function

} // end class
