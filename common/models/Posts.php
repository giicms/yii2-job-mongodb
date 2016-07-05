<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\BlogCategory;

class Posts extends ActiveRecord {

    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    public static function collectionName() {
        return 'posts';
    }

    public function rules() {
        return [
            [['name', 'content', 'category_id'], 'required', 'message' => '{attribute} không được rỗng'],
            [['name', 'slug', 'description', 'content', 'thumbnail', 'user_id', 'alias'], 'string'],
            [['publish', 'view', 'created_at', 'updated_at'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'slug',
			'alias',
            'description',
            'content',
            'thumbnail',
            'category_id',
            'user_id',
            'view',
            'publish',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tiêu đề',
            'category_id' => 'Danh mục',
            'description' => 'Mô tả',
            'content' => 'Nội dung',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'user_id' => 'Người tạo',
            'publish' => 'Trạng thái'
        ];
    }

    public function getCategory() {
        return $this->hasOne(BlogCategory::className(), ['_id' => 'category_id']);
    }


    public function getId() {
        return (string) $this->_id;
    }

}
