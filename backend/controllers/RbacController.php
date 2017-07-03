<?php
namespace backend\controllers;
use backend\models\PermissionFrom;
use backend\models\RoleFrom;
use backend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RbacController extends Controller{
    //权限的正删改查
    //添加权限
    public function actionAddPermission(){
        $model=new PermissionFrom();
        //判断加载的数据
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
            //判断￥model是否通过
            if($model->addPermission()){
                \Yii::$app->session->setFlash('success','权限添加成功');
                return $this->redirect(['permission-index']);
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }

    //创建显示主页面
    public function actionPermissionIndex(){
        $model=\Yii::$app->authManager->getPermissions();

        return $this->render('permission-index',['model'=>$model]);

    }
    //创建修改权限
    public function actionEditPermission($name){
        $permission=\Yii::$app->authManager->getPermission($name);
        if($permission==null){
            throw new NotFoundHttpException('权限不存在');

        }
           //穿件对象
        $model=new PermissionFrom();
       //因为不是活动记录所以需要自己赋值

        $model->loadData($permission);

//        判断验证加载是否成功
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
            //panduan是否修改
            if($model->updatePermission($name)){
                \Yii::$app->session->setFlash('success','权限修改成功');
                return $this->redirect(['permission-index']);
            }

        }
        return $this->render('add-permission',['model'=>$model]);

    }
    //删除权限
    public function actionDelPermission($name){
        $permission=\Yii::$app->authManager->getPermission($name);
        if($permission==null){
            throw new NotFoundHttpException('权限不存在');
        }
        \Yii::$app->authManager->remove($permission);
        \Yii::$app->session->setFlash('success','权限删除成功');
        return $this->redirect(['permission-index']);
    }

    //角色的增删改查
    //创建角色
    public function actionAddRole(){
        $model= new RoleFrom();

        //判断是否通过验证和post提交
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->addRole()){
                \Yii::$app->session->setFlash('success','角色添加成功');
                return $this->redirect(['role-index']);
            }
        }
        return $this->render('add-role',['model'=>$model]);
    }
    //显示角色列表
    public function actionRoleIndex(){
        $model=\Yii::$app->authManager->getRoles();

        return $this->render('role-index',['model'=>$model]);
    }
    //创建修改方法
    public function actionEditRole($name){
        $role=\Yii::$app->authManager->getRole($name);
        if($role==null){
            throw new NotFoundHttpException('角色不存在');
        }
        $model=new RoleFrom();
        $model->loadData($role);
        if($model->load(\Yii::$app->request->post())&&$model->validate()) {
            if ($model->updateRole($name)) {

            \Yii::$app->session->setFlash('success', '角色修改成功');
            return $this->redirect(['role-index']);
            }
        }
        return $this->render('add-role',['model'=>$model]);

    }
    //删除角色
    public function actionDelRole($name){
        $role=\Yii::$app->authManager->getRole($name);
        if($role==null){
            throw new NotFoundHttpException('角色不存在');
        }
        \Yii::$app->authManager->remove($role);
        \Yii::$app->session->setFlash('success','角色删除成功');
        return $this->redirect(['role-index']);
    }
    //增加用户
    public function actionAddUser(){
      $model= new User();
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
            if($model->addUser()){

            }
        }
        return $this->render('add-user',['model'=>$model]);

    }


}