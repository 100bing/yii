<?php
namespace backend\models;
use yii\base\Model;

class Password extends Model{
    public $oldpassword;
    public $repassword;
    public $newpassword;


    public function rules()
    {

        return [
            [['oldpassword','newpassword','repassword'], 'required'],
            ['oldpassword','validatePassword'],

            //新密码
            ['repassword','compare','compareAttribute'=>'newpassword','message'=>'两次密码不一样'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'oldpassword' => '旧密码',
            'newpassword'=>'新密码',
            'repassword'=>'确认密码'
        ];
    }
    //修改密码
    public function validatePassword(){

        $passwordHash=\Yii::$app->user->identity->password_hash;
        $password=$this->oldpassword;
        if(!\Yii::$app->security->validatePassword($password,$passwordHash)){
            $this->addError('oldpassword','旧密码不整齐');
        }



    }

}