<?php

namespace app\components;

use yii\base\Component;

/**
 * Class Access
 * Custom Yii2 application component
 *
 * @package app\components
 */
class Access extends Component
{

    public static $user;


    /**
     * Access class constructor
     * @throws \Throwable
     */
    public function __construct()
    {
        if (\Yii::$app->user->getIdentity()) {
            static::$user = (\Yii::$app->user->getIdentity())->role;
        } else {
            static::$user = 'guest';
        }
        parent::__construct();
    } // end construct


    /**
     * @return bool
     */
    public function isSupervisor()
    {
        return static::$user == 'supervisor';
    } // end function


    /**
     * @return bool
     */
    public function isAdmin()
    {
        if (static::$user == 'supervisor' || static::$user == 'administrator') {
            $access = true;
        } else {
            $access = false;
        }
        return $access;
        //return static::$user == 'supervisor';
    } // end function


    /**
     * @return bool
     */
    public function isUser()
    {
        return static::$user == 'user';
    } // end function

} // end class
