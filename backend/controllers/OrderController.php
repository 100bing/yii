<?php
namespace backend\controllers;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\web\Controller;

class OrderController extends Controller{
    //订单后台增删改查
    public function actionIndex(){
        $model=Order::find()->all();
        $mo=new Order();

        return $this->render('index',['model'=>$model,'mo'=>$mo]);
    }


    public function actionAdd($id){
        $model=Order::find()->where(['id'=>$id])->all();
        foreach ($model as $model){
            $model->status=2;

            $model->save(false);


        }
        return $this->redirect(['order/index']);



    }
}