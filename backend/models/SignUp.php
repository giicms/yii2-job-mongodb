<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Account;
use common\models\Category;

/**
 * Profile form
 */
class SignUp extends Account
{

    public $password;
    public $password_repeat;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email', 'phone', 'password', 'password_repeat', 'address', 'secret', 'category', 'role'], 'required', 'message' => '{attribute} không được rỗng!'],
            ['phone', 'unique', 'targetAttribute' => 'phone', 'message' => '{attribute} này đã tồn tại trong hệ thống!'],
            ['username', 'unique', 'targetAttribute' => 'username', 'message' => '{attribute} này đã tồn tại trong hệ thống!'],
            ['phone', 'number', 'integerOnly' => true, 'message' => 'Số điện thoại phải là những dãy số'],
            ['phone', 'string', 'min' => 10, 'max' => 11, 'tooShort' => 'Số điện thoại phải từ 10 đến 11 số', 'tooLong' => 'Số điện thoại phải từ 10 đến 11 số!'],
            ['email', 'email', 'message' => 'Định dạng email không đúng'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Account', 'message' => 'Email này đã tồn tại trong hệ thống!'],
            ['password', 'string', 'min' => 8, 'tooShort' => 'Mật khẩu phải trên 8 ký tự!'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Hai mật khẩu không trùng nhau!'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Họ và tên',
            'username' => 'Tên đăng nhập',
            'password' => 'Mật khẩu',
            'password_repeat' => 'Nhập lại mật khẩu',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'role' => 'Quyền hạn',
            'address' => 'Địa chỉ',
            'created_at' => 'Ngày tạo',
            'secret' => 'Mã secret',
            'category' => 'Danh mục'
        ];
    }

    public function getCategories()
    {
        $model = Category::find()->all();
        $items = [];
        foreach ($model as $value)
        {
            $items[$value->id] = ['name' => $value->name];
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

}
