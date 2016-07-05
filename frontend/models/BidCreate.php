<?php

namespace frontend\models;

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

class BidCreate extends Bid
{

    public $id;
    public $_params;
    public $_price;

    public function __construct($params = '')
    {
        $this->_params = explode('-', $params);
    }

    public function rules()
    {
        if (!empty($this->_params) && is_array($this->_params))
            $rule = [
                ['_price'],
                'number',
                'min' => $this->_params[0],
                'tooSmall' => 'Chào giá phải nằm trong khoản từ ' . number_format($this->_params[0], 0, '', '.') . ' đến ' . number_format($this->_params[1], 0, '', '.'),
                'max' => $this->_params[1],
                'tooBig' => 'Chào giá phải nằm trong khoản từ ' . number_format($this->_params[0], 0, '', '.') . ' đến ' . number_format($this->_params[1], 0, '', '.'),
            ];
        else
            $rule = [];
        return [
            ['id', 'string'],
            [['job_id', 'actor', 'price', 'period', 'content'], 'required', 'message' => '{attribute} không được rỗng'],
            [['period'], 'number', 'integerOnly' => true, 'message' => '{attribute} chỉ được nhập số'],
            ['period', 'match', 'not' => true, 'pattern' => '/[^0-9]/', 'message' => '{attribute} không hợp lệ.'],
            ['content', 'string', 'min' => 20, 'tooShort' => 'Tin nhắn phải từ 20 ký tự trở lên!'],
            [['created_at', 'status', 'publish', 'period'], 'integer'],
            $rule
        ];
    }

}
