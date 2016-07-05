<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArraArrayHelper;
use common\models\Level;
use common\models\BudgetPacket;
use common\models\BudgetPrice;
use common\models\City;
use common\models\Category;
use common\models\Sectors;
use common\models\User;
use common\models\Bid;
use common\models\PersonalStorage;

/**
 * Job model
 *
 * @property string $job_code
 * @property string $name
 * @property string $category
 * @property string $description
 * @property string $file
 * @property string $project_type
 * @property string $budget_type
 * @property string $price
 * @property string $deadline
 * @property string $skill
 * @property string $levels
 * @property string $publish
 * @property string $more_request
 * @property string $job_application
 * @property string $times_bid
 * @property string $block_list
 * @property string $onwer
 */
class Job extends ActiveRecord
{

    //project type
    const WORK_HOURS = 1;
    const WORK_PACKAGE = 2;
    //status
    const PROJECT_PUBLISH = 1; // Du an dang cho
    const PROJECT_PENDING = 2; // Du an da giao viec
    const PROJECT_DEPOSIT = 3; // Dat coc thanh toan
    const PROJECT_COMPLETED = 4; //Hoan thanh & thanh toan
    const PROJECT_OVER = 5; //du an kết thúc
    //publish
    const PUBLISH_NOACTIVE = 1; // viec cho duyet
    const PUBLISH_VIEW = 2; // luu nhap
    const PUBLISH_ACTIVE = 3; // viec da duyet
    const PUBLISH_CLOSE = 4; // boss ẩn việc
    //block
    const JOB_BLOCK = 2; // admin khóa việc
    const JOB_UNBLOCK = 1; // admin mở khóa việc
    // featured
    const FEATURED_OPEN = 1;
    const FEATURED_CLOSE = 2;

    public static function collectionName()
    {
        return 'jobs';
    }

    public function attributes()
    {
        return [
            '_id',
            'job_code',
            'name',
            'slug',
            'slugname',
            'category_id',
            'sector_id',
            'options',
            'description',
            'file',
            'project_type',
            'budget_type',
            'price',
            'deadline',
            'address',
            'district_id',
            'city_id',
            'level',
            'publish',
            'block',
            'more_resquest',
            'job_application',
            'num_bid',
            'block_list',
            'owner',
            'count',
            'status',
            'work_location',
            'featured',
            'created_at',
            'updated_at'
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Tiêu đề công việc',
            'category_id' => 'Danh mục ngành nghề',
            'sector_id' => 'Lĩnh vực ngành nghề',
            'description' => 'Mô tả công việc',
            'file' => 'File đính kèm',
            'project_type' => 'Loại hình công việc',
            'budget_type' => 'Loại ngân sách công việc',
            'price' => 'Ngân sách công việc',
            'deadline' => 'Thời gian kết thúc nhận việc',
            'level' => 'Cấp độ nhân viên',
            'publish' => 'Publish',
            'more_request' => 'Yêu cầu thêm',
            'job_application' => 'Yêu cầu viết đơn xin việc',
            'num_bid' => 'Số lượng nhận book tối đa',
            'block_list' => 'Dang sách người dùng bị từ chối',
            'owner' => 'Chủ dự án',
            'work_location' => 'Địa điểm làm việc',
            'address' => 'Địa chỉ cụ thể',
            'district_id' => 'Quận huyện',
            'city_id' => 'Tỉnh/thành phố'
        ];
    }

    public function behaviors()
    {
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

    public function getId()
    {
        return (string) $this->_id;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['_id' => 'owner']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['_id' => 'category_id']);
    }

    public function getJobInvited()
    {
        return $this->hasOne(JobInvited::className(), ['_id' => 'job_id']);
    }

    public function getSector()
    {
        return $this->hasOne(Sectors::className(), ['_id' => 'sector_id']);
    }

    public static function getSkillname($id)
    {
        $model = Skills::findOne($id);
        return $model;
    }

    public function getFindlevel()
    {
        $model = Job::findOne($this->id);
        $data = [];
        if (!empty($model->level))
        {
            foreach ($model->level as $value)
            {
                $level = Level::findOne($value);
                $data[] = ['id' => $level->id, 'name' => $level->name];
            }
        }
        return $data;
    }

    public function getBudget()
    {
        return $this->hasOne(BudgetPrice::className(), ['_id' => 'budget_type']);
    }

    public function getBid()
    {
        $model = Bid::find()->where(['job_id' => (string) $this->_id])->all();
        return $model;
    }

    public function getLikeexits()
    {
        $model = PersonalStorage::find()->where(['job_id' => (string) $this->_id, 'user_id' => (string) \Yii::$app->user->identity->id])->one();
        return $model;
    }

    public function getAssignment()
    {
        $model = Assignment::find()->where(['job_id' => (string) $this->_id])->one();
        return $model;
    }

    public static function getBidexits($id)
    {
        $model = Bid::find()->where(['job_id' => (string) $id, 'actor' => (string) \Yii::$app->user->identity->id])->one();
        return $model;
    }

    public static function getCategorybyid($id)
    {
        return $id;
    }

