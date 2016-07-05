<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\BudgetPacket;

/**
 * BudgetPacket model
 *
 * @property string $name
 */
class BudgetPrice extends ActiveRecord
{

    const PUBLISH_NOACTIVE = 0;
    const PUBLISH_ACTIVE = 1;

    public static function collectionName()
    {
        return 'budget_price';
    }

    public function rules()
    {
        return [
            [['bg_id', 'sector_id'], 'string'],
            [['min', 'max', 'order'], 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            '_id',
            'name',
            'bg_id',
            'sector_id',
            'optons',
            'min',
            'max',
            'publish',
            'order'
        ];
    }

    public function attributeLabels()
    {
        return [
            'max' => 'Giá cao nhất',
            'min' => 'Giá thấp nhất',
        ];
    }

    public function getId()
    {
        return (string) $this->_id;
    }

    public function getBudgetPacket()
    {
        return $this->hasOne(BudgetPacket::className(), ['_id' => 'bg_id']);
    }

}
