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
use common\models\SectorOptions;
use common\models\Job;

class JobCreate extends Job
{

    public $id;
    public $_columns;

    public function __construct($columns = [])
    {
        $this->_columns = $columns;
    }

    public function rules()
    {
        $_rules = [];
        if ($this->_columns)
        {
            foreach ($this->_columns as $value)
            {
                $_rules[] = $value['id'];
            }
        }
        return [
            [$_rules, 'required', 'message' => '{attribute} không được rỗng'],
            [['name', 'description', 'work_location','deadline', 'num_bid', 'budget_type', 'address', 'district_id', 'city_id'], 'required', 'message' => '{attribute} không được rỗng'],
            [['level'], 'required', 'message' => 'Bạn chưa chọn cấp độ nhân viên nào!'],
            ['description', 'string', 'min' => 100, 'tooShort' => 'Mô tả công việc phải từ 100 ký tự trở lên!'],
            ['featured', 'default', 'value' => self::FEATURED_CLOSE],
            [['slug', 'slugname', 'more_resquest', 'job_code', 'job_application', 'block_list', 'owner'], 'string'],
            [['file','options'], 'default'],
            [['count', 'num_bid', 'created_at', 'updated_at', 'status', 'publish', 'block'], 'integer']
        ];
    }

    public function attributes()
    {
        $array1 = [];
        if ($this->_columns)
        {
            foreach ($this->_columns as $value)
            {
                $array1[] = $value['id'];
            }
        }
        $array2 = parent::attributes();
        return array_merge($array1, $array2);
    }

    public function attributeLabels()
    {
        $array1 = \yii\helpers\ArrayHelper::map($this->_columns, 'id', 'name');
        $array2 = parent::attributeLabels();
        return array_merge($array1, $array2);
    }

    

}
