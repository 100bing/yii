<?php
namespace backend\controllers;


use backend\models\Article;
use backend\models\Article_category;
use backend\models\Article_detail;
use yii\web\Controller;

class ArticleController extends Controller{
    //显示文章的主页面

    public function actionIndex(){
        //实例化对象

       $model= Article::find()->all();

        //显示页面
        return $this->render('index',['model'=>$model]);
    }

    //实现增加方法
    public function actionAdd(){
        //实力话对象
        $model= new Article();
        $user=Article_category::find()->all();
          $ac=new Article_detail();

            //判断是不是post方式提交
        if(  \Yii::$app->request->isPost);
        //加载数据
        $model->load(\Yii::$app->request->post());
          $ac->load(\Yii::$app->request->post());


        //验证数据
        if($model->validate()&& $ac->validate()){
            //保存数据
            $ac->save();
            $model->save();
            //tishi信息
            \Yii::$app->session->setFlash('success','添加成功');
            //返回主页面
            return $this->redirect(['article/index']);

        }
        //返回add页面
        return $this->render('add',['model'=>$model,'user'=>$user,'ac'=>$ac]);
    }

    //正价修改方法
    public function actionEdit($id){



        $model= Article::findOne(['id'=>$id]);
        $user=Article_category::find()->all();
        $ac=Article_detail::findOne(['artice_id'=>$id]);
        if($ac==null){
            \Yii::$app->session->setFlash('success','文章以三删除');
            return $this->redirect(['article/index']);

        }

        //判断是不是post方式提交
        if( \Yii::$app->request->isPost);
        //加载数据
        $model->load(\Yii::$app->request->post());
        $ac->load(\Yii::$app->request->post());


        //验证数据
        if($model->validate()&& $ac->validate()){
            //保存数据
            $ac->save();
            $model->save();
            //tishi信息
            \Yii::$app->session->setFlash('success','修改成功');
            //返回主页面
            return $this->redirect(['article/index']);

        }
        //返回add页面
        return $this->render('add',['model'=>$model,'user'=>$user,'ac'=>$ac]);

    }
    //增加删除方法
    public function actionDelete($id){
      $mp= Article_detail::findOne(['artice_id'=>$id]);
        if($mp==null){
            return $this->redirect(['article/index']);
        }
       Article_detail::findOne(['artice_id'=>$id])->delete();



        $m=Article::findOne($id);
         $m->status='-1';

        $m->save(false);
        return $this->redirect(['article/index']);


    }

}