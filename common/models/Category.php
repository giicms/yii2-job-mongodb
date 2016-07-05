<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Sectors;
use common\models\Skills;

/**
 * Category model
 *
 * @property string $name
 * @property string $sectors
 */
class Category extends ActiveRecord {

    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    public static function collectionName() {
        return 'job_categories';
    }

    public function rules() {
        return [
            [['name', 'test_time', 'test_number', 'icon'], 'required', 'message' => '{attribute} không được rỗng'],
            [['slug', 'icon', 'description'], 'string'],
            [['test_time', 'test_number', 'publish', 'deposit'], 'integer'],
            [['test_time', 'test_number'], 'number', 'integerOnly' => true, 'message' => '{attribute} chỉ được nhập số']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'slug',
            'icon',
            'deposit',
            'description',
            'publish',
            'test_time',
            'test_number'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên danh mục',
            'description' => 'Mô tả',
            'deposit' => 'Đặt cọc',
            'test_time' => 'Thời gian cho bài test',
            'test_number' => 'Số câu cho bài test'
        ];
    }

    // get job sector in job category
    public static function getJobsector($id) {
        $model = Sectors::find()->where(['category_id' => $id])->all();
        return $model;
    }

    public function getSectors() {
        return Sectors::find()->where(['category_id' => $this->id])->all();
    }

    public function getId() {
        return (string) $this->_id;
    }

}
