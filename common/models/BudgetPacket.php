<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Category;
use common\models\BudgetPrice;

/**
 * BudgetPacket model
 *
 * @property string $name
 */
class BudgetPacket extends ActiveRecord
{

    const PUBLISH_NOACTIVE = 0;
    const PUBLISH_ACTIVE = 1;

    public static function collectionName()
    {
        return 'budget_packets';
    }

    public function rules()
    {
        return [
            [['category_id', 'sectors', 'options'], 'required', 'message' => '{attribute} không được rỗng'],
            ['sector_id', 'unique', 'targetAttribute' => 'sector_id', 'message' => '{attribute} này đã tồn tại!'],
            [['description'], 'string'],
            ['sectors', 'validateSectors']
        ];
    }

    public function attributes()
    {
        return [
            '_id',
            'category_id',
            'sector_id',
            'sectors',
            'description',
            'publish',
            'options'
        ];
    }

    public function attributeLabels()
    {
        return [
            'category_id' => 'Danh mục',
            'sectors' => 'Lĩnh vực',
            'description' => 'Mô tả',
            'options' => 'Gói',
            'publish' => 'Trạng thái'
        ];
    }

    public function validateSectors($attribute)
    {
        if (!$this->hasErrors())
        {
            $model = BudgetPacket::find()->where(['IN', 'sectors', $this->sectors])->all();

            if (empty($this->id) && !empty($model))
            {
                $this->addError($attribute, 'Một hay vài lĩnh vực này đã có gói trong hệ thống');
            }
        }
    }

    public function getId()
    {
        return (string) $this->_id;
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['_id' => 'category_id']);
    }

    public function getSector($id)
    {
        return Sectors::findOne($id);
    }

    public function getCategories()
    {
        $models = Category::find()->all();
        $data = [];
        if ($models)
        {
            foreach ($models as $value)
            {
                $data[$value->id] = $value->name;
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
                $data[$value->id] = $value['name'];
            }
        }
        return $data;
    }

    public function getBudgetPrice()
    {
        return BudgetPrice::find()->where(['bg_id' => $this->id])->orderBy(['order' => SORT_ASC])->all();
    }

}
