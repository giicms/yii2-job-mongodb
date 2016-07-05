<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Level;
use common\models\Category;
use common\models\Sectors;
use common\models\City;
use common\models\Bid;
use common\models\Assignment;
use common\models\District;
use common\models\Messages;
use common\models\UserBid;
use frontend\models\Membership;
use frontend\models\MembershipInfo;
use backend\controllers\BackendController;

/**
 * BookuserController implements the CRUD actions for User model.
 */
class BookuserController extends BackendController {

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
//        $this->canUser();
        $sector = [];
        $query = UserBid::find();
        if (!empty($_GET['key'])) {
            $user = User::find()->where(['LIKE', 'slugname', $_GET['key']])->orWhere(['LIKE', 'slug', $_GET['key']])->orWhere(['LIKE', 'name', $_GET['key']])->all();
            $result = ArrayHelper::getColumn($user, 'id');
            $query->where(['IN', 'owner_id', $result])->orWhere(['IN', 'actor_id', $result]);
        } elseif (!empty($_GET['status'])) {
            $query->andWhere(['status' => (int) $_GET['status']]);
        } elseif (!empty($_GET['datefrom'])) {
            $to = strtotime($_GET['dateto']) + 86400;
            $from = strtotime($_GET['datefrom']) - 86400;
            $query->andWhere(['between', 'created_at', $from, $to]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', [
                    'dataProvider' => $dataProvider
        ]);
    }

}
