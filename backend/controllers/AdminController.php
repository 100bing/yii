<?php
namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Login;
use backend\models\Password;
use backend\models\User;
use yii\behaviors\TimestampBehavior;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AdminController extends Controller{
    public function behaviors(){

        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add','delete','index','edit','password','user'],





            ]

        ];
    }



    public function actionYi(){
    $model=new User();
    $model->username='admin';
    $model->password_hash=\Yii::$app->security->generatePasswordHash(123456);

    $model->email='admin@admin.com';
    $model->auth_key=\Yii::$app->security->generateRandomString();

    $model->save(false);
    return $this->redirect(['admin/login']);



}

    //创建增加
    public function actionAdd(){
        $model=new User();
        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            if($model->validate()){
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password);



       $model->save();
              ;
               $model->addUser( $model->id);


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



            $role=\Yii::$app->authManager->getRolesByUser($id);
            if($role==null){
                throw new NotFoundHttpException('honghu不存在');
            }
            \Yii::$app->authManager->revokeAll($id);


        User::findOne(['id'=>$id])->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['admin/index']);
    }
    //创建修改方法
    public function actionEdit($id){
        $model=User::findOne(['id'=>$id]);
        $authManager=\Yii::$app->authManager;
        $roles=$authManager->getRolesByUser($id);
        $model->loadDate($roles);

        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            if($model->validate()){
        if($model->updateRole($id)){
            $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
            $model->save();
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['admin/index']);
        }

            }
        }
        return $this->render('add',['model'=>$model]);
    }

}