<?php
namespace backend\controllers;

use backend\models\Login;
use backend\models\Password;
use backend\models\User;
use yii\behaviors\TimestampBehavior;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller{
    //创建增加
    public function actionAdd(){
        $model=new User();
        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            if($model->validate()){
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['admin/login']);
    }

    //创建主页面
    public function actionIndex(){
        $model=User::find()->all();
        return $this->render('index',['model'=>$model]);
    }



    //判断用户是否登陆
    public function actionUser(){
        $user=\Yii::$app->user;

    }
    public function actionLogin(){
        $model=new Login();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $use=User::findOne(['id'=>\Yii::$app->user->id]);

                 $use->ip=\Yii::$app->request->userIP;
                $use->auth_key=\Yii::$app->security->generateRandomString();

                $use->updated_at=time();
//                var_dump($use);
//                exit;
                $use->save(false);

\Yii::$app->session->setFlash('success','登陆成功');

        return $this->redirect(['admin/index']);
            }

        }
        return $this->render('login',['model'=>$model]);
    }
    //修改密码
public function actionPassword(){
    $model=new Password();
$request= \Yii::$app->request;
      if($request->isPost){
          $model->load($request->post());
          if($model->validate()){
              $user=\Yii::$app->user->identity;
              $user->password=$model->newpassword;
              $user->password_hash= $user->password;
              if($user->save()){
                  \Yii::$app->session->setFlash('success','成功');
                  return $this->redirect(['admin/index']);
              }else{
                  var_dump($user->getErrors());
                  exit;
              }
          }
      }
    return $this->render('pass',['model'=>$model]);
}
    //chuangjian删除方法
    public function actionDelete($id){
        User::findOne(['id'=>$id])->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['admin/index']);
    }
    //创建修改方法
    public function actionEdit($id){
        $model=User::findOne(['id'=>$id]);

        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            if($model->validate()){
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }



    public function behaviors(){

        return[

            'acf'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [//未认证用户允许执行view操作
                        'allow'=>true,//是否允许执行
                        'actions'=>['login'],//指定操作
                        'roles'=>['?'],//角色？表示未认证用户  @表示已认证用户
                    ],
                    [//已认证用户允许执行add操作
                        'allow'=>true,//是否允许执行
                        'actions'=>['add','index','edit','user','password','logout','delete','login'],//指定操作
                        'roles'=>['@'],//角色？表示未认证用户  @表示已认证用户
                    ],



                ]
            ],

        ];
    }



}