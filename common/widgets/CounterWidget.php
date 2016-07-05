<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\db\Query;
use common\models\User;
use common\models\Job;
use common\models\Counter;
use common\models\Onlinedaily;
use yii\mongodb\Collection;

class CounterWidget extends \yii\bootstrap\Widget
{

    public function init()
    {
        
    }

    public function run()
    {
        $totalonline = Onlinedaily::find()->sum('counter');
        $time = strtotime('monday this week');

        $totallastweek = Onlinedaily::find()->where(['between', 'created_at', 0, $time])->sum('counter');
        $totalvisited = Onlinedaily::find()->sum('counter');
        if ($totalvisited > 0 && $totallastweek > 0)
        {
            $minus = $totalvisited - $totallastweek;
            if ($minus > 0)
            {
                $growth = '<i class="green"><i class="fa fa-sort-asc"></i>' . round((($minus / $totallastweek) * 100), 2) . '% </i>';
            }
            else
            {
                $growth = '<i class="red"><i class="fa fa-sort-desc"></i>' . round((($minus / $totallastweek) * 100), 2) . '% </i>';
            }
        }
        else
        {
            $growth = '<i class="green"><i class="fa fa-sort-desc"></i>0% </i>';
        }
        echo '<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
			        <div class="left"></div>
			        <div class="right">
			            <span class="count_top"><i class="fa fa-globe"></i> Tổng số lượt truy cập</span>
			            <div class="count">' . number_format($totalvisited, 0, '', '.') . '</div>
			            <span class="count_bottom">' . $growth . ' So với tuần trước</span>
			        </div>
			    </div>';

        $totalmemberlastweek = User::find()->where(['role' => User::ROLE_MEMBER, 'status' => User::STATUS_ACTIVE])->andWhere(['between', 'created_at', 0, $time])->count();
        $totalmember = User::find()->where(['role' => User::ROLE_MEMBER, 'status' => User::STATUS_ACTIVE])->count();
        if ($totalmember > 0 && $totalmemberlastweek > 0)
        {
            $minus = $totalmember - $totalmemberlastweek;
            if ($minus > 0)
            {
                $growth = '<i class="green"><i class="fa fa-sort-asc"></i>' . round((($minus / $totalmemberlastweek) * 100), 2) . '% </i>';
            }
            else
            {
                $growth = '<i class="red"><i class="fa fa-sort-desc"></i>' . round((($minus / $totalmemberlastweek) * 100), 2) . '% </i>';
            }
        }
        else
        {
            $growth = '<i class="green"><i class="fa fa-sort-desc"></i>0% </i>';
        }
        echo '<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
			        <div class="left"></div>
			        <div class="right">
			            <span class="count_top"><i class="fa fa-user"></i> Tổng số nhân viên</span>
			            <div class="count">' . number_format($totalmember, 0, '', '.') . '</div>
			            <span class="count_bottom">' . $growth . ' So với tuần trước</span>
			        </div>
			    </div>';

        $totalbosslastweek = User::find()->where(['role' => User::ROLE_BOSS, 'status' => User::STATUS_ACTIVE])->andWhere(['between', 'created_at', 0, $time])->count();
        $totalboss = User::find()->where(['role' => User::ROLE_BOSS, 'status' => User::STATUS_ACTIVE])->count();
        if ($totalboss > 0 && $totalbosslastweek > 0)
        {
            $minus = $totalboss - $totalbosslastweek;
            if ($minus > 0)
            {
                $growth = '<i class="green"><i class="fa fa-sort-asc"></i>' . round((($minus / $totalbosslastweek) * 100), 2) . '% </i>';
            }
            else
            {
                $growth = '<i class="red"><i class="fa fa-sort-desc"></i>' . round((($minus / $totalbosslastweek) * 100), 2) . '% </i>';
            }
        }
        else
        {
            $growth = '<i class="green"><i class="fa fa-sort-desc"></i>0% </i>';
        }
        echo '<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
			        <div class="left"></div>
			        <div class="right">
			            <span class="count_top"><i class="fa fa-user-md"></i> Tổng số người thuê</span>
			            <div class="count">' . number_format($totalboss, 0, '', '.') . '</div>
			            <span class="count_bottom">' . $growth . ' So với tuần trước</span>
			        </div>
			    </div>';

        $totaljoblastweek = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE])->andWhere(['between', 'created_at', 0, $time])->count();
        $totaljob = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE])->count();
        if ($totaljob > 0 && $totaljoblastweek > 0)
        {
            $minus = $totaljob - $totaljoblastweek;
            if ($minus > 0)
            {
                $growth = '<i class="green"><i class="fa fa-sort-asc"></i>' . round((($minus / $totaljoblastweek) * 100), 2) . '% </i>';
            }
            else
            {
                $growth = '<i class="red"><i class="fa fa-sort-desc"></i>' . round((($minus / $totaljoblastweek) * 100), 2) . '% </i>';
            }
        }
        else
        {
            $growth = '<i class="green"><i class="fa fa-sort-desc"></i>0% </i>';
        }
        echo '<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
			        <div class="left"></div>
			        <div class="right">
			            <span class="count_top"><i class="fa fa-desktop"></i> Tổng số công việc</span>
			            <div class="count">' . number_format($totaljob, 0, '', '.') . '</div>
			            <span class="count_bottom">' . $growth . ' So với tuần trước</span>
			        </div>
			    </div>';

        $totaljobdonelastweek = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_COMPLETED])->andWhere(['between', 'created_at', 0, $time])->count();
        $totaljobdone = Job::find()->where(['publish' => Job::PUBLISH_ACTIVE, 'status' => Job::PROJECT_COMPLETED])->count();
        if ($totaljobdone > 0 && $totaljobdonelastweek > 0)
        {
            $minus = $totaljobdone - $totaljobdonelastweek;
            if ($minus > 0)
            {
                $growth = '<i class="green"><i class="fa fa-sort-asc"></i>' . round((($minus / $totaljobdonelastweek) * 100), 2) . '% </i>';
            }
            else
            {
                $growth = '<i class="red"><i class="fa fa-sort-desc"></i>' . round((($minus / $totaljobdonelastweek) * 100), 2) . '% </i>';
            }
        }
        else
        {
            $growth = '<i class="green"><i class="fa fa-sort-desc"></i>0% </i>';
        }
        echo '<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
			        <div class="left"></div>
			        <div class="right">
			            <span class="count_top"><i class="fa fa-check-square"></i> Tổng số công việc hoàn thành</span>
			            <div class="count">' . $totaljobdone . '</div>
			            <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>0% </i> So với tuần trước</span>
			        </div>
			    </div>';


        echo '<div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
			        <div class="left"></div>
			        <div class="right">
			            <span class="count_top"><i class="fa fa-usd"></i> Tổng giá trị dự án</span>
			            <div class="count">65,923 tỷ</div>
			            <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>0% </i> So với tuần trước</span>
			        </div>
			    </div>';
    }

}
