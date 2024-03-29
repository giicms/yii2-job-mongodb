<?php

namespace backend\modules\auth\controllers;

use Yii;
use backend\modules\auth\models\User;
use backend\modules\auth\models\AuthItem;
use backend\modules\auth\models\searchs\AuthItem as AuthItemSearch;
use backend\modules\auth\components\Helper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\NotSupportedException;
use yii\filters\VerbFilter;
use yii\rbac\Item;
use yii\data\ArrayDataProvider;

class ItemController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $authManager = Yii::$app->authManager;
        var_dump($authManager->getPermissionsByUser(\Yii::$app->user->id));
        exit();
        if ($this->type == Item::TYPE_ROLE)
            $items = $authManager->getRoles();
        else
            $items = $authManager->getPermission(\Yii::$app->user->identity->role);
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
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param  string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $manager = Yii::$app->getAuthManager();
        $model = $this->findModel($id);
        $user_id = $manager->getRolesByUser($id);
        return $this->render('view', ['model' => $model, 'items' => $this->getItems($id), 'user_id' => $user_id]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem(null);
        $model->type = $this->type;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save())
        {
            Helper::invalidate();

            return $this->redirect(['view', 'id' => $model->name]);
        }
        else
        {
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save())
        {
            Helper::invalidate();

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($model->item);
        Helper::invalidate();

        return $this->redirect(['index']);
    }

    /**
     * Assign or remove items
     * @param string $id
     * @param string $action
     * @return array
     */
    public function actionAssign($id)
    {
        $post = Yii::$app->getRequest()->post();
        $action = $post['action'];
        $items = $post['items'];
        $manager = Yii::$app->getAuthManager();
        $parent = $this->type === Item::TYPE_ROLE ? $manager->getRole($id) : $manager->getPermission($id);

        $error = [];
        if ($action == 'assign')
        {
            foreach ($items as $name)
            {
                $child = $manager->getPermission($name);
                if ($this->type === Item::TYPE_ROLE && $child === null)
                {
                    $child = $manager->getRole($name);
                }
                try
                {
                    $manager->addChild($parent, $child);
                }
                catch (\Exception $e)
                {
                    $error[] = $e->getMessage();
                }
            }
        }
        else
        {
            foreach ($items as $name)
            {
                $child = $manager->getPermission($name);
                if ($this->type === Item::TYPE_ROLE && $child === null)
                {
                    $child = $manager->getRole($name);
                }
                try
                {
                    $manager->removeChild($parent, $child);
                }
                catch (\Exception $e)
                {
                    $error[] = $e->getMessage();
                }
            }
        }
        Helper::invalidate();
        Yii::$app->getResponse()->format = 'json';
        return $this->getItems($id);
    }

    /**
     * 
     * @param string $id
     * @return array
     */
    protected function getItems($id)
    {
        $manager = Yii::$app->getAuthManager();
        $avaliable = [];
        if ($this->type === Item::TYPE_ROLE)
        {
            foreach (array_keys(\Yii::$app->user->identity->role == "superadmin" ? $manager->getRoles() : $manager->getRole(\Yii::$app->user->identity->role)) as $name)
            {
                $avaliable[$name] = 'role';
            }
        }
        foreach (array_keys(\Yii::$app->user->identity->role == "superadmin" ? $manager->getPermissions() : $manager->getPermission(\Yii::$app->user->identity->role)) as $name)
        {
            $avaliable[$name] = $name[0] == '/' ? 'route' : 'permission';
        }
        $assigned = [];
        foreach ($manager->getChildren($id) as $item)
        {
            $assigned[$item->name] = $item->type == 1 ? 'role' : ($item->name[0] == '/' ? 'route' : 'permission');
            unset($avaliable[$item->name]);
        }
        unset($avaliable[$id]);
        return[
            'avaliable' => $avaliable,
            'assigned' => $assigned
        ];
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'item';
    }

    /**
     * Label use in view
     * @return array
     */
    public function labels()
    {
        throw new NotSupportedException(get_class($this) . ' does not support labels().');
    }

    /**
     * Type of Auth Item.
     * @return integer
     */
    public function getType()
    {
        
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $auth = Yii::$app->getAuthManager();
        $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);
        if ($item)
        {
            return new AuthItem($item);
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
