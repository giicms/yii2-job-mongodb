<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Page model
 *
 * @property string $conversation_id
 * @property string $job_id
 * @property string $actor
 * @property string $bid_id
 * @property string $price
 * @property string $time_start
 * @property string $time_end
 * @property string $required
 * @property string $status
 * @property string $working_status
 */
class Page extends ActiveRecord {

    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    public static function collectionName() {
        return 'page';
    }

    public function rules() {
        return [
            [['name', 'alias', 'note', 'content'], 'required', 'message' => '{attribute} không được rỗng'],
            [['slug', 'alias', 'name', 'note', 'content', 'description', 'meta', 'keywords', 'user_id', 'thumbnail'], 'string'],
            [['created_at', 'updated_at', 'publish'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user',
            'name',
            'slug',
            'alias',
            'note',
            'content',
            'thumbnail',
            'description',
            'keywords',
            'meta',
            'publish',
            'user_id',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tiêu đề',
            'description' => 'Mô tả',
            'content' => 'Nội dung',
            'note' => 'Ghi chú',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'user_id' => 'Người tạo',
            'publish' => 'Trạng thái'
        ];
    }

    public static function getPage($alias) {
        $model = Page::find()->where(['alias' => $alias])->one();
        return $model;
    }

    public function getId() {
        return (string) $this->_id;
    }

}
