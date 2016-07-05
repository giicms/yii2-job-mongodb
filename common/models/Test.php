<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;
use common\models\TestQuestion;
use common\models\Category;
use common\models\Sectors;

class Test extends ActiveRecord {

    const PUBLISH_DONE = 2; // test hoàn thành
    const PUBLISH_DELAY = 1; // test chưa xong

    public static function collectionName() {
        return 'tests';
    }

    public function rules() {
        return [
            [['category_id', 'sector_id'], 'required', 'message' => '{attribute} không được rỗng'],
            [['questions'], 'default'],
            [['user_id', 'count_time', 'category_id', 'sector_id'], 'string'],
            [['created_at', 'point', 'publish', 'random'], 'integer'],
            ['sector_id', 'validateSector']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'questions',
            'answers',
            'created_at',
            'updated_at',
            'count_time',
            'point',
            'publish',
            'random',
            'category_id',
            'sector_id'
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'category_id' => 'Danh mục ngành nghề',
            'sector_id' => 'Lĩnh vực ngành nghề',
        ];
    }

    public function validateSector($attribute) {
        if (!$this->hasErrors()) {
            $model = Sectors::findOne($this->sector_id);
            if (empty($model->test_number)) {
                $this->addError($attribute, 'Lĩnh vực này không có bài test');
            }
        }
    }

    public function getId() {
        return (string) $this->_id;
    }

    public static function question($id) {
        return TestQuestion::findOne($id);
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

    public function getCategory() {
        return $this->hasOne(Category::className(), ['_id' => 'category_id']);
    }

    public function getSector() {
        return $this->hasOne(Sectors::className(), ['_id' => 'sector_id']);
    }

    public static function getSkills($id) {
        $model = Skills::findOne($id);
        return $model;
    }

}
