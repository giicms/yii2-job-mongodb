<?php

namespace backend\modules\auth\controllers;

use backend\modules\auth\controllers\ItemController;
use yii\rbac\Item;


class PermissionController extends ItemController {

    /**
     * @inheritdoc
     */
    public function labels() {
        return[
            'Item' => 'Permission',
            'Items' => 'Permissions',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType() {
        return Item::TYPE_PERMISSION;
    }

}
