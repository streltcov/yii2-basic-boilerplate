<?php

namespace app\models;

//use app\interfaces\UserInterface;
use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * ActiveRecord class for table "users";
 * Identity model, implements IdentityInterface;
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $password_hash
 * @property string $name
 * @property string $lastname
 * @property string $role
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    } // end function


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name', 'lastname'], 'required'],
            [['username', 'image', 'password_hash', 'name', 'lastname', 'role'], 'string', 'max' => 255],
            [['password', 'auth_key'], 'string', 'max' => 100],
        ];
    } // end function


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ]
        ];
    } // end function


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_hash' => 'Хэш пароля',
            'name' => 'Имя',
            'lastname' => 'Фамилия',
            'created_at' => 'Создан',
            'auth_key' => 'Ключ авторизации',
            'role' => 'Доступ',
            'image' => 'Фотография'
        ];
    } // end function


    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    } // end function


    /**
     * finds an identity by given ID
     *
     * @param $id
     * @return IdentityInterface|static
     */
    public static function findIdentity($id)
    {
        if (Yii::$app->db->getTableSchema(static::tableName(), true) !== null) {
            return static::findOne($id);
        } else {
            return new static([
                'name' => 'admin',
                'password' => 'admin'
            ]);
        }
    } // end function


    /**
     * @param mixed $token
     * @param null $type
     * @return User|null|IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    } // end function


    /**
     * @return mixed|string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    } // end function


    /**
     * @param string $authkey
     * @return bool
     */
    public function validateAuthKey($authkey)
    {
        return $this->getAuthKey() === $authkey;
    } // end function


    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    } // end function


    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        if ($this->isNewRecord) {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        return true;
    } // end function
    

    /**
     * @param $password
     * @return bool
     * @throws \yii\base\Exception
     */
    public function validatePassword($password)
    {
        $hash = Yii::$app->security->generatePasswordHash($this->password);
        return Yii::$app->security->validatePassword($password, $hash);
    } // end function


    /**
     * @param $username
     * @return null|static
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    } // end function

} // end class
