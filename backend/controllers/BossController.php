<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use common\models\Level;
use common\models\Category;
use common\models\Sectors;
use common\models\City;
use common\models\Bid;
use common\models\Assignment;
use common\models\District;
use common\models\Job;
use common\models\Messages;
use common\models\UserBid;
use frontend\models\Boss;
use frontend\models\BossInfo;
use backend\controllers\BackendController;

/**
 * BossController implements the CRUD actions for User model.
 */
class BossController extends BackendController
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->canUser();
        $query = User::find();
        $query->where(['role' => User::ROLE_BOSS])->orderBy(['created_at'=>SORT_DESC,'updated_at'=>SORT_DESC]);
        if (!empty($_GET['step']))
        {
            $query->andWhere(['NOT IN', 'step', 5]);
        }
        if (!empty($_GET['key']))
        {
            $query->andWhere(['LIKE', 'name', $_GET['key']])
                    ->orWhere(['LIKE', 'slug', $_GET['key']])
                    ->orWhere(['LIKE', 'slugname', $_GET['key']])
                    ->orWhere(['LIKE', 'email', $_GET['key']])
                    ->orWhere(['LIKE', 'address', $_GET['key']])
                    ->orWhere(['phone' => $_GET['key']])
                    ->andWhere(['role' => User::ROLE_BOSS]);
        }
        elseif (!empty($_GET['city']))
        {
            $query->andWhere(['city' => $_GET['city']]);
        }
        elseif (!empty($_GET['status']))
        {
            $query->andWhere(['status' => (int) $_GET['status']]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $city = City::find()->all();
        Yii::$app->session->setFlash('boss', !empty($_GET['page']) ? $_GET['page'] : NULL);
        return $this->render('index', [
                    'dataProvider' => $dataProvider, 'city' => $city
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->canUser();
        $model = $this->findModel($id);
        $messages = Messages::find()->where(['owner' => $id])->orWhere(['actor' => $id])->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
        $project = Job::find()->where(['owner' => $id])->all();
        $pending = Job::find()->where(['owner' => $id, 'status' => Job::PROJECT_PENDING])->all();
        $progress = Job::find()->where(['owner' => $id, 'status' => Job::PROJECT_DEPOSIT])->all();
        $completed = Job::find()->where(['owner' => $id, 'status' => Job::PROJECT_COMPLETED])->all();
        $user = UserBid::find()->where(['owner_id' => $id])->all();
        return $this->render('view', ['model' => $model, 'project' => $project, 'pending' => $pending, 'progress' => $progress, 'completed' => $completed, 'messages' => $messages, 'user' => $user]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->canUser();
        $model = new Boss();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $user = new User();
                $user->name = $model->name;
                $user->slug = $user->getUsername($model->name)['slug'];
                $user->slugname = str_replace("-", " ", Yii::$app->convert->string($model->name));
                $user->serial = $user->getUsername($model->name)['serial'];
                $user->phone = $model->phone;
                $user->email = $model->email;
                $user->questions = $model->questions;
                $user->email_active = $model->email_active;
                $user->boss_type = $model->boss_type;
                if ($model->boss_type == 1)
                {
                    $user->company_name = $model->company_name;
                    $user->company_code = $model->company_code;
                }
                $user->address = $model->address;
                $user->city = $model->city;
                $user->district = $model->district;
                $user->created_at = $user->updated_at = time();
                $user->role = User::ROLE_BOSS;
                $user->setPassword($model->password);
                $user->generateAuthKey();

                if ($user->save())
                {
                    Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom([Yii::$app->params['adminEmail'] => 'Giao nhận việc'])
                            ->setSubject('Xác nhận tài khoản')
                            ->setTextBody('Chúc mừng bạn đăng ký thành công, các bạn click vào link này để kích hoạt tài khoản: http://giaonhanviec.com/boss/account?email=' . $user->email . '&auth_key=' . $user->auth_key)
                            ->send();
                    return $this->redirect(['view', 'id' => $user->id]);
                }
            }
        }
        else
        {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->canUser();
        $user = $this->findModel($id);
        $model = new BossInfo();
        $district = District::find()->where(['city_id' => $user->city])->all();
        $data = [];
        if ($district)
        {
            foreach ($district as $value)
            {
                $data[(string) $value['_id']] = $value['name'];
            }
        }
        $model->city = $user->city;
        $model->district = $user->district;
        $model->avatar = $user->avatar;
        $model->birthday = $user->birthday;
        $model->phone = $user->phone;
        $model->description = $user->description;

        if ($model->load(Yii::$app->request->post()))
        {
            $user->name = $model->name;
            $user->email = $model->email;
            $user->phone = $model->phone;
            $user->address = $model->address;
            $user->city = $model->city;
            $user->district = $model->district;
            if ($user->save())
                return $this->redirect(['view', 'id' => $id]);
        } else
        {
            return $this->render('update', [
                        'user' => $user,
                        'model' => $model,
                        'district' => $data
            ]);
        }
    }

    /**
     * Block an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionBlock()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if (!empty($model))
        {
            if ($model->publish == User::PUBLISH_ACTIVE)
                $model->publish = User::PUBLISH_BLOCK;
            else
                $model->publish = User::PUBLISH_ACTIVE;
            if ($model->save())
            {
                return ['messages' => 'ok'];
            }
        }
    }

    public function actionCloseall()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids']))
        {
            foreach ($_POST['ids'] as $value)
            {
                $model = $this->findModel($value);
                $model->publish = User::PUBLISH_BLOCK;
                $model->save();
            }
            return ['ok'];
        }
    }

    public function actionOpenall()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids']))
        {
            foreach ($_POST['ids'] as $value)
            {
                $model = $this->findModel($value);
                $model->publish = User::PUBLISH_ACTIVE;
                $model->save();
            }
            return ['ok'];
        }
    }

    /**
     * Browse an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionBrowse($id)
    {
        $model = $this->findModel($id);
        if (!empty($model))
        {
            $model->step = 5;
            if ($model->save())
            {
                return $this->redirect(['view', 'id' => $id]);
            }
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSector()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Sectors::find()->where(['category_id' => $_POST['id']])->all();
        if (!empty($model))
        {
            foreach ($model as $value)
            {
                $data[] = ['id' => (string) $value['_id'], 'name' => $value['name']];
            }
            return $data;
        }
    }

    public function actionDistrict()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = District::find()->where(['city_id' => $_POST['id_city']])->all();
        $data = [];
        if (!empty($model))
        {
            foreach ($model as $value)
            {
                $data[] = ['id' => (string) $value->_id, 'name' => $value->name];
            }
        }
        else
        {
            $data[0] = ['id' => 0, 'name' => 'đang cập nhật  '];
        }
        return $data;
    }

    public function actionExport()
    {
        $time = date('d-m-y', time());
        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header("Content-Disposition: attachment; filename=dstv-" . $time . ".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['role' => User::ROLE_BOSS]),
        ]);
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Tên', 'email'));
        $model = User::find()->where(['role' => User::ROLE_BOSS])->all();
        $array = [];
        foreach ($model as $key => $value)
        {
            $array['Tên'] = $value->name;
            $array['Email'] = $value->email;
            fputcsv($output, $array);
        }
//        echo GridView::widget([
//            'dataProvider' => $dataProvider,
//            'summary' => false,
//            'columns' => [
//                ['class' => 'yii\grid\SerialColumn'],
//                'name',
//                'email'
//            ],
//        ]);
    }

}
