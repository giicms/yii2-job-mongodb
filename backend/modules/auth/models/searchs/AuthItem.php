<?php

namespace backend\modules\auth\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\rbac\Item;

class AuthItem extends Model {

    const TYPE_ROUTE = 101;

    public $name;
    public $type;
    public $description;
    public $ruleName;
    public $data;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'ruleName', 'description'], 'safe'],
            [['type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('rbac-admin', 'Name'),
            'item_name' => Yii::t('rbac-admin', 'Name'),
            'type' => Yii::t('rbac-admin', 'Type'),
            'description' => Yii::t('rbac-admin', 'Description'),
            'ruleName' => Yii::t('rbac-admin', 'Rule Name'),
            'data' => Yii::t('rbac-admin', 'Data'),
        ];
    }

    /**
     * Search authitem
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params) {
        /* @var \yii\rbac\Manager $authManager */
        $authManager = Yii::$app->getAuthManager();
        if ($this->type == Item::TYPE_ROLE) {
                $items = $authManager->getRoles();

        } else {
//            if (\Yii::$app->user->identity->role == 'admin') {
//                $items = array_filter($authManager->getPermissions(), function($item) {
//                    return $this->type == Item::TYPE_PERMISSION xor strncmp($item->name, '/', 1) === 0;
//                });
//            } else {
                $items = array_filter($authManager->getPermission(), function($item) {
                    return $this->type == Item::TYPE_PERMISSION xor strncmp($item->name, '/', 1) === 0;
                });
//            }
        }
        $this->load($params);
        if ($this->validate()) {
            $search = strtolower(trim($this->name));
            $desc = strtolower(trim($this->description));
            $ruleName = $this->ruleName;
            foreach ($items as $name => $item) {
                $f = (empty($search) || strpos(strtolower($item->name), $search) !== false) &&
                        (empty($desc) || strpos(strtolower($item->description), $desc) !== false) &&
                        (empty($ruleName) || $item->ruleName == $ruleName);
                if (!$f) {
                    unset($items[$name]);
                }
            }
        }

        return new ArrayDataProvider([
            'allModels' => $items,
        ]);
    }

}
