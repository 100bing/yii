<?php

namespace backend\controllers;


use backend\models\Goods;
use backend\models\Goods_day_count;
use backend\models\Goods_img;
use backend\models\Goods_intro;
use backend\models\GoodsCategory;
use xj\uploadify\UploadAction;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

class GoodsController extends \yii\web\Controller
{
    //显示主页面
    public function actionIndex()
    {


$key=isset($_GET['key'])?$_GET['key']:'';
        $model=Goods::find()->where(['like','name',$key]);




        $total=$model->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>3,

        ]);
        $cate=$model->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['model'=>$cate,'page'=>$page]);
    }
//显示增加页面
     public function actionAdd(){
         $model=new Goods();
         $intro=new Goods_intro();
         $img=new Goods_img();
        $goods_day_count= new Goods_day_count();
         $goods=new GoodsCategory();
       if(\Yii::$app->request->isPost){
           $model->load(\Yii::$app->request->post());
           $intro->load(\Yii::$app->request->post());

           if($model->validate()&&$intro->validate()&&$model->validate()){
               $day=date('Ymd');
           if(!empty( Goods_day_count::findOne(['day'=>$day])->count)){
               $goods_day_count=Goods_day_count::findOne(['day'=>$day]);
//               $goods_day_count->day=$day;
               $goods_day_count->count+=1;
               $goods_day_count->save();
           }else{
               $goods_day_count->day=$day;
               $goods_day_count->count=1;
               $goods_day_count->save();
           }
               $model->sn=$day.str_pad($goods_day_count->count,6,0,STR_PAD_LEFT);



               $model->save();
               $intro->goods_id=$model->id;
               $intro->save();
               $img->img=$model->logo;
               $img->goods_id=$model->id;
               $img->save();





               $model->save(false);

               return $this->redirect(['goods/index']);
           }
       }


         $categories=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','prrent_id'=>0]],GoodsCategory::find()->asArray()->all());

    return $this->render('add',['model'=>$model,'intro'=>$intro,'goods'=>$goods,'categories'=>$categories]);

}
    //xiugai
    public function actionEdit($id){
        $model=Goods::findOne(['id'=>$id]);
      $intro=Goods_intro::findOne(['goods_id'=>$id]);


        $goods=GoodsCategory::findOne(['id'=>$id]);
       $img= Goods_img::find(['goods_id'=>$id]);

        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            $intro->load(\Yii::$app->request->post());

            if($model->validate()&&$intro->validate()&&$model->validate()){





                $model->save();
                $intro->goods_id=$model->id;
                $intro->save();
                $img->img=$model->logo;
                $img->goods_id=$model->id;
                $img->save();




                $model->save(false);

                return $this->redirect(['goods/index']);
            }
        }


        $categories=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','prrent_id'=>0]],GoodsCategory::find()->asArray()->all());

        return $this->render('add',['model'=>$model,'intro'=>$intro,'goods'=>$goods,'categories'=>$categories]);

    }
    //增加删除方法
    public function actionEdlete($id){
        Goods::findOne(['id'=>$id])->delete();
        Goods_intro::findOne(['good_id'=>$id])->delete();




        \Yii::$app->session->setFlash('success','删除成功');
        //返回主页面
        return $this->redirect(['goods/index']);

    }

    public function actions(){
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,
            ],
            'ueditor' => [
                'class' => 'crazyfd\ueditor\Upload',
                'config'=>[
                    'uploadDir'=>date('Y/m/d')
                ]

            ],
            'ss-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default

                'overwriteIfExist' => true,

                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {


                    $img= $action->getWebUrl();

//                    $action->output['fileUrl'] = $action->getWebUrl();
                    //设置七牛云
                    $qiniu=\Yii::$app->qiniu;
                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$img,$img);
                    //获取七牛云地址
                    $url = $qiniu->getLink($img);
                    $action->output['fileUrl'] =$url;


                },
            ],
        ];
    }



}
