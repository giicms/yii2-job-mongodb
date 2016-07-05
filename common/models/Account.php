<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use yii\mongodb\Query;
use common\models\UserGroup;
use common\models\Category;

class Account extends ActiveRecord implements IdentityInterface
{

//    public $password;
//    public $password_repeat;
//    public $group;

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_AFTER_UPDATE => ['updated_at']
                ]
            ]
        ];
    }

    public function attributes()
    {
        return [
            '_id',
            'parent',
            'name',
            'username',
            'password_hash',
            'password_reset_token',
            'email',
            'auth_key',
            'avatar',
            'phone',
            'address',
            'role',
            'status',
            'level',
            'group',
            'category',
            'secret',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['role', 'group'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Họ và tên',
            'username' => 'Tên đăng nhập',
            'avatar' => 'Hình ảnh đại diện',
            'password' => 'Mật khẩu',
            'password_repeat' => 'Xác nhận mật khẩu',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'role' => 'Quyền hạn',
            'status' => 'Trạng thái',
            'address' => 'Địa chỉ',
            'category' => 'Danh mục',
            'created_at' => 'Ngày đăng ký',
            'updated_at' => 'Ngày cập nhật'
        );
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
                        ->where([
                            'email' => $username
                        ])
                        ->orWhere(['username' => $username])
                        ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token))
        {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token))
        {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
//        $timestamp = (int) substr($token, strrpos($token, '_') + 1);

        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return (string) $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function getAuthkeyUser($email)
    {
        $model = Account::find()->where(['email' => $email])->one();
        if (!empty($model))
        {
            return $model->auth_key;
        }
        else
        {
            return Yii::$app->security->generateRandomString();
        }
    }

    public static function getUserbyemail($email)
    {
        return Account::find()->where(['email' => $email])->one();
    }

    public function getListRole()
    {
        $data = [];
        $min = \Yii::$app->user->identity->level + 1;
        $max = UserGroup::find()->max('level') + 1;
        $model = UserGroup::find()
                ->where(['between', 'level', (int) $min, (int) $max])
                ->all();
        return ArrayHelper::map($model, 'key', 'name');
    }

    public function getCategories()
    {
        $model = Category::find()->all();
        $user = Account::findOne($this->id);
        $items = [];
        foreach ($model as $value)
        {
            $items[$value->id] = ['name' => $value->name, 'active' => in_array($value->id, $user->category) ? 1 : 0];
        }
//        return ArrayHelper::map($model, 'id', 'name');
        return $items;
    }

    public function getCheckassign()
    {
        $auth = Yii::$app->authManager;
        $items = [];
        $assignments = $auth->getAssignments($this->id);
        if (!empty($assignments))
        {
            foreach ($assignments as $value)
            {
                $items[] = $value->roleName;
            }
        }
        return $items;
    }

    public function getAuth()
    {
        $auth = Yii::$app->getAuthManager();
        $data = [];
        foreach ($auth->getRoles() as $name => $role)
        {
            $data[$name] = ['name' => !empty($role->description) ? $role->description : $name, 'active' => in_array($name, $this->checkassign) ? 1 : 0];
        }
        foreach ($auth->getPermissions() as $name => $permission)
        {
            if ($name[0] !== '/')
                $data[$name] = ['name' => !empty($permission->description) ? $permission->description : $name, 'active' => in_array($name, $this->checkassign) ? 1 : 0];
        }
        return $data;
    }

    public function getListauth()
    {
        $auth = Yii::$app->authManager;
        $items = '';
        $assignments = $auth->getAssignments($this->id);
        if (!empty($assignments))
        {
            foreach ($assignments as $value)
            {
                $role = $auth->getRole($value->roleName);
                if (!empty($role))
                    $items .= $role->description . '<br>';
                $permission = $auth->getPermission($value->roleName);
                if (!empty($permission))
                    $items .= $permission->description . '<br>';
            }
        }
        $category = $this->category;
        if (!empty($category))
        {
            $items .= 'Quản lý công việc theo danh mục <br>';
            foreach ($category as $val)
            {
                $cat = Category::findOne($val);
                $items .= '+ ' . $cat->name.'<br>';
            }
        }
        return $items;
    }

}
