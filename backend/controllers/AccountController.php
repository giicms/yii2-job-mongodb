<?php

namespace backend\controllers;

use Yii;
use common\models\Account;
use common\models\AuthAssignment;
use backend\models\Profile;
use backend\models\SignUp;
use common\models\UserGroup;
use backend\models\ChangePassword;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\components\GoogleAuthenticator;
use backend\controllers\BackendController;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends BackendController
{

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->canUser();
        if (\Yii::$app->user->identity->level == UserGroup::USERGROUP_SUPER or \Yii::$app->user->identity->level == UserGroup::USERGROUP_ADMIN)
            $query = Account::find()->where(['NOT IN', '_id', \Yii::$app->user->id]);
        else
            $query = Account::find()->where(['group' => \Yii::$app->user->identity->group])->andWhere(['NOT IN', '_id', \Yii::$app->user->id]);
        if (!empty($_GET['key']))
        {
            $query->andWhere(['LIKE', 'name', $_GET['key']])
                    ->orWhere(['LIKE', 'username', $_GET['key']])
                    ->orWhere(['LIKE', 'email', $_GET['key']])
                    ->orWhere(['LIKE', 'address', $_GET['key']])
                    ->orWhere(['phone' => $_GET['key']]);
        }
        elseif (!empty($_GET['status']))
        {
            $query->andWhere(['status' => (int) $_GET['status']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        Yii::$app->session->setFlash('city', !empty($_GET['page']) ? $_GET['page'] : NULL);
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Account model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->canUser();
        $auth = Yii::$app->getAuthManager();
        $owners = $auth->getAssignments(Yii::$app->user->id);
        $actors = $auth->getAssignments($id);
        $avaliable = $assigned = [
            'Permission' => [],
            'Routes' => [],
        ];
        foreach ($owners as $key => $value)
        {
            $children = array_keys($auth->getChildren($value->roleName));
            $children[] = $value->roleName;
            foreach ($auth->getChildren($value->roleName) as $name => $child)
            {
                $avaliable[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
            }
        }

        foreach ($actors as $key => $value)
        {
            $children = array_keys($auth->getChildren($value->roleName));
            $children[] = $value->roleName;
            foreach ($auth->getChildren($value->roleName) as $name => $child)
            {
                $assigned[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
            }
        }

        $avaliable = array_filter($avaliable);
        $assigned = array_filter($assigned);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'avaliable' => $avaliable,
                    'assigned' => $assigned,
                    'ga' => new GoogleAuthenticator()
        ]);
    }

    /**
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->canUser();
        $model = new SignUp();
        $auth = Yii::$app->getAuthManager();
        if ($model->load(Yii::$app->request->post()))
        {

            if ($model->validate())
            {
                $account = new Account();
                $account->name = $model->name;
                $account->username = $model->username;
                $account->phone = $model->phone;
                $account->address = $model->address;
                $account->email = $model->email;
                $account->secret = $model->secret;
                $account->category = $model->category;
                $account->level = 2;
                $account->created_at = $account->updated_at = time();
                $account->setPassword($model->password);
                $account->generateAuthKey();
                if ($account->save())
                {
                    foreach ($model->role as $value)
                    {
                        $parentRole = $auth->getRole($value);
                        if (!empty($parentRole))
                            $parent = $parentRole;
                        else
                            $parent = $auth->getPermission($value);
                        $auth->assign($parent, $account->id);
                    }
                    return $this->redirect(['view', 'id' => $account->id]);
                }
            }
        }
        $data = [];

        foreach ($auth->getRoles() as $name => $role)
        {
            $data[$name] = !empty($role->description) ? $role->description : $name;
        }
        foreach ($auth->getPermissions() as $name => $permission)
        {
            if ($name[0] !== '/')
                $data[$name] = !empty($permission->description) ? $permission->description : $name;
        }

        return $this->render('create', [
                    'model' => $model,
                    'child' => $data,
                    'ga' => new GoogleAuthenticator()
        ]);
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->canUser();
        $model = new Profile(['id' => $id]);
        $profile = $this->findModel($id);
        $ga = new GoogleAuthenticator();
        $auth = Yii::$app->authManager;
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $auth->revokeAll($profile->_id);
                $profile->name = $model->name;
                $profile->username = $model->username;
                $profile->phone = $model->phone;
                $profile->address = $model->address;
                $profile->email = $model->email;
                $profile->secret = $model->secret;
                $profile->category = $model->category;
                if (!empty($model->avatar))
                    $profile->avatar = $model->avatar;
                $profile->updated_at = time();
                if ($profile->save())
                {
                    foreach ($model->role as $value)
                    {
                        $parentRole = $auth->getRole($value);
                        if (!empty($parentRole))
                            $parent = $parentRole;
                        else
                            $parent = $auth->getPermission($value);
                        $auth->assign($parent, $profile->id);
                    }

//                    if (!empty($_POST['childs']))
//                    {
//                        foreach ($_POST['childs'] as $role)
//                        {
//                            $child = $auth->getPermission($role);
//                            $auth->assign($child, $profile->_id);
//                        }
//                    }
//                    else
//                    {
//                        $auth->assign($parent, $profile->_id);
//                    }
                    if ((string) Yii::$app->user->identity->id == $id)
                        return $this->redirect(['profile']);
                    else
                        return $this->redirect(['view', 'id' => $id]);
                }
            }
        }
        $data = [];

        foreach ($auth->getRoles() as $name => $role)
        {
            $data[$name] = !empty($role->description) ? $role->description : $name;
        }
        foreach ($auth->getPermissions() as $name => $permission)
        {
            if ($name[0] !== '/')
                $data[$name] = !empty($permission->description) ? $permission->description : $name;
        }

        return $this->render('update', [
                    'model' => $model,
                    'profile' => $profile,
                    'childs' => $data,
                    'ga' => $ga
        ]);
    }

    public function actionStatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($_POST['id']);
        if (!empty($model))
        {
            if ($model->status == Account::STATUS_ACTIVE)
                $model->status = Account::STATUS_NOACTIVE;
            else
                $model->status = Account::STATUS_ACTIVE;
            if ($model->save())
            {
                return ['messages' => $model->status];
            }
        }
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->canUser();
        $ids = explode(',', $id);
        foreach ($ids as $value)
        {
            $this->findModel($value)->delete();
        }
        $this->request('account');
    }

    public function actionProfile()
    {
        $ga = new GoogleAuthenticator();
        $model = Account::findOne(\Yii::$app->user->identity->id);
        return $this->render('profile', ['model' => $model, 'ga' => $ga]);
    }

    public function actionChangeprofile()
    {
        $model = new Profile();
        $profile = $this->findModel(\Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post()))
        {
            $profile->name = $model->name;
            $profile->username = $model->username;
            $profile->phone = $model->phone;
            $profile->address = $model->address;
            $profile->email = $model->email;
            $profile->role = $model->role;
            $profile->secret = $model->secret;
            if (!empty($model->avatar))
                $profile->avatar = $model->avatar;
            $profile->updated_at = time();
            if ($profile->save())
            {
                return $this->redirect(['profile']);
            }
        }
        else
        {
            return $this->render('changeprofile', [
                        'model' => $model,
                        'profile' => $profile,
                        'ga' => new GoogleAuthenticator()
            ]);
        }
    }

    public function actionChangepassword($id)
    {
        $this->canUser();
        $account = Account::findOne($id);
        $model = new ChangePassword();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $account->setPassword($model->password_new);
                $account->generateAuthKey();
                if ($account->save())
                    Yii::$app->session->setFlash('success', 'Bạn đã thay đổi mật khẩu thành công.');
            }
        }
        return $this->render('changepassword', ['model' => $model, 'account' => $account]);
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
