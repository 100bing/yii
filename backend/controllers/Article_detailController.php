<?php
namespace backend\controllers;
use backend\models\Article_detail;
use yii\web\Controller;

class Article_detailController extends Controller{
    //实现主页面的
    public function actionIndex($id){
       $model= Article_detail::findOne(['artice_id'=>$id]);
        if($model==null){
            \Yii::$app->session->setFlash('success','文章以三删除');
            return $this->redirect(['article/index']);

        }


        return $this->render('index',['model'=>$model]);

    }
}