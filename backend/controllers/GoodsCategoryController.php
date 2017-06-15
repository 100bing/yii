<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class GoodsCategoryController extends \yii\web\Controller
{ //添加商品分类
    public function actionAdd(){
        $model=new GoodsCategory();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            //判断添加一级分类还是多级分类（
            if($model->parent_id){//添加飞以及
                $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);//获取上一级分类



        $model-> prependTo($parent);

            }else{
                $model->makeRoot();

            }//添加一级分类
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['goods-category/index']);
        }
//获取所有分类选项
    $categories=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','prrent_id'=>0]],GoodsCategory::find()->asArray()->all());

//     $option=ArrayHelper::map(GoodsCategory::find()->asArray()->all(),'id','name');




        return $this->render('add',['model'=>$model,'categories'=>$categories]);


    }
//修改方法
    public function actionEdit($id){
        $model=GoodsCategory::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('不存在');
        }
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            //判断添加一级分类还是多级分类（
            if($model->parent_id){//添加飞以及
                $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);//获取上一级分类



                $model-> prependTo($parent);

            }else{
                if($model->getOldAttribute('parent_id')==0){
                    $model->save();
                    \Yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect(['goods-category/index']);
                }
                $model->makeRoot();


            }//添加一级分类
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['goods-category/index']);
        }
//获取所有分类选项
        $categories=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','prrent_id'=>0]],GoodsCategory::find()->asArray()->all());

//     $option=ArrayHelper::map(GoodsCategory::find()->asArray()->all(),'id','name');




        return $this->render('add',['model'=>$model,'categories'=>$categories]);


    }
    public function actionIndex()

    {
        $model=GoodsCategory::find()->all();
        return $this->render('index',['model'=>$model]);
    }
    //
    public function actionDelete($id){


        if( !empty(GoodsCategory::findOne(['parent_id'=>$id]))){

            \Yii::$app->session->setFlash('danger','不能删除');
             return $this->redirect(['goods-category/index']);

        }
        GoodsCategory::findOne(['id'=>$id])->delete();
        return $this->redirect(['goods-category/index']);

    }
//测试
    public function actionTest()
    {
//        $j = new GoodsCategory();
//        $j->name ='佳佳';
//        $j->parent_id = 0;
//        $j->makeRoot();//设为一级分类；
//$parent=GoodsCategory::findOne(['id'=>1]);
//        //创建二级
//        $xjd=new GoodsCategory();
//        $xjd->name='小家电';
//        $xjd->parent_id=$parent->id;
//
//        $xjd-> prependTo($parent);
//        echo'ds';
        //获取所有一级分类
//        $roots=GoodsCategory::find()->roots()->all();
//        var_dump($roots);
        //获取该分类下的子舜分类
//        $parent=GoodsCategory::findOne(['id'=>1]);
//        $a=$parent->leaves()->all();
//        var_dump($a);


    }
    public function actionZtree(){
        $categories=GoodsCategory::find()->asArray()->all();
        return $this->renderPartial('ztree');
    }
}
