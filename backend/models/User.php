<?php
namespace backend\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

class User extends ActiveRecord implements IdentityInterface{
    public $password;
    public static $status=['1'=>'正常','0'=>'异常'];
  public $role=[];


    public static function getRoleOption(){
        $authManager=\Yii::$app->authManager;
        return ArrayHelper::map($authManager->getRoles(),'name','description');//获取所有权限
    }
    public function addUser($id){
        $authManager=\Yii::$app->authManager;

        foreach($this->role as $role){
            $role=$authManager->getRole($role);
            var_dump($role);
            if($role) {$authManager->assign($role,$id);}
        }
 }
    //修改会县
    public  function loadDate($roles){
//        $roles=\Yii::$app->authManager->getRole($roles);
        foreach ($roles as $role){
            $this->role[]=$role->name;
        }

//
//        }
    }
    public function updateRole($id){
        $authManager=\Yii::$app->authManager;
        if(User::findOne(['id'=>$id])){
            $authManager->revokeAll($id);
            $roles=$this->role;
            if($roles){
                foreach($roles as $role){
                    $authManager->assign($authManager->getRole($role),$id);
                }
            }
            return true;
        }else{
            throw new NotFoundHttpException('CUOWU');
        }


    }

    public function rules()
    {
        return [
            [['username', 'password','email','status','role'], 'required'],
            ['email', 'email'],
            [['username','email'],'unique']

//            [['ip','created_at'],'string','max'=>255],




        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password'=>'密码',
            'email'=>'电子邮箱',
               'status'=>'状态',
            'role'=>'角色'

        ];
    }
    public function behaviors(){

        return[
            'time'=>[
                'class'=>TimestampBehavior::className(),
                'attributes' =>[
                    self::EVENT_BEFORE_VALIDATE=>['created_at']

                ],
            ],


        ];
    }



    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
        // TODO: Implement findIdentity() method.
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
        // TODO: Implement getId() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey()==$authKey;
        // TODO: Implement validateAuthKey() method.
    }
}