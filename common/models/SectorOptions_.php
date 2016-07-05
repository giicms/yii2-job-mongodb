<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Category;
use common\models\Skills;

/**
 * Boss model
 *
 * @property string $category_id
 * @property string $name
 */
class SectorOptions extends ActiveRecord
{

    public $num;

    const PUBLISH_NO = 1;
    const PUBLISH_YES = 2;

    public static function collectionName()
    {
        return 'job_sector_options';
    }

    public function rules()
    {
        return [
            [['name', 'options'], 'required', 'message' => '{attribute} không được rỗng'],
            ['publish', 'default', 'value' => self::PUBLISH_YES],
            [['num', 'type', 'publish'], 'integer']
        ];
    }

    public function attributes()
    {
        return [
            '_id',
            'name',
            'category_id',
            'sector_id',
            'options',
            'type',
            'num',
            'publish'
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Tên option',
            'options' => 'Những loại',
            'category_id' => 'Danh mục',
            'sector_id' => 'Lĩnh vực'
        ];
    }

    public function validateOptions($attribute)
    {
        if (!$this->hasErrors())
        {
            foreach ($this->options as $value)
                if (!$value)
                    $this->addError($attribute, 'Những options không được rỗng.');
        }
    }

    public function getId()
    {
        return (string) $this->_id;
    }

    public function getSector()
    {
        return $this->hasOne(Sectors::className(), ['_id' => 'sector_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Sectors::className(), ['_id' => 'category_id']);
    }

    public function getCategories()
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

    public function getSectors()
    {
        $sectors = Sectors::find()->where(['category_id' => $this->category_id])->all();
        $model = SectorOptions::findOne($this->id);
        $data = [];
        if (!empty($model))
        {
            foreach ($sectors as $value)
            {
                $data[$value->id] = $value->name;
            }
        }
        return $data;
    }

    public function getOption()
    {
        return [
            'PHP' => 'PHP',
            '1 - 5 trang' => '1 - 5 trang'
        ];
    }

}
