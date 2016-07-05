<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Category;
use common\models\Skills;

/**
 * Boss model
 *
 * @property string $category_id
 * @property string $name
 */
class Sectors extends ActiveRecord {

    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    public static function collectionName() {
        return 'job_sectors';
    }

    public function rules() {
        return [
            [['name', 'category_id'], 'required'],
            [['skills'], 'default'],
            [['icon', 'description'], 'string'],
            [['test_time', 'test_number', 'view'], 'integer'],
            [['test_time', 'test_number'], 'number', 'integerOnly' => true, 'message' => '{attribute} phải là những dãy số'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'category_id',
            'name',
            'slug',
            'skills',
            'publish',
            'icon',
            'description',
            'test_number',
            'test_time',
			'view'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên lĩnh vực',
            'description' => 'Mô tả',
            'test_time' => 'Thời gian cho bài test',
            'test_number' => 'Số câu cho bài test',
        ];
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['_id' => 'category_id']);
    }

    public static function getSkill($id) {
        return Skills::findOne($id);
    }

    public static function getExitskill($sector, $id) {
        $model = Sectors::find()->where(['_id' => $sector])->andWhere(['IN', 'skills', $id])->one();
        if (!empty($model))
            return 1;
        else
            return 0;;
    }

    public function getId() {
        return (string) $this->_id;
    }

}
