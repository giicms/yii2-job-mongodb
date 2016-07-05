<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;
use common\models\Category;
use common\models\Account;

class TestQuestion extends ActiveRecord {

    public static function collectionName() {
        return 'test_questions';
    }

    public function rules() {
        return [
            [['name', 'category_id', 'sector_id'], 'required', 'message' => '{attribute} không được rỗng'],
            [['questions'], 'default'],
            [['name', 'user_id'], 'string'],
            [['created_at', 'answers'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'category_id',
            'sector_id',
            'user_id',
            'name',
            'questions',
            'answers',
            'order',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Câu hỏi',
            'questions' => 'Câu trả lời',
            'answers' => 'Câu trả lời đúng',
            'category_id' => 'Danh mục',
            'sector_id' => 'Lĩnh vực',
            'user_id' => 'Người tạo',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật'
        ];
    }

    public function getAccount() {
        return $this->hasOne(Account::className(), ['_id' => 'user_id']);
    }

    public function getSector() {
        $model = TestQuestion::findOne($this->id);
        $data = [];
        if (!empty($model)) {
            foreach ($model->sector_id as $value) {
                $sector = Sectors::findOne($value);
                $data[$sector->id] = $sector->name;
            }
        }
        return $data;
    }

    public function getSectors() {
        $sectors = Sectors::find()->where(['category_id' => $this->category_id])->all();
        $model = TestQuestion::findOne($this->id);
        $data = [];
        if (!empty($model)) {
            foreach ($sectors as $value) {
                $data[$value->id] = $value->name;
            }
        }
        return $data;
    }

    public function getCategoryList() {
        $models = Category::find()->all();
        $data = [];
        if ($models) {
            foreach ($models as $value) {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

    public function getId() {
        return (string) $this->_id;
    }

}
