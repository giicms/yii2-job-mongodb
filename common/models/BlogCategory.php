<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Blog Category model
 *
 * @property string $name
 * @property string $sectors
 */
class BlogCategory extends ActiveRecord {

    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    public static function collectionName() {
        return 'category';
    }

    public function rules() {
        return [
            [['name'], 'required'],
            [['name', 'slug', 'description', 'icon', 'parent', 'alias'], 'string'],
            [['publish', 'order', 'created_at', 'updated_at'], 'integer']
        ];
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'slug',
			'alias',
            'description',
            'icon',
            'parent',
            'publish',
            'order',
            'level',
			'created_at', 
			'updated_at'
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Tên chuyên mục',
            'description' => 'Mô tả',
            'order' => 'Vị trí',
            'parent' => 'Danh mục',
            'publish' => 'Trạng thái',
        ];
    }

    public function getCategories(&$data = [], $parent = "") {
        $category = BlogCategory::find()->where(['parent' => (string) $parent, 'alias'=>'cms'])->andWhere(['NOT IN', '_id', isset($this->id) ? $this->id : ""])->all();
        foreach ($category as $key => $value) {
            $data[$value->id] = $value->getIndent($value->level) . $value->name;
            unset($category[$key]);
            $value->getCategories($data, $value->id);
        }
        return $data;
    }

    public function getCategoriesGallery(&$data = []) {
        $gallery = BlogCategory::find()->where(['parent' => '', 'alias'=>'gal'])->andWhere(['NOT IN', '_id', isset($this->id) ? $this->id : ""])->all();
        foreach ($gallery as $key => $value) {
            $data[$value->id] = $value->getIndent($value->level) . $value->name;
        }
        return $data;
    }

    public function getIndent($int) {
        if ($int > 0) {
            for ($index = 1; $index <= $int; $index++) {
                $data[] = '—';
            }
            return implode('', $data) . ' ';
        } else
            return '';
    }

    public static function getCateChild($id) {
        return static::find()->where(['parent' => (String) $id])->orderBy(['order' => SORT_DESC])->all();
    }

    public static function getPost($id) {
        return Posts::find()->where(['category_id' => (String) $id])->all();
    }

    public static function getCate($id) {
        return static::findOne($id);
    }

    public function getCategory() {
        return $this->hasOne(BlogCategory::className(), ['_id' => 'parent']);
    }

    public function getId() {
        return (string) $this->_id;
    }

}
