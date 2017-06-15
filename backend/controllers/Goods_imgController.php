<?php
namespace backend\controllers;


use backend\models\Goods_img;
use xj\uploadify\UploadAction;
use yii\web\Controller;

class Goods_imgController extends Controller{

    public function actionIndex($id){
        $model= Goods_img::find()->where(['goods_id'=>$id])->all();

    return $this->render('index',['model'=>$model,'id'=>$id]);
    }

    public function actionAdd($id){
       $model=new Goods_img();
        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());

            if($model->validate()){


                $model->goods_id=$id;
                $model->save();

            }



        }
        return $this->render('add',['model'=>$model,'id'=>$id]);
    }
    //修改
public function actionEdit($id){
   $model= Goods_img::findOne(['id'=>$id]);
    if(\Yii::$app->request->isPost){
        $model->load(\Yii::$app->request->post());

        if($model->validate()){


            $model->goods_id=$id;
            $model->save();

        }



    }
    return $this->render('add',['model'=>$model]);
}
    //shangchu
    public function actionDelete($id){
        Goods_img::findOne(['id'=>$id])->delete();
        return $this->redirect(['goods/index']);

    }


    public function actions(){
        return [
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
                    $model=new Goods_img();

                    $model->goods_id=\Yii::$app->request->post('goods_id');
                   $img= $model->img=$action->getWebUrl();
                    $model->save();
//                    $img= $action->getWebUrl();
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
