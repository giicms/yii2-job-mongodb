<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Job;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use common\models\Category;
use common\models\Sectors;
use common\models\Level;
use common\models\City;
use common\models\District;
use common\models\JobInvited;
use common\models\User;
use common\models\Messages;
use common\models\Bid;
use common\models\Assignment;
use common\models\AssignmentStep;
use common\models\Skills;
use common\models\Conversation;
use common\models\Notification;
use common\models\JobCreate;
use common\models\SectorOptions;
use common\models\BudgetPacket;

/**
 * Job controller
 */
class JobController extends FrontendController
{

    public function actionIndex()
    {
        $bid = new Bid();
        $category = Category::find()->all();
        $sector = Sectors::find()->all();
        $level = Level::find()->all();
        $city = City::find()->all();
        $query = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_PUBLISH, 'block' => Job::JOB_UNBLOCK])->andWhere(['deadline' => ['$gt' => time()]])->orderBy(['featured' => SORT_DESC, 'created_at' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20]);
        $model = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

        return $this->render('index', [
                    'model' => $model,
                    'pages' => $pages,
                    'bid' => $bid,
                    'category' => $category,
                    'sector' => $sector,
                    'level' => $level,
                    'city' => $city
        ]);
    }

    public function actionCreate()
    {
        if (\Yii::$app->user->isGuest)
            $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect($_SERVER['REQUEST_URI']));
        if (Yii::$app->user->identity->step == User::STEP_REG)
        {
            Yii::$app->session->setFlash('error', 'Bạn phải hoàn thành hồ sơ cá nhân!.');
            return $this->redirect('boss/changeinfo');
        }

        if (!empty($_GET['id']))
        {
            $options = SectorOptions::find()->where(['sector_id' => $_GET['id'], 'publish' => SectorOptions::PUBLISH_YES])->all();

            $config = [];
            if (!empty($options))
            {
                foreach ($options as $value)
                {
                    $config[] = ['id' => $value->id, 'name' => $value->name];
                }
            }
            $model = new JobCreate($config);
            $sector = Sectors::findOne($_GET['id']);
            if ($model->load(Yii::$app->request->post()))
            {
                $job = new Job();

                $data = [];
                if (!empty($options))
                {
                    foreach ($options as $value)
                    {
                        $string = str_replace('Khác', '', implode(',', $_POST['JobCreate'][$value->id]));
                        if (!empty($_POST[$value->id]))
                            $data[$value->id] = ['name' => $value->name, 'option' => trim($string, ','), 'other' => $_POST[$value->id]];
                        else
                            $data[$value->id] = ['name' => $value->name, 'option' => trim($string, ',')];
                    }
                }
                $job->options = $data;
                $job->name = $model->name;
                $job->slug = \Yii::$app->convert->string($model->name);
                $job->slugname = \Yii::$app->convert->unsigned($model->name);
                $job->category_id = $sector->category_id;
                $job->sector_id = $_GET['id'];
                if (!empty($job->file))
                    $model->file = [$job->file];
                $max = Job::find()->max('count');
                if (!empty($max))
                    $code = $max + 1;
                else
                    $code = 1;
                $job->job_code = 'MS-' . $code;
                $job->count = $code;
                $job->owner = Yii::$app->user->id;
                $job->deadline = \Yii::$app->convert->date($model->deadline);
                $job->description = $model->description;
                $job->work_location = $model->work_location;
                $job->num_bid = $model->num_bid;
                $job->level = $model->level;
                if ($model->work_location == 2)
                {
                    $job->address = $model->address;
                    $job->district_id = $model->district_id;
                    $job->city_id = $model->city_id;
                }
                if (isset($_POST['save-draft']))
                    $job->publish = Job::PUBLISH_NOACTIVE;
                elseif (isset($_POST['save-view']))
                    $job->publish = Job::PUBLISH_VIEW;
                else
                    $job->publish = Job::PUBLISH_NOACTIVE;
                $job->budget_type = $model->budget_type;
                $job->status = Job::PROJECT_PUBLISH;
                $job->block = Job::JOB_UNBLOCK;

                if ($job->save())
                {
                    if ($job->publish == Job::PUBLISH_VIEW)
                        return $this->redirect(['view', 'id' => $job->id]);
                    else
                        return $this->redirect(['active', 'id' => $job->id]);
                }
            }


            return $this->render('create', ['model' => $model, 'options' => $options, 'budget' => $this->findBudget($_GET['id']), 'sector' => $sector]);
        }
        else
        {
            $category = Category::find()->all();
            return $this->render('category', ['category' => $category]);
        }
    }

    public function actionUpdate($id)
    {

        $job = Job::findOne($id);
        $sector = Sectors::findOne($job->sector_id);
        $item = [];
        if (!empty($job->options))
        {
            foreach ($job->options as $key => $value)
            {
                $item[] = $key;
            }
        }
        $options = SectorOptions::find()->where(['IN', '_id', $item])->all();
        $config = [];
        if (!empty($options))
        {
            foreach ($options as $value)
            {
                $config[$value->id] = ['id' => $value->id, 'name' => $value->name];
            }
        }
        $model = new JobCreate($config);
        $model->id = $id;
        $model->attributes = $job->attributes;
        $data = [];
        if ($model->work_location == 2)
        {
            $district = District::find()->where(['city_id' => $model->city_id])->all();
            if ($district)
            {
                foreach ($district as $value)
                {
                    $data[(string) $value['_id']] = $value['name'];
                }
            }
        }
        if ($model->load(Yii::$app->request->post()))
        {
            $option = [];
            if (!empty($options))
            {
                foreach ($options as $value)
                {
                    $string = str_replace('Khác', '', implode(',', $_POST['JobCreate'][$value->id]));
                    if (!empty($_POST[$value->id]))
                        $option[$value->id] = ['name' => $value->name, 'option' => trim($string, ','), 'other' => $_POST[$value->id]];
                    else
                        $option[$value->id] = ['name' => $value->name, 'option' => trim($string, ',')];
                }
            }
            $job->options = $option;
            $job->name = $model->name;
            $job->slug = \Yii::$app->convert->string($model->name);
            $job->slugname = \Yii::$app->convert->unsigned($model->name);
            $job->deadline = \Yii::$app->convert->date($model->deadline);
            $job->description = $model->description;
            $job->level = $model->level;
            $job->work_location = $model->work_location;
            if ($model->work_location == 2)
            {
                $job->address = $model->address;
                $job->district_id = $model->district_id;
                $job->city_id = $model->city_id;
            }
            $job->num_bid = $model->num_bid;
            if (!empty($model->file))
                $job->file = [$model->file];
            if ($job->save())
            {
                return $this->redirect(['/cong-viec/' . $job->slug . '-' . $job->id]);
            }
        }
        return $this->render('update', ['model' => $model, 'district' => $data, 'options' => $options, 'budget' => $this->findBudget($job->sector_id), 'sector' => $sector]);
    }

    protected function findBudget($id)
    {
        $model = BudgetPacket::find()->where(['IN', 'sectors', $id])->one();
        $data = [];
        if (!empty($model))
        {
            foreach ($model->options as $option)
            {
                $data[$option['min'] . '-' . $option['max']] = number_format($option['min'], 0, '', '.') . ' - ' . number_format($option['max'], 0, '', '.');
            }
        }
        return $data;
    }

    public function actionView($id)
    {
        $model = Job::findOne($id);
        if (!empty($_POST['_csrf']))
        {
            if (isset($_POST['save-draft']))
                $model->publish = Job::PUBLISH_NOACTIVE;
            else
                $model->publish = Job::PUBLISH_ACTIVE;

            if ($model->save())
                return $this->redirect(['active', 'id' => (string) $model['_id']]);
        }
        return $this->render('view', ['model' => $model]);
    }

    public function actionActive($id)
    {
        if (!empty($id))
        {
            $invited = new JobInvited;
            $model = Job::findOne($id);
            //var_dump((string)$model->category->_id); exit;
            $users = User::find()->where(['category' => (string) $model->category->_id, 'role' => User::ROLE_MEMBER])->all();
            //var_dump($users); exit;
            return $this->render('active', ['model' => $model, 'invited' => $invited, 'users' => $users]);
        }
    }

    public function actionInvited()
    {
        $this->layout = 'ajax';
        $model = new JobInvited;
        return $this->render('invited', ['model' => $model]);
    }

    public function actionJobinvited()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['JobInvited']))
        {
            $model = new JobInvited();
            $model->job_id = $_POST['JobInvited']['job_id'];
            $model->actor = $_POST['JobInvited']['actor'];
            $model->message = $_POST['JobInvited']['message'];
            $model->created_at = time();
            $model->status = JobInvited::STATUS_NOACCEPT;
            if ($model->save())
            {
                $job = Job::findOne($_POST['JobInvited']['job_id']);
                $notify = new Notification();
                $notify->owner = (string) Yii::$app->user->identity->id;
                $notify->actor = $_POST['JobInvited']['actor'];
                $notify->type = 'job';
                $notify->type_id = $model->job_id;
                $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(20) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ';
                $notify->created_at = time();
                $notify->save();
                return $model;
            }
        }
    }

    public function actionDetail($id)
    {
        if (!empty($_GET['notify']))
        {
            $notify = Notification::findOne($_GET['notify']);
            $notify->status = 2;
            $notify->save();
        }
        if (!empty($id))
        {
            if (\Yii::$app->user->isGuest)
                $this->redirect('/dang-nhap?redirect=' . Yii::$app->convert->redirect(Yii::$app->params['site_url'] . 'cong-viec/' . $_GET['slug'] . '/' . $_GET['id']));

            $model = Job::findOne($id);
            $bid = new Bid();
            $message = Messages::find()
                    ->where([
                        'job_id' => (string) $model->_id,
                        'status' => 1
                    ])
                    ->all();
            $jobs = Job::find()
                    ->where(['category_id' => $model->category_id])
                    ->andWhere(['NOT IN', '_id', [$model->id]])
                    ->andWhere(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_PUBLISH, 'block' => Job::JOB_UNBLOCK])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->limit(5)
                    ->all();
            $users = User::find()->where(['IN', 'sector', $model->sector_id])->orderBy(['rating' => SORT_DESC])->limit(10)->all();

            $count = Conversation::find()->where(['job_id' => (string) $model->_id])->count();
            if (\Yii::$app->user->identity->role == User::ROLE_BOSS)
            {
                //$created_at = AssignmentStep::find()->where(['assignment_id' => (string) $model->_id, 'status_actor' => Assignment::STATUS_PROGRESS])->max('created_at');
                $assignment = Assignment::find()->where(['job_id' => $id, 'owner' => (string) Yii::$app->user->identity->id])->one();
                $countjobclose = Job::find()->where(['owner' => \Yii::$app->user->id, 'status' => Job::PROJECT_DEPOSIT, 'publish' => Job::PUBLISH_CLOSE])->count();
                if (!empty($assignment))
                {

                    switch ($assignment->status_boss)
                    {
                        // Neu Boss da giao viec 
                        case Assignment::STATUS_GIVE:
                            return $this->render('job_detail_boss', ['model' => $model, 'users' => $users, 'invited' => new JobInvited(), 'message' => $message, 'count' => $count, 'assignment' => $assignment, 'countjobclose' => $countjobclose]);
                            break;
                        // Neu boss da dat coc thì chuyen toi cam ket lam viec
                        case Assignment::STATUS_DEPOSIT:
                            return $this->redirect(['assignment/bosscommitment', 'id' => (string) $assignment->_id, 'countjobclose' => $countjobclose]);
                            break;
                        // Neu boss da cam ket lam viec chuyen tơi lam viec
                        case Assignment::STATUS_COMMITMENT:
                            return $this->redirect(['assignment/work', 'id' => (string) $assignment->_id, 'countjobclose' => $countjobclose]);
                            break;
                        // Neu boss cam ket lam viec -> thanh toan   
                        case Assignment::STATUS_REQUEST:
                            return $this->redirect(['assignment/browsejob', 'id' => (string) $assignment->_id, 'countjobclose' => $countjobclose]);
                            break;
                        // Neu boss da thanh toan -> admin xac nhan thanh toan 
                        case Assignment::STATUS_PAYMENT:
                            return $this->redirect(['assignment/browsejob', 'id' => (string) $assignment->_id, 'countjobclose' => $countjobclose]);
                            break;
                        // ket thuc cong viec, nghiem thu xong
                        case Assignment::STATUS_COMPLETE:
                            return $this->redirect(['assignment/browsejob', 'id' => (string) $assignment->_id, 'countjobclose' => $countjobclose]);
                            break;
                        case Assignment::STATUS_REVIEW:
                            return $this->redirect(['assignment/browsejob', 'id' => (string) $assignment->_id, 'countjobclose' => $countjobclose]);
                            break;
                        default :
                            return $this->redirect(['assignment/committed', 'id' => (string) $assignment->_id, 'countjobclose' => $countjobclose]);
                    }
                }
                // add view to job sector
                $sector = Sectors::findOne((string) $model->sector_id);
                $sector->view = $sector->view + 1;
                $sector->save();

                $count = Conversation::find()->where(['job_id' => (string) $model->_id])->count();
                $userInvited = JobInvited::find()->where(['job_id' => $id])->all();

                return $this->render('job_detail_boss', ['model' => $model, 'users' => $users, 'invited' => new JobInvited(), 'userInvited' => $userInvited, 'message' => $message, 'count' => $count, 'countjobclose' => $countjobclose]);
            }
            else
            {
                $assignment = Assignment::find()->where(['job_id' => $id, 'actor' => (string) Yii::$app->user->identity->id])->one();
                if (!empty($assignment))
                {
                    switch ($assignment->status_member)
                    {
                        // Neu Boss da giao viec va cho nhan vien xa nhan lam viec
                        case Assignment::STATUS_GIVE:
                            return $this->render('job_detail_member', ['model' => $model, 'bid' => $bid, 'jobs' => $jobs, 'assignment' => $assignment]);
                            break;
                        // Neu Nhan vien da cam ket -> lam viec
                        case Assignment::STATUS_COMMITMENT:
                            return $this->redirect(['assignment/memberprogress', 'id' => (string) $assignment->_id]);
                            break;
                        // Neu nhan vien gui hoan thanh -> lam viec
                        case Assignment::STATUS_REQUEST:
                            return $this->redirect(['assignment/memberprogress', 'id' => (string) $assignment->_id]);
                            break;
                        case Assignment::STATUS_COMPLETE:
                            return $this->redirect(['assignment/memberprogress', 'id' => (string) $assignment->_id]);
                            break;
                        case Assignment::STATUS_REVIEW:
                            return $this->redirect(['assignment/memberprogress', 'id' => (string) $assignment->_id]);
                            break;
                    }
                }
                else
                {
                    
                }
                // add view to job sector
                $sector = Sectors::findOne((string) $model->sector_id);
                $sector->view = $sector->view + 1;
                $sector->save();
                return $this->render('job_detail_member', ['model' => $model, 'bid' => $bid, 'jobs' => $jobs]);
            }
        }
        else
        {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionJobclose()
    {
        if (!empty($_POST['id']))
        {
            $model = Job::findOne($_POST['id']);

            if ($model->publish == Job::PUBLISH_NOACTIVE)
                $model->publish = Job::PUBLISH_CLOSE;

            elseif ($model->publish == Job::PUBLISH_ACTIVE)
                $model->publish = Job::PUBLISH_CLOSE;

            if ($model->save())
            {
                $countjobclose = Job::find()->where(['owner' => \Yii::$app->user->id, 'status' => Job::PROJECT_DEPOSIT, 'publish' => Job::PUBLISH_CLOSE])->count();
                if ($countjobclose == 3)
                {
                    $user = User::findOne(\Yii::$app->user->id);
                    $user->publish = User::PUBLISH_BLOCK;
                    $user->save();
                }
                return "ok";
            }
        }
        else
        {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    // search jobname
    public function actionSearch()
    {
        $bid = new Bid();
        $category = Category::find()->all();
        $sector = Sectors::find()->all();
        $level = Level::find()->all();
        $city = City::find()->all();
        $query = Job::find()->where([
                    'or',
                    ['like', 'name', $_GET['k']],
                    ['like', 'slugname', $_GET['k']]
                ])->andWhere(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_PUBLISH, 'block' => Job::JOB_UNBLOCK])->andWhere(['deadline' => ['$gt' => time()]])->orderBy(['featured' => SORT_DESC, 'created_at' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        if (!\Yii::$app->user->isGuest)
        {
            $job = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id])->all();
        }
        else
        {
            $job = '';
        }
        $invited = new JobInvited();
        return $this->render('index', [
                    'category' => $category,
                    'sector' => $sector,
                    'level' => $level,
                    'city' => $city,
                    'model' => $model,
                    'bid' => $bid,
                    'job' => $job,
                    'invited' => $invited,
                    'pages' => $pages
        ]);
    }

    // fillter job
    public function actionFillter()
    {
        $bid = new Bid();
        $category = Category::find()->all();
        $sector = Sectors::find()->all();
        $level = Level::find()->all();
        $city = City::find()->all();
        $query = Job::find();
        if (!empty($_GET['k']) or ! empty($_GET['t']) or ! empty($_GET['s']) or ! empty($_GET['g']) or ! empty($_GET['l']) or ! empty($_GET['c']) or ! empty($_GET['d']))
        {
            $query->where(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_PUBLISH, 'block' => Job::JOB_UNBLOCK])->andWhere(['or', ['like', 'name', $_GET['k']], ['like', 'slugname', $_GET['k']]])->andWhere(['deadline' => ['$gt' => time()]])->orderBy(['featured' => SORT_DESC, 'created_at' => SORT_DESC]);
            if (!empty($_GET['t']))
            {
                $query->andWhere(['category_id' => $_GET['t']]);
            }
            if (!empty($_GET['s']))
            {
                $query->andWhere(['in', 'sector_id', explode(",", $_GET['s'])]);
            }
            if (!empty($_GET['g']))
            {
                $query->andWhere(['project_type' => $_GET['g']]);
            }
            if (!empty($_GET['l']))
            {
                $query->andWhere(['in', 'level', explode(",", $_GET['l'])]);
            }
            if (!empty($_GET['c']))
            {
                $query->andWhere(['in', 'city_id', explode(",", $_GET['c'])]);
            }
            if (!empty($_GET['d']))
            {
                $query->andWhere(['district_id' => $_GET['d']]);
            }
        }
        else
        {
            $query->where(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_PUBLISH, 'block' => Job::JOB_UNBLOCK])->andWhere(['deadline' => ['$gt' => time()]])->orderBy(['featured' => SORT_DESC, 'created_at' => SORT_DESC]);
        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        if (!\Yii::$app->user->isGuest)
        {
            $job = Job::find()->where(['owner' => (string) \Yii::$app->user->identity->id])->all();
        }
        else
        {
            $job = '';
        }
        $invited = new JobInvited();
        return $this->render('index', [
                    'category' => $category,
                    'sector' => $sector,
                    'level' => $level,
                    'city' => $city,
                    'model' => $model,
                    'bid' => $bid,
                    'job' => $job,
                    'invited' => $invited,
                    'pages' => $pages
        ]);
    }

}
