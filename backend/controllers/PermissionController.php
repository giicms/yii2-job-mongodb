<?php

namespace backend\controllers;

use Yii;
use common\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\rbac\Item;
use common\models\AuthItemChild;
use backend\controllers\BackendController;

/**
 * PermissionController implements the CRUD actions for AuthItem model.
 */
class PermissionController extends BackendController
{

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $this->canUser();
        $authManager = Yii::$app->authManager;
        $items = [];
        $auth = $authManager->getPermissions();

        foreach ($auth as $name => $value)
        {
            if ($name[0] != '/')
                $items[$name] = ['name' => $name, 'parent' => $value->parent, 'description' => $value->description];
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $items,
            'sort' => [
                'attributes' => [
                    'name', 'description'
                ],
                'defaultOrder' => [
                    'name' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        Yii::$app->session->setFlash('permission', !empty($_GET['page']) ? $_GET['page'] : NULL);
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
//        $this->canUser();
        $model = new AuthItem(null);
        $model->type = Item::TYPE_PERMISSION;
        if ($model->load(Yii::$app->getRequest()->post()))
        {
            $model->save();
            Yii::$app->session->setFlash('success', ' Đã thực hiện thành công!');
            $model = new AuthItem(null);
        }
        return $this->render('create', ['model' => $model, 'parent' => $this->parentPermission()]);
    }

    public function actionView($id)
    {
//        $this->canUser();
        $model = $this->findModel($id);
        $authManager = Yii::$app->getAuthManager();
        $avaliable = $assigned = [
            'Permission' => [],
            'Routes' => [],
        ];
        $children = array_keys($authManager->getChildren($id));
        $children[] = $id;
        foreach ($authManager->getPermissions() as $name => $role)
        {
            if (in_array($name, $children))
            {
                continue;
            }
            $avaliable[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = !empty($role->description) ? $role->description : $name;
        }
        foreach ($authManager->getChildren($id) as $name => $child)
        {
            $assigned[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = !empty($child->description) ? $child->description : $name;
        }

        $avaliable = array_filter($avaliable);
        $assigned = array_filter($assigned);

        return $this->render('view', ['model' => $model, 'avaliable' => $avaliable, 'assigned' => $assigned]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->canUser();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()))
        {
            $model->save();
            $this->request('permission');
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        $this->canUser();
        $model = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($model->item);
        $this->request('permission');
    }

    /**
     * Assign or remove items
     * @param string $id
     * @param string $action
     * @return array
     */
    public function actionAssign($id, $action)
    {
        $post = Yii::$app->getRequest()->post();
        $roles = $post['roles'];
        $manager = Yii::$app->getAuthManager();
        $parent = $manager->getPermission($id);
        $error = [];
        if ($action == 'assign')
        {
            foreach ($roles as $role)
            {
                $child = $manager->getPermission($role);
                try
                {
                    $manager->addChild($parent, $child);
                }
                catch (\Exception $exc)
                {
                    $error[] = $exc->getMessage();
                }
            }
        }
        else
        {
            foreach ($roles as $role)
            {
                $child = $manager->getPermission($role);
                try
                {
                    $manager->removeChild($parent, $child);
                }
                catch (\Exception $exc)
                {
                    $error[] = $exc->getMessage();
                }
            }
        }
//        MenuHelper::invalidate();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [$this->actionRoleSearch($id, 'avaliable'), $this->actionRoleSearch($id, 'assigned'), $error];
    }

    /**
     * Search role
     * @param string $id
     * @param string $target
     * @param string $term
     * @return array
     */
    public function actionRoleSearch($id, $target, $term = '')
    {
        $result = [
            'Roles' => [],
            'Permission' => [],
            'Routes' => [],
        ];
        $authManager = Yii::$app->authManager;
        if ($target == 'avaliable')
        {
            $children = array_keys($authManager->getChildren($id));
            $children[] = $id;
            foreach ($authManager->getRoles() as $name => $role)
            {
                if (in_array($name, $children))
                {
                    continue;
                }
                if (empty($term) or strpos($name, $term) !== false)
                {
                    $result['Roles'][$name] = !empty($role->description) ? $role->description : $name;
                }
            }
            foreach ($authManager->getPermissions() as $name => $role)
            {
                if (in_array($name, $children))
                {
                    continue;
                }
                if (empty($term) or strpos($name, $term) !== false)
                {
                    $result[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = !empty($role->description) ? $role->description : $name;
                }
            }
        }
        else
        {
            foreach ($authManager->getChildren($id) as $name => $child)
            {
                if (empty($term) or strpos($name, $term) !== false)
                {
                    if ($child->type == Item::TYPE_ROLE)
                    {
                        $result['Roles'][$name] = $name;
                    }
                    else
                    {
                        $result[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = !empty($child->description) ? $child->description : $name;
                    }
                }
            }
        }

        return Html::renderSelectOptions('', array_filter($result));
    }

    protected function parentPermission()
    {
        $authManager = Yii::$app->authManager;
        $data['null'] = 'Chon parent';
        foreach ($authManager->getPermissions() as $name => $role)
        {
            $data[$name] = $name;
        }
        return $data;
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $item = Yii::$app->authManager->getPermission($id);
        if ($item)
        {
            return new AuthItem($item);
        }
        else
        {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
