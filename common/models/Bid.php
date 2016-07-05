<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;
use common\models\Job;
use common\models\Bid;
use common\models\Assignment;

class Bid extends ActiveRecord
{

    public static function collectionName()
    {
        return 'bid_list';
    }

    public function attributes()
    {
        return [
            '_id',
            'actor',
            'job_id',
            'price',
            'period',
            'created_at',
            'content',
            'publish',
            'status'
        ];
    }

    public function attributeLabels()
    {
        return array(
            'job_id' => 'Tiêu đề công việc',
            'price' => 'Chào giá',
            'period' => 'Thời gian hoàn thành',
            'content' => 'Tin nhắn'
        );
    }

    public function getId()
    {
        return (string) $this->_id;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['_id' => 'actor']);
    }

    public function getJob()
    {
        return $this->hasOne(Job::className(), ['_id' => 'job_id']);
    }

    public function getOptions()
    {
        $model = Assignment::find()->where(['bid_id' => (string) $this->_id])->one();
        if (!empty($model))
        {
            if ($model->status_boss == Assignment::STATUS_COMMITMENT)
                $status = "Bạn chờ xác nhận yêu cầu!";
            elseif ($model->status_boss == Assignment::STATUS_PROGRESS)
                $status = "Bạn đang làm việc";
            elseif ($model->status_boss == Assignment::STATUS_COMPLETE)
                $status = "Bạn đã hoàn thành dự án";
            elseif ($model->status_boss == Assignment::STATUS_REVIEW)
                $status = "Bạn đã hoàn thành dự án";
            else
                $status = NULL;
            return $status;
        }
    }

}
