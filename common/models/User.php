<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\JobInvited;
use common\models\WorkProcess;
use common\models\Sectors;
use common\models\Level;
use common\models\Review;
use yii\mongodb\Query;
use common\models\Category;
use common\models\Assignment;
use common\models\City;
use common\models\District;
use common\models\Test;
use common\models\UserBid;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $avatar
 * @property string $name
 * @property string $brithday
 * @property string $cmnd
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $type_of_employment
 * @property string $company_ad
 * @property string $categoty
 * @property string $level
 * @property string $description
 * @property string $skills
 * @property string $skill_language
 * @property string $authenticated
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_NOACTIVE = 1; //tài khoản chưa kích hoạt
    const STATUS_ACTIVE = 2; //tài khoản kích hoạt
    const PUBLISH_ACTIVE = 1;
    const PUBLISH_BLOCK = 2; //tài khoản đã bị khóa
    const ROLE_USER = 'user';
    const ROLE_MOD = 'mod';
    const ROLE_ADMIN = 'admin';
    const ROLE_MEMBER = 'member';
    const ROLE_BOSS = 'boss';
    const STEP_REG = 1; //ho so da kich hoat
    const STEP_CATE = 2; //chon nganh nghe, linh vuc
    const STEP_ABOUT = 3; //thong tin ca nhan
    const STEP_EXPRESS = 4; //kinh nghiem lam viec
    const STEP_COMPLE = 5; //gui duyet ho so
    const STEP_SUCCESS = 6; //duyet ho so thanh cong

    /**
     * @inheritdoc
     */

    public static function collectionName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_AFTER_UPDATE => ['updated_at']
                ]
            ]
        ];
    }

    public function attributes() {
        return [
            '_id',
            'password_hash',
            'password_reset_token',
            'email',
            'fbid',
            'auth_key',
            'avatar',
            'name',
            'rating',
            'slug',
            'slugname',
            'birthday',
            'cmnd',
            'phone',
            'address',
            'bankaccount',
            'city',
            'district',
            'type_of_employment',
            'boss_type',
            'company_name',
            'company_code',
            'category',
            'sector',
            'level',
            'description',
			'wallet',
            'skills',
            'language',
            'authenticated',
            'questions',
            'email_active',
            'role',
            'status',
            'publish',
            'created_at',
            'updated_at',
            'lastvisit',
            'step',
            'serial'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_NOACTIVE],
            ['publish', 'default', 'value' => self::PUBLISH_ACTIVE],
            ['step', 'default', 'value' => 0],
//            ['status', 'in', 'range' => [self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BLOCK]],
            [['cmnd', 'address', 'slug', 'slugname', 'city', 'district', 'company_name', 'role'], 'string'],
            [['created_at', 'updated_at', 'rating', 'serial', 'lastvisit', 'wallet'], 'integer'],
            [['sector', 'skills'], 'default'],
        ];
    }

    public function attributeLabels() {
        return array(
            'name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'password' => 'Mật khẩu',
            'password_repeat' => 'Xác nhận mật khẩu',
            'category' => 'Danh mục ngành nghề',
            'sector' => 'Lĩnh vực ngành nghề',
            'company_name' => 'Tên công ty',
            'company_code' => 'Mã số kinh doanh',
            'address' => 'Địa chỉ',
            'birthday' => 'Ngày tháng năm sinh',
            'cmnd' => 'Số CMND',
            'address' => 'Địa chỉ',
            'bankaccount' => 'Tài khoản ngân hàng',
            'city' => 'Tỉnh / thành phố',
            'level' => 'Cấp bậc',
            'district' => 'Quận / huyện',
            'description' => 'Mô tả bản thân',
            'questions' => 'Câu hỏi',
            'skill_language' => 'Trình độ ngoại ngữ',
            'email_active' => 'Gởi email kích hoạt tài khoản cũng như các email hướng dẫn khác để giúp tôi sử dụng hiểu quả Giaonhanviec.com'
        );
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
//        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        return static::find()
                        ->where([
                            'email' => $username
                        ])
                        ->orWhere([ 'phone' => $username])
                        ->one();
    }

    public function getUsername($name) {
        $slug = str_replace("-", "", Yii::$app->convert->string($name));
        $user = User::find()->where(['slug' => $slug])->one();
        $max = User::find()->max('serial');
        if (!empty($max)) {
            if (!empty(\Yii::$app->user->identity->serial))
                $serial = \Yii::$app->user->identity->serial;
            else
                $serial = $max + 1;
        } else {
            $serial = 1;
        }
        if (!empty($user))
            return ['slug' => $slug . '.' . $serial, 'serial' => $serial];
        else
            return ['slug' => $slug, 'serial' => $serial];
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
//        $timestamp = (int) substr($token, strrpos($token, '_') + 1);

        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return (string) $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public static function Jobinvited($user, $job) {
        $model = JobInvited::find()->where(['actor' => $user, 'job_id' => $job])->one();
        return $model;
    }

    public function getWorks() {
        $model = WorkProcess::find()->where(['user_id' => (string) \Yii::$app->user->identity->id])->all();
        return $model;
    }

    public static function getSector($id) {
        return Sectors::findOne($id);
    }

    public function getFindlevel() {
        return $this->hasOne(Level::className(), ['_id' => 'level']);
    }

    public function getFindcategory() {
        return $this->hasOne(Category::className(), ['_id' => 'category']);
    }

    public function getFindsector() {
        return $this->hasOne(Sectors::className(), ['_id' => 'sector']);
    }

    public function getLocation() {
        return $this->hasOne(District::className(), ['_id' => 'district']);
    }

    public function getBookuser() {
        $model = UserBid::find()->where(['owner_id' => Yii::$app->user->id, 'actor_id' => $this->id])->one();
        if (!empty($model)) {
            if ($model->status == UserBid::STATUS_ACCEPT)
                return 'Nhân viên này đã đồng ý yêu cầu của bạn';
            elseif ($model->status == UserBid::STATUS_CLOSE)
                return 'Nhân viên này đã hủy yêu cầu của bạn';
            elseif ($model->status == UserBid::STATUS_PENDING)
                return 'Nhân viên này đang lam việc cho bạn';
            else
                return 'Đang chờ chấp nhận';
        }
    }

    public function getBookboss() {
        $model = UserBid::find()->where(['actor_id' => Yii::$app->user->id, 'owner_id' => $this->id])->one();
        if (!empty($model)) {
            if ($model->status == UserBid::STATUS_ACCEPT)
                return 'Bạn đã đồng ý yêu cầu của khách hàng này';
            elseif ($model->status == UserBid::STATUS_NOACCEPT)
                return 'Bạn đã hủy yêu cầu của khách hàng này';
            elseif ($model->status == UserBid::STATUS_PENDING)
                return 'Bạn đang lam việc cho khách hàng này';
            else
                return 'Đang chờ chấp nhận';
        }
    }

    public static function getSkills($id) {
        $model = Skills::findOne($id);
        return $model;
    }

    public static function getCheckskill($id) {
        $model = User::findOne((string) $this->_id);
        $skills = $model['skills'];
        if ($skills) {
            if (!in_array($id, $skills)) {
                $active = "";
            } else {
                $active = "active";
            }
            return $active;
        }
    }

    public function getGetSkill() {
        $model = User::findOne((string) $this->_id);
        foreach ($model->sector as $sector) {
            $sectors = Sectors::findOne($sector);
            return $sectors->skills;
        }
    }

    public function getCountbossjob() {
        return Job::find()->where(['owner' => (string) $this->_id])->count();
    }

    public function getCountbossassign() {
        return Assignment::find()->where(['owner' => (string) $this->_id])->count();
    }

    public static function getSkillname($id) {
        $model = Skills::findOne($id);
        return $model->name;
    }

    public static function getCityname($id) {
        $model = City::findOne($id);
        return $model->name;
    }

    public static function getLevelname($id) {
        $model = Level::findOne($id);
        return $model->name;
    }

    public static function getDistrictname($id) {
        $model = District::findOne($id);
        return $model->name;
    }

    public function saveExits($user_id) {
        $model = PersonalStorage::find()->where(['owner' => (string) Yii::$app->user->identity->id, 'actor' => $user_id, 'status' => 1])->one();
        if (!empty($model))
            return TRUE;
        else
            return FALSE;
    }

    public static function getAuthkeyUser($email) {
        $model = User::find()->where(['email' => $email])->one();
        if (!empty($model)) {
            return $model->auth_key;
        } else {
            return Yii::$app->security->generateRandomString();
        }
    }

    public static function getUserbyemail($email) {
        return User::find()->where(['email' => $email])->one();
    }

    public static function getStar($num) {
        $str = '';
        for ($i = 0; $i < $num; $i++) {
            $str .= '<i class="fa fa-star"></i>';
        }
        for ($i = 0; $i < (5 - $num); $i++) {
            $str .= '<i class="fa fa-star-o"></i>';
        }
        return $str;
    }

    public static function getRating($id) {
        $query = new Query;
        $total = $query->select(['rating'])->from('reviews')->where(['owner' => (string) $id])->sum('rating');
        $count = count(Review::find()->where(['owner' => (string) $id])->all());
        if ($total > 0 && $count > 0) {
            $rating = round($total / $count);
        } else {
            $rating = 0;
        }
        $str = '';
        for ($i = 0; $i < $rating; $i++) {
            $str .= '<i class="fa fa-star"></i>';
        }
        for ($i = 0; $i < (5 - $rating); $i++) {
            $str .= '<i class="fa fa-star-o"></i>';
        }
        return $str;
    }

    public static function getPoint($id) {
        $query = new Query;
        $total = $query->select(['rating'])->from('reviews')->where(['owner' => (string) $id])->sum('rating');
        $count = count(Review::find()->where(['owner' => (string) $id])->all());
        if ($count > 0) {
            return round($total / $count) . '.0';
        } else {
            return 0;
        }
    }

    public function getCountReview() {
        return count(Review::find()->where(['owner' => (string) $this->_id])->all());
    }

    public static function getProgress($id) {
        $one_star = count(Review::find()->where(['owner' => (string) $id, 'rating' => 1])->all());
        $two_star = count(Review::find()->where(['owner' => (string) $id, 'rating' => 2])->all());
        $three_star = count(Review::find()->where(['owner' => (string) $id, 'rating' => 3])->all());
        $four_star = count(Review::find()->where(['owner' => (string) $id, 'rating' => 4])->all());
        $five_star = count(Review::find()->where(['owner' => (string) $id, 'rating' => 5])->all());
        return array(5 => $five_star, 4 => $four_star, 3 => $three_star, 2 => $two_star, 1 => $one_star);
    }

    public static function getComment($id) {
        return Review::find()->where(['owner' => (string) $id])->all();
    }

    public static function getTestpoint($id) {
        $query = new Query;
        $total = $query->select(['point'])->from('tests')->where(['user_id' => (string) $id, 'publish' => test::PUBLISH_DONE])->sum('point');
        $count = count(Test::find()->where(['user_id' => (string) $id, 'publish' => test::PUBLISH_DONE])->all());
        if ($count > 0) {
            return round($total / $count) . '.0';
        } else {
            return 0;
        }
    }

    public function getCountjobdone() {
        return count(Assignment::find()->where(['actor' => (string) $this->_id])->andWhere(['between','status_boss',Assignment::STATUS_COMPLETE,Assignment::STATUS_REVIEW])->all());
    }

    // public static function getJobAssignment($id) {
    //     return count(Assignment::find()->where(['actor' => (string) $id])->all());
    // }
}