    public function getCategoryList()
    {
        $models = Category::find()->all();
        $data = [];
        if ($models)
        {
            foreach ($models as $value)
            {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

    public function getSectorList()
    {
        $models = Sectors::find()->where(['category_id' => $this->category_id])->all();
        $data = [];
        if ($models)
        {
            foreach ($models as $value)
            {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

    public function getLevels()
    {
        $model = Level::find()->all();
        $job = Job::findOne($this->id);
        $data = [];
        foreach ($model as $value)
        {
            if (!empty($job->level) && in_array($value->id, $job->level))
                $checked = 1;
            else
                $checked = 0;
            $data[] = ['id' => $value->id, 'name' => $value->name, 'icon' => $value->icon, 'checked' => $checked];
        }
        return $data;
    }

    public static function getLevelname($id)
    {
        $model = Level::findOne($id);
        return $model->name;
    }

    public function getFindbudgetPacket()
    {
        return $this->hasOne(BudgetPacket::className(), ['_id' => 'project_type']);
    }

    public function getProjecttype()
    {
        return[
            1 => 'Làm việc theo giờ',
            2 => 'Làm việc theo gói'
        ];
    }

    public function getBudgetpacket()
    {
        $sector = Sectors::findOne($this->sector_id);
        $packet = BudgetPacket::find()->where([])->one();
        $models = BudgetPrice::find(['bg_id' => $packet->id])->all();
        $data[0] = 'Null';
        if ($models)
        {
            foreach ($models as $value)
            {
                $data[(string) $value['_id']] = 'Từ ' . number_format($value->min, 0, '', '.') . ' đến ' . number_format($value->max, 0, '', '.');
            }
        }
        return $data;
    }

    public function getCity()
    {
        return City::find()->all();
    }

    public function getWork()
    {
        return[
            self::WORK_HOURS => 'Làm việc theo giờ',
            self::WORK_PACKAGE => 'Làm việc theo gói'
        ];
    }

    public function getFeatureds()
    {
        return[
            self::FEATURED_CLOSE => 'Đóng',
            self::FEATURED_OPEN => 'Mở'
        ];
    }

    public function getWorklocation()
    {
        return[
            1 => 'Toàn quốc',
            2 => 'Địa điểm cụ thể'
        ];
    }

    public function getCityList()
    {
        $models = City::find()->all();
        $data = [];
        if ($models)
        {
            foreach ($models as $value)
            {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

    public function getDistrictList()
    {
        $models = District::find()->where(['city_id' => $this->city_id])->all();
        $data = [];
        if ($models)
        {
            foreach ($models as $value)
            {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        return $data;
    }

    public function getLocal()
    {
        return $this->hasOne(District::className(), ['_id' => 'district_id']);
    }

    public static function findUser($id)
    {
        return User::findOne((string) $id);
    }

    public static function getStatus($id)
    {
        $model = Job::findOne($id);
        if ($model->block == (string) Job::JOB_BLOCK)
        {
            $status = '<span class="label label-danger">Việc đã khóa</span>';
        }
        else
        {
            //check publish
            if ($model->publish == (string) Job::PUBLISH_ACTIVE)
            {
                //check asignment
                $asign = $model->assignment;
                if (!empty($asign))
                {
                    switch ($asign->status_boss)
                    {
                        case (string) Assignment::STATUS_GIVE:
                            $status = '<span class="label label-info">Chờ đặt cọc</span>';
                            break;
                        case (string) Assignment::STATUS_DEPOSIT:
                            $status = '<span class="label label-blue-green">Cam kết làm việc</span>';
                            break;
                        case (string) Assignment::STATUS_COMMITMENT:
                            $status = '<span class="label label-green">Làm việc</span>';
                            break;
                        case (string) Assignment::STATUS_REQUEST:
                            $status = '<span class="label label-warning">Hoàn thành</span>';
                            break;
                        case (string) Assignment::STATUS_PAYMENT:
                            $status = '<span class="label label-red-orange">Thanh toán</span>';
                            break;
                        case (string) Assignment::STATUS_COMPLETE:
                            $status = '<span class="label label-yellow-green">Công việc hoàn thành</span>';
                            break;
                        case (string) Assignment::STATUS_REVIEW:
                            $status = '<span class="label label-yellow-green">Công việc hoàn thành</span>';
                            break;
                    }
                }
                else
                {
                    if ($model->deadline < time())
                    {
                        $status = '<span class="label label-warning">Hết hạn book</span>';
                    }
                    else
                    {
                        $status = '<span class="label label-success">Việc mới</span>';
                    }
                }
            }
            else
            {
                switch ($model->publish)
                {
                    case (string) Job::PUBLISH_NOACTIVE:
                        $status = '<span class="label label-primary">Đang chờ duyệt</span>';
                        break;
                    case (string) Job::PUBLISH_VIEW:
                        $status = '<span class="label label-info">Lưu nháp</span>';
                        break;
                    case (string) Job::PUBLISH_CLOSE:
                        $status = '<span class="label label-default">Việc đã ẩn</span>';
                        break;
                }
            }
        }
        return $status;
    }

}
