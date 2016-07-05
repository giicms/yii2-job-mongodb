<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
 * MemberController implements the CRUD actions for User model.
 */
class MemberController extends BackendController
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->canUser();
        $sector = [];
        $query = User::find();
        $query->where(['role' => User::ROLE_MEMBER])->orderBy(['created_at' => SORT_DESC, 'updated_at' => SORT_DESC]);
        if (!empty($_GET['step']))
        {
            $query->andWhere(['NOT IN', 'step', 5]);
        }
        if (\Yii::$app->user->identity->level != 1)
            $query = User::find()->where(['IN', 'category', \Yii::$app->user->identity->category]);
        if (!empty($_GET['key']))
        {
            $query->andWhere(['LIKE', 'name', $_GET['key']])
                    ->orWhere(['LIKE', 'slugname', $_GET['key']])
                    ->orWhere(['LIKE', 'slug', $_GET['key']])
                    ->orWhere(['email' => $_GET['key']])
                    ->orWhere(['phone' => $_GET['key']])
                    ->andWhere(['role' => User::ROLE_MEMBER]);
        }
        elseif (!empty($_GET['level']))
        {
            $query->andWhere(['level' => $_GET['level']]);
        }
        elseif (!empty($_GET['category']))
        {
            $query->andWhere(['category' => $_GET['category']]);
            $sector = Sectors::find()->where(['category_id' => $_GET['category']])->all();
        }
        elseif (!empty($_GET['sector']))
        {
            $query->andWhere(['sector' => $_GET['sector']]);
        }
        elseif (!empty($_GET['status']))
        {
            $query->andWhere(['status' => (int) $_GET['status']]);
        }
        elseif (!empty($_GET['city']))
        {
            $query->andWhere(['city' => $_GET['city']]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => [
//                'pageSize' => 1,
//            ],
        ]);
        $level = Level::find()->all();
        $category = Category::find()->all();

        $city = City::find()->all();
        if (!empty($_POST['selection']))
        {
            foreach ($_POST['selection'] as $value)
            {
                $model = $this->findModel($value);
                if ($model->status == User::STATUS_ACTIVE)
                    $model->status = User::STATUS_BLOCK;
                elseif ($model->status == User::STATUS_BLOCK)
                    $model->status = User::STATUS_ACTIVE;
                $model->save();
            }
            return $this->redirect(['index']);
        }
        return $this->render('index', [
                    'dataProvider' => $dataProvider, 'level' => $level, 'category' => $category, 'sector' => $sector, 'city' => $city
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
        $book = Bid::find()->where(['actor' => $id, 'status' => 0])->all();
        $assign = Assignment::find()->where(['actor' => $id, 'status_boss' => Assignment::STATUS_COMMITMENT])->all();
        $progress = Bid::find()->where(['actor' => $id, 'status' => 2])->all();
        $completed = Bid::find()->where(['actor' => $id, 'status' => 3])->all();
        $user = UserBid::find()->where(['actor_id' => $id])->all();
        return $this->render('view', ['model' => $model, 'book' => $book, 'assign' => $assign, 'progress' => $progress, 'completed' => $completed, 'messages' => $messages, 'user' => $user]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->canUser();
        $model = new Membership();
        if ($model->load(Yii::$app->request->post()))
        {
            $level = Level::find()->where(['order' => 1])->one();
            if ($model->validate())
            {
                $user = new User();
                $user->name = $model->name;
                $user->slug = $user->getUsername($model->name)['slug'];
                $user->serial = $user->getUsername($model->name)['serial'];
                $user->slugname = str_replace("-", " ", Yii::$app->convert->string($model->name));
                $user->phone = $model->phone;
                $user->email = $model->email;
                $user->category = $model->category;
                $user->sector = $model->sector;
                $user->level = (string) $level->_id;
                $user->questions = $model->questions;
                $user->email_active = $model->email_active;
                $user->created_at = $user->updated_at = time();
                $user->step = 0;
                $user->setPassword($model->password);
                $user->generateAuthKey();
                $user->role = User::ROLE_MEMBER;
                if ($user->save())
                {
                    Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom([Yii::$app->params['adminEmail'] => 'Giao nhận việc'])
                            ->setSubject('Xác nhận tài khoản')
                            ->setTextBody('Chúc mừng bạn đăng ký thành công, các bạn click vào link này để kích hoạt tài khoản: http://giaonhanviec.com/membership/account?email=' . $user->email . '&auth_key=' . $user->auth_key)
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
        $model = new MembershipInfo();
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
            $user->cmnd = $model->cmnd;
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->canUser();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
                return ['ok'];
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
            $data[0] = ['id' => 0, 'name' => 'Đang cập nhật  '];
        }
        return $data;
    }

}
