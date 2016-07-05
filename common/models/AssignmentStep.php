<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Assignment model
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
class AssignmentStep extends ActiveRecord {

    // const STATUS_ASSIGNMENT = 0; //Giao viec
    // const STATUS_COMMITMENT = 1; //Cam ket Lam viec
    // const STATUS_DEPOSIT = 2; //Dat coc
    // const STATUS_CONFIRM = 3; //Xac nhan yeu cau
    // const STATUS_PROGRESS = 4; //Tien hanh lam viec
    // const STATUS_COMPLETE = 5; //Xac nhan hoan thanh
    // const STATUS_TEST = 6; //Nghiem thu
    // const STATUS_OVER = 7; //Thanh toan va ban giao

    public static function tableName() {
        return 'assignment_step';
    }

    public function rules() {
        return [
            ['assignment_id', 'string'],
            [['status_owner', 'status_actor', 'created_at'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            '_id',
            'assignment_id',
            'status_owner',
            'status_actor',
            'created_at',
        ];
    }

}
