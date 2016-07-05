<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Boss model
 *
 * @property string $actor
 * @property string $ower
 * @property string $job
 */
class Level extends ActiveRecord
{

    public static function collectionName()
    {
        return 'user_levels';
    }

    public function rules()
    {
        return [
            [['name', 'order'], 'required'],
            [['icon', 'rating'], 'string'],
            [['count_job','count_bid', 'review'], 'integer']
        ];
    }

    public function attributes()
    {
        return [
            '_id',
            'name',
            'icon',
            'order',
            'count_job',
            'count_bid',
            'review',
            'rating',
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Tên cấp bậc',
            'icon' => 'Icon',
            'order' => 'Thứ tự',
            'count_job' => 'Công việc hoàn thành',
            'count_bid' => 'Số lượng bid',
            'review' => 'Số review',
            'rating' => 'Điểm trung bình'
        ];
    }

    public function getId()
    {
        return (string) $this->_id;
    }

}
