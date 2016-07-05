<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\Account;
use common\models\UserGroup;

/**
 * Profile form
 */
class Profile extends Account
{

    public $email;
    public $name;
    public $username;
    public $avatar;
    public $phone;
    public $updated_at;
    public $address;
    public $role;
    public $secret;
    public $category;
    public $id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email', 'phone', 'address', 'secret','role'], 'required', 'message' => '{attribute} không được rỗng!'],
//            ['phone', 'unique', 'targetAttribute' => 'phone', 'message' => '{attribute} này đã tồn tại trong hệ thống!'],
            ['phone', 'number', 'integerOnly' => true, 'message' => 'Số điện thoại phải là những dãy số'],
            ['phone', 'string', 'min' => 10, 'max' => 11, 'tooShort' => 'Số điện thoại phải từ 10 đến 11 số', 'tooLong' => 'Số điện thoại phải từ 10 đến 11 số!'],
            ['email', 'email', 'message' => 'Định dạng email không đúng'],
            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\Account', 'message' => 'Email này đã tồn tại trong hệ thống!'],
            [['updated_at'], 'integer'],
            [['avatar'], 'string'],
            ['username', 'validateUsername'],
            ['email', 'validateEmail'],
            ['category', 'default']
        ];
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Họ và tên',
            'username' => 'Tên đăng nhập',
            'avatar' => 'Hình ảnh đại diện',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'role' => 'Quyền hạn',
            'address' => 'Địa chỉ',
            'created_at' => 'Ngày tạo',
            'secret' => 'Mã secret',
            'category' => 'Danh mục'
        );
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
//        foreach ($model as $value) {
//            $data[$value->key] = $value->name;
//        }
//        return $data;
    }

    public function validateUsername($attribute)
    {
        if (!$this->hasErrors())
        {
            $model = Account::find()->where(['username' => $this->username])->one();
            if (!empty($model))
            {
                if ((string) $model->_id != $this->id)
                    $this->addError($attribute, $this->username . ' đã tồn tại trong hệ thống.');
            }
        }
    }

    public function validateEmail($attribute)
    {
        if (!$this->hasErrors())
        {
            $model = Account::find()->where(['email' => $this->email])->one();
            if (!empty($model))
            {
                if ((string) $model->_id != $this->id)
                    $this->addError($attribute, $this->email . ' đã tồn tại trong hệ thống.');
            }
        }
    }

}
