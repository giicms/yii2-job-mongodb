<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\mongodb\Query;
use yii\data\Pagination;
use common\models\Bid;
use common\models\Messages;
use common\models\Conversation;
use common\models\Sectors;
use common\models\Language;
use common\models\LanguageLevel;
use common\models\WorkProcess;
use common\models\WorkDone;
use common\models\User;
use common\models\Education;
use common\models\PersonalStorage;
use common\models\Job;
use common\models\City;
use common\models\District;
use common\models\Notification;
use common\models\BudgetPacket;
use common\models\BudgetPrice;
use common\models\Bankaccount;
use common\models\JobInvited;
use common\models\UserBid;
use frontend\models\BidCreate;

class AjaxController extends FrontendController
{

    public function actionBid()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        switch (Yii::$app->user->identity->step)
        {
            case 0:
                $redirect = 'membership/success';
                break;
            case User::STEP_REG:
                $redirect = 'membership/jobcategories';
                break;
            case User::STEP_CATE:
                $redirect = 'membership/about';
                break;
            case User::STEP_ABOUT:
                $redirect = 'membership/experience';
                break;
            case User::STEP_EXPRESS:
                $redirect = 'membership/complete';
                break;
        }
        if (!empty($redirect))
        {
            Yii::$app->session->setFlash('success', '   Bạn chưa hoàn thành hồ sơ hoặc hồ sơ của bạn chưa được duyệt!.');
            return $this->redirect([$redirect]);
        }
        $first_day = (int) \Yii::$app->convert->date(date('d/m/Y', strtotime(date('Y-m-01', strtotime("now")))));
        $last_day = (int) \Yii::$app->convert->date(date('t/m/Y'));
        $count_bid = Bid::find()->where(['between', 'created_at', $first_day, $last_day])->andWhere(['actor' => (string) Yii::$app->user->id])->count();
        if ($count_bid == Yii::$app->user->identity->findlevel->count_bid)
        {
            return ['error' => 'Tháng này bạn đã hết lượt book'];
        }
        if (!empty($_POST['id']))
        {
            $model = Bid::findOne($_POST['id']);
            return ['id' => (string) $model->_id, 'job_id' => $model->job_id, 'price' => $model->price, 'period' => $model->period, 'content' => $model->content, 'name' => $model->job->name, 'content' => $model->content];
        }
        elseif (!empty($_POST['Bid']))
        {

            $job = Job::findOne($_POST['Bid']['job_id']);
      
            if (!empty($_POST['bid_id']))
                $model = Bid::findOne($_POST['bid_id']);
            else
                $model = new Bid();
            if ($model->load(Yii::$app->request->post()))
            {
                $model->actor = Yii::$app->user->id;
                $model->price = (int) preg_replace('/[^0-9]/', '', $_POST['Bid']['price']);
                $model->status = 0;
                $model->created_at = time();
                $model->publish = 1;
                if ($model->validate())
                {
                    if ($model->save())
                    {
                        $jobinvited = JobInvited::find()->where(['job_id' => $job->id, 'actor' => \Yii::$app->user->id])->one();
                        if (!empty($jobinvited))
                        {
                            $jobinvited->status = JobInvited::STATUS_ACCEPT;
                            $jobinvited->save();
                        }
                        $notify = new Notification();
                        $notify->owner = (string) Yii::$app->user->identity->id;
                        $notify->actor = (string) $job->owner;
                        $notify->type = 'job';
                        $notify->type_id = (string) $job->_id;
                        $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(0) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ' . $notify->getMessages(1);
                        $notify->created_at = time();
                        $notify->save();
                        return ['id' => (string) $model->_id, 'job_slug' => $job->slug, 'job_id' => $job->id];
                    }
                }
            }
        }
        else
        {
            $model = Job::findOne($_POST['job_id']);
            $bid = new BidCreate($model->budget_type);
            if (in_array(\Yii::$app->user->identity->level, $model->level) AND in_array($model->sector_id, \Yii::$app->user->identity->sector))
                return $this->renderAjax('bid', ['bid' => $bid, 'model' => $model, 'status' => 1]);
            else
                return $this->renderAjax('bid', ['bid' => $bid, 'model' => $model, 'name' => $model->name, 'status' => 0]);
        }
    }

    public function actionRemovebid()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['confirm']))
        {
            $model = Bid::findOne($_POST['confirm']);
            $job = Job::findOne($model->job_id);
            if ($model->delete())
            {
                $notify = new Notification();
                $notify->owner = (string) Yii::$app->user->identity->id;
                $notify->actor = (string) $job->owner;
                $notify->type = 'job';
                $notify->type_id = (string) $job->_id;
                $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(2) . ' "' . Yii::$app->convert->excerpt($job->name, 50) . '" ' . $notify->getMessages(1);
                $notify->created_at = time();
                $notify->save();
                return ['message' => 'ok', 'job_id' => $model->job_id];
            }
        }
    }

    public function actionMessage()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['message_id']))
        {
            $message = Messages::findOne($_POST['message_id']);
            if (!empty($message))
            {
                $conver = new Conversation();
                $conver->job_id = $message->job_id;
                $conver->user_id = (string) Yii::$app->user->identity->id;
                $conver->message_id = (string) $message->_id;
                $conver->content = $_POST['content'];
                $conver->created_at = time();
                if ($conver->save())
                {
                    if (!empty($conver->profile->avatar))
                        $avatar = '150-' . $conver->profile->avatar;
                    else
                        $avatar = 'avatar.png';
                    return ['data' => ['conver' => $conver, 'user' => ['id' => (string) $conver->profile->_id, 'name' => $conver->profile->name, 'avatar' => Yii::$app->params['url_file'] . '/thumbnails/' . $avatar]]];
                }
            }
        }
    }

    public function actionListmessage()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['id']))
        {
            $message = Messages::findOne($_POST['id']);
        }
        else
        {
            $message = Messages::find()->where(['job_id' => $_POST['job_id'], 'user_2' => $_POST['user_id']])->one();
        }
        $array = [];
        if (!empty($message))
        {
            $conver = Conversation::find()->where(['message_id' => (string) $message->_id])->all();
            if (!empty($conver))
            {
                foreach ($conver as $value)
                {
                    $array[] = ['id' => (string) $value->_id, 'content' => $value->content, 'user_id' => (string) $value->profile->_id, 'name' => $value->profile->name];
                }
            }
            return ['message_id' => (string) $message->_id, 'user_1' => $message->user_1, 'user_2' => $message->user_2, 'data' => $array];
        }
        else
        {
            $message = new Messages();
            $message->job_id = $_POST['job_id'];
            $message->user_1 = (string) \Yii::$app->user->identity->id;
            $message->user_2 = $_POST['user_id'];
            $message->created_at = time();
            if ($message->save())
                return ['message_id' => (string) $message->_id, 'user_1' => $message->user_1, 'user_2' => $message->user_2, 'data' => $array];
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

    public function actionLanguagelist()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = LanguageLevel::find()->where(['language_id' => $_POST['id']])->all();
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
            $data[0] = ['id' => 0, 'name' => 'Cấp độ này chưa có'];
        }
        return $data;
    }

    public function actionAddlanguage()
    {
        $this->layout = 'ajax';
        if (!empty($_POST['language_id']))
        {
            $data = [];
            foreach (explode(',', $_POST['language_id']) as $value)
            {
                $find = Language::findOne($value);
                if (!empty($find))
                    $data[] = $find->name;
            }
            $model = Language::find()->where(['NOT IN', 'name', $data])->all();
            if (!empty($data))
                return $this->render('addLanguage', ['i' => (int) $_POST['i'] + 1, 'model' => $model]);
        }
    }

    public function actionBankaccount()
    {

        $account_holder = $_POST['account_holder'];
        $bankaccount = $_POST['bankaccount'];
        $bank_local = $_POST['bank_local'];
        $bank_name = $_POST['bank_name'];
        $branch_bank = $_POST['branch_bank'];
        $model = Bankaccount::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->one();
        if (!empty($model))
        {
            $model->account_holder = $account_holder;
            $model->bankaccount = $bankaccount;
            $model->bank_local = $bank_local;
            $model->bank_name = $bank_name;
            $model->branch_bank = $branch_bank;
            if ($model->save())
            {
                return 'ok';
            }
        }
        else
        {
            $backacc = new Bankaccount();
            $backacc->user_id = (string) \Yii::$app->user->identity->id;
            $backacc->account_holder = $account_holder;
            $backacc->bankaccount = $bankaccount;
            $backacc->bank_local = $bank_local;
            $backacc->bank_name = $bank_name;
            $backacc->branch_bank = $branch_bank;
            if ($backacc->save())
            {
                return 'ok';
            }
        }
    }

    public function actionWorkprogress()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['_csrf']))
        {
            $data = [];
            for ($i = 0; $i < 5; $i++)
            {
                if (!empty($_POST['Workprocess']['company'][$i]))
                {
                    if (!empty($_POST['work_id'][$i]))
                        $model = WorkProcess::findOne($_POST['work_id'][$i]);
                    else
                        $model = new WorkProcess();

                    $model->user_id = (string) \Yii::$app->user->identity->id;
                    $model->company = $_POST['Workprocess']['company'][$i];
                    $model->position = $_POST['Workprocess']['position'][$i];
                    $model->created_begin = $_POST['Workprocess']['created_begin'][$i];
                    $model->created_end = $_POST['Workprocess']['created_end'][$i];
                    if ($model->save())
                    {
                        $user = User::findOne((string) \Yii::$app->user->identity->id);
                        if (!empty($user))
                        {
                            $user->updated_at = time();
                            $user->save();
                        }
                        $data [] = ['id' => (string) $model->_id, 'company' => $model->company, 'position' => $model->position, 'created_begin' => $model->created_begin, 'created_end' => $model->created_end];
                    }
                }
            }
            return $data;
        }
    }

    public function actionEducation()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['_csrf']))
        {
            $data = [];
            for ($i = 0; $i < 5; $i++)
            {
                if (!empty($_POST['Education']['school'][$i]))
                {
                    if (!empty($_POST['education_id'][$i]))
                        $model = Education::findOne($_POST['education_id'][$i]);
                    else
                        $model = new Education();

                    $model->user_id = (string) \Yii::$app->user->identity->id;
                    $model->school = $_POST['Education']['school'][$i];
                    $model->course = $_POST['Education']['course'][$i];
                    $model->created_begin = $_POST['Education']['created_begin'][$i];
                    $model->created_end = $_POST['Education']['created_end'][$i];
                    if ($model->save())
                    {
                        $user = User::findOne((string) \Yii::$app->user->identity->id);
                        if (!empty($user))
                        {
                            $user->updated_at = time();
                            $user->save();
                        }
                        $data [] = ['id' => (string) $model->_id, 'school' => $model->school, 'course' => $model->course, 'created_begin' => $model->created_begin, 'created_end' => $model->created_end];
                    }
                }
            }
            return $data;
        }
    }

    public function actionWorkdone()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = [];
        if (!empty($_POST['_csrf']))
        {
            if (!empty($_POST['WorkDone']))
            {
                if (!empty($_POST['WorkDone']['id']))
                    $model = WorkDone::findOne($_POST['WorkDone']['id']);
                else
                    $model = new WorkDone();
                $model->user_id = (string) \Yii::$app->user->identity->id;
                $model->name = $_POST['WorkDone']['name'];
                $model->description = $_POST['WorkDone']['description'];
                $model->link = $_POST['WorkDone']['link'];
                if (!empty($_POST['img']))
                    $model->files = $_POST['img'];
                if ($model->save())
                {
                    $user = User::findOne((string) \Yii::$app->user->identity->id);
                    if (!empty($user))
                    {
                        $user->updated_at = time();
                        $user->save();
                    }
                    $data = ['id' => (string) $model->_id, 'name' => $model->name, 'description' => $model->description, 'link' => $model->link, 'files' => $model->files];
                }
            }
            return $data;
        }
        else
        {
            $model = WorkDone::findOne($_POST['id']);
            return ['id' => $model->id, 'name' => $model->name, 'description' => $model->description, 'link' => $model->link, 'files' => $model->files];
        }
    }

    public function actionDeleteworkdone()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['id']))
        {
            $model = WorkDone::findOne($_POST['id']);
            if ($model->delete())
                return [1];
        }
    }

    public function actionSavejob()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['job_id']))
        {
            $savejob = PersonalStorage::find()->where(['job_id' => $_POST['job_id'], 'user_id' => (string) \Yii::$app->user->identity->id])->one();
            if (!empty($savejob))
            {
                $savejob->delete();
                return [1];
            }
            else
            {
                $model = new PersonalStorage();
                $model->user_id = (string) \Yii::$app->user->identity->id;
                $model->job_id = $_POST['job_id'];
                $model->created_at = time();
                if ($model->save())
                    return [2];
            }
        }
    }

    public function actionSaveuser()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['user_id']))
        {
            $exit = PersonalStorage::find()->where(['owner' => (string) Yii::$app->user->identity->id, 'actor' => $_POST['user_id'], 'status' => 1])->one();
            if (!empty($exit))
            {
                if ($exit->delete())
                    return ['status' => 0];
            } else
            {
                $model = new PersonalStorage();
                $model->owner = (string) Yii::$app->user->identity->id;
                $model->actor = $_POST['user_id'];
                $model->status = 1;
                $model->created_at = time();
                if ($model->save())
                    return ['status' => 1];
            }
        }
    }

    public function actionSelectdistrict()
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

    public function actionImage()
    {
        $this->layout = 'ajax';
        return $this->render('image', ['src' => $_GET['src']]);
    }

    public function actionNotify()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $notify = Notification::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1])->all();
        if (!empty($notify))
        {
            foreach ($notify as $value)
            {
                $value->active = 2;
                $value->save();
                if ($value->type == 'job')
                {
                    $url = Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->job->slug . '/' . (string) $value->job->_id . '?notify=' . (string) $value->_id);
                }
                else
                {
                    $url = '#';
                }
                $data = ['_id' => (string) $value->_id, 'url' => $url, 'avatar' => Yii::$app->params['url_file'] . '/thumbnails/150-' . $value->user->avatar, 'content' => $value->content, 'created_at' => Yii::$app->convert->time($value->created_at)];
            }
            return $data;
        }
    }

    public function actionClient()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $notify = Notification::find()->where(['actor' => (string) Yii::$app->user->identity->id, 'active' => 1, 'set' => 1])->all();
        $data = [];
        if (!empty($notify))
        {
            foreach ($notify as $value)
            {
                if ($value->type == 'job')
                {
                    $url = Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->job->slug . '/' . (string) $value->job->_id);
                }
                else
                {
                    $url = '#';
                }
                $value->set = 2;
                $value->save();
                $data[] = ['url' => $url, 'avatar' => Yii::$app->params['url_file'] . '/thumbnails/150-' . $value->user->avatar, 'content' => $value->content, 'created_at' => Yii::$app->convert->time($value->created_at)];
            }
            return $data;
        }
    }

    public function actionNotifylist()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $limit = 20;

        $offset = $limit * ($_GET['page'] - 1);
        $query = Notification::find()->where(['actor' => (string) Yii::$app->user->identity->id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page']]);
        $model = $query->offset($offset)
                ->limit($limit)
                ->all();
        if (!empty($model))
        {
            $data = [];
            foreach ($model as $value)
            {
                if ($value->type == 'job')
                {
                    $url = Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $value->job->slug . '/' . (string) $value->job->_id);
                }
                else
                {
                    $url = '#';
                }
                $data[] = ['url' => $url, 'avatar' => Yii::$app->params['url_file'] . 'thumbnails/150-' . $value->user->avatar, 'content' => $value->content, 'created_at' => Yii::$app->convert->time($value->created_at)];
            }
            return ['data' => $data, 'page' => $_GET['page'] + 1];
        }
    }

    public function actionBudgetprice()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = BudgetPacket::find()->where(['sector_id' => $_POST['id']])->one();
        $data = [];
        if (!empty($model))
        {
            $price = BudgetPrice::find()->where(['bg_id' => $model->id, 'publish' => BudgetPrice::PUBLISH_ACTIVE])->all();
            if (!empty($price))
            {
                foreach ($price as $key => $value)
                {
                    $data[] = ['id' => $value->id, 'name' => 'Từ ' . number_format($value->min, 0, '', '.') . ' đến ' . number_format($value->max, 0, '', '.')];
                }
            }
        }
        return $data;
    }

    public function actionJobinvited()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = JobInvited::find()->where(['job_id' => $_POST['id']])->andWhere(['status', JobInvited::STATUS_NOACCEPT])->all();
        if (!empty($model))
        {
            foreach ($model as $value)
            {
                $time = date('Y-m-d H:i:s', $value->created_at);
                $ago = strtotime(date('Y-m-d H:i:s', time())) - strtotime($time);
                if ($ago / 3600 > 4)
                {
                    $find = JobInvited::findOne($value->id);
                    $find->status = JobInvited::STATUS_CLOSE;
                    $find->save();
                }
            }
        }
        $jobclose = JobInvited::find()->where(['job_id' => $_POST['id']])->andWhere(['status', JobInvited::STATUS_CLOSE])->all();
        $ids = [];
        foreach ($jobclose as $value)
        {
            $ids[] = $value->actor;
        }
        $job = Job::findOne($_POST['id']);
        $users = User::find()->where(['IN', 'sector', $job->sector_id])->andWhere(['NOT IN', '_id', $ids])->orderBy(['rating' => SORT_DESC])->limit('10')->all();
        foreach ($users as $user)
        {
            $data[] = [];
        }
    }

    public function actionUserbid()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['UserBid']))
        {
            $model = new UserBid();
            $model->owner_id = (string) \Yii::$app->user->id;
            $model->actor_id = $_POST['UserBid']['actor_id'];
            $model->message = $_POST['UserBid']['message'];
            $model->created_at = time();
            $model->status = UserBid::STATUS_NOACCEPT;
            if ($model->save())
            {
                $notify = new Notification();
                $notify->owner = (string) Yii::$app->user->identity->id;
                $notify->actor = $_POST['UserBid']['actor_id'];
                $notify->type = 'user';
                $notify->type_id = (string) Yii::$app->user->identity->id;
                $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(25) . ' "';
                $notify->created_at = time();
                $notify->save();
                return $model;
            }
        }
    }

    public function actionUserbidstatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['id']))
        {
            $model = UserBid::findOne($_POST['id']);
            if ($_POST['role'] == 'cancel')
                $model->status = UserBid::STATUS_CLOSE;
            else
                $model->status = UserBid::STATUS_ACCEPT;
            if ($model->save())
            {
                $notify = new Notification();
                $notify->owner = $model->actor_id;
                $notify->actor = $model->owner_id;
                $notify->type = 'user';
                $notify->type_id = $model->actor_id;
                if ($model->status == UserBid::STATUS_ACCEPT)
                    $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(26) . ' "';
                else
                    $notify->content = Yii::$app->user->identity->name . ' ' . $notify->getMessages(27) . ' "';
                $notify->created_at = time();
                $notify->save();
                return 'ok';
            }
        }
    }

    public function actionChecksector()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = User::findOne($_POST['user_id']);
        $job = Job::find()->where(['IN', 'sector_id', $user->sector])->all();
        $data = [];
        if (!empty($job))
        {
            foreach ($job as $value)
            {
                $data[] = ['id' => $value->id, 'name' => $value->name];
            }
        }
        return $data;
    }

}
