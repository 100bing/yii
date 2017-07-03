<?php
namespace backend\models;


use yii\base\Model;

class Login extends Model{
    public $password;
    public $username;
    public $rememberMe;
    public function rules()
    {

        return [
            [['username','password'], 'required'],
            ['rememberMe','boolean'],

            ['username','validateUsername'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password'=>'密码',
            'rememberMe'=>'记住我',
        ];
    }
    //自定义方法
    public function validateUsername(){
        $asd=User::findOne(['username'=>$this->username]);
        if($asd){

            if(!\Yii::$app->security->validatePassword($this->password,$asd->password_hash)){
                $this->addError('password','密码不正确');
            }else{

                $asd->ip=\Yii::$app->request->userIP;
                $asd->auth_key=\Yii::$app->security->generateRandomString();


                $asd->updated_at=time();
                $asd->save(false);
                $duration=$this->rememberMe?7*24*3600:0;
                \Yii::$app->user->login($asd,$duration);
            }
        }else{
            //
            $this->addError('username','账号不正确');
        }
    }

}