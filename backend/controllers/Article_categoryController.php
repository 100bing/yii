<?php


namespace backend\controllers;


use backend\models\Article;
use backend\models\Article_category;
use yii\web\Controller;

class Article_categoryController extends Controller
{
    //文章分类
    public function actionIndex($id){
$model=Article_category::findOne(['id'=>$id]);




        return $this->render('index',['model'=>$model]);

    }
    //增加add方法
    public function actionAdd(){
        $model=new Article_category();



        //判断提交方式
        if( \Yii::$app->request->isPost ){
            $model->load(\Yii::$app->request->post());
            //验证数据

            if($model->validate()){
                //保存数据
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article_category/index']);

            }else{
                var_dump($model->getFirstErrors());
            }


        }




        return $this->render('add',['model'=>$model]);
    }
    //增加删除方法
    public function actionDelete($id){
        $mp= Article_category::findOne(['id'=>$id]);
        if($mp==null){
            return $this->redirect(['article/index']);
        }
        Article_detail::findOne(['id'=>$id])->delete();




        return $this->redirect(['article/index']);


    }
    public function actionEdit($id){
        $model= Article_category::findOne(['id'=>$id]);




        //判断提交方式
        if( \Yii::$app->request->isPost ){
            $model->load(\Yii::$app->request->post());
            //验证数据

            if($model->validate()){
                //保存数据
                $model->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article_category/index']);

            }else{
                var_dump($model->getFirstErrors());
            }


        }




        return $this->render('add',['model'=>$model]);
    }



}

