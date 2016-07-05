<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;

/**
 * Conversation model
 *
 * @property string $job_id
 * @property string $status
 * @property string $actor
 * @property string $onwer
 */
class Notification extends ActiveRecord {

    public static function collectionName() {
        return 'notifications';
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => ['created_at'],
                ]
            ]
        ];
    }

    public function rules() {
        return [
            [['owner', 'actor', 'content', 'type'], 'string'],
            [['status', 'active', 'set'], 'default', 'value' => 1],
            [['created_at'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'content',
            'owner',
            'actor',
            'type',
            'type_id',
            'status',
            'active',
            'set',
            'created_at',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => 'owner']);
    }

    public function getJob() {
        return $this->hasOne(Job::className(), ['_id' => 'type_id']);
    }

    public function getMessages($key) {
        switch ($key) {
            case 0:
                return "đã book công việc";
                break;
            case 1:
                return "của bạn.";
                break;
            case 2:
                return "đã hủy book công việc";
                break;
            case 3:
                return "đã giao công việc";
                break;
            case 4:
                return "đã xác nhận yêu cầu cho công việc";
                break;
            case 5:
                return "đã cam kết làm việc với bạn cho công việc";
                break;
            case 6:
                return "đã đặt cọc tiền thành công, bạn bắt đầu làm việc cho công việc";
                break;
            case 7:
                return "đã bắt đầu làm việc với công việc";
                break;
            case 8:
                return "dự án";
                break;
            case 9:
                return "đã hoàn thành 80%";
                break;
            case 10:
                return "đã hoàn thành công việc";
                break;
            case 11:
                return "đã duyệt xác nhận hoàn thành công việc";
                break;
            case 12:
                return "đã từ chối xác nhận hoàn thành công việc";
                break;
            case 13:
                return "thông báo thanh toán phần còn lại của dự án";
                break;
            case 14:
                return "để nghiệm thu";
                break;
            case 15:
                return "đã kết thúc";
                break;
            case 16:
                return "hồ sơ của bạn chưa hoàn thành";
                break;
            case 17:
                return "hồ sơ của bạn đã được duyệt";
                break;
            case 18:
                return "đã chọn bạn làm việc cho công việc";
                break;
            case 19:
                return "báo cáo";
                break;
            case 20:
                return "mời bạn nhận công việc";
                break;
            case 21:
                return "đã từ chối book công việc";
                break;
            case 22:
                return "đã đồng ý làm việc làm việc";
                break;
            case 23:
                return "đã thay đổi yêu cầu cho công việc";
                break;
            case 24:
                return "đã xác nhận yêu cầu";
                break;
            case 25:
                return "đã gởi yêu cầu đến bạn";
                break;
            case 26:
                return "đã đồng ý yêu cầu của bạn";
                break;
            case 27:
                return "đã hủy yêu cầu của bạn";
                break;
            case 28:
                return "bạn đã được lên 1 cấp độ nhân viên cao hơn. Xin chúc mừng bạn.";
        }
    }

}
