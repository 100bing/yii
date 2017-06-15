<?php
namespace backend\controllers;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
use crazyfd\qiniu\Qiniu;

class BrandController extends Controller{
    //设置增加方法
    public function actionAdd(){
        $model=new Brand();
        $requset=new Request();

        if($requset->isPost){
            $model->load($requset->post());
           //获取上传图片
//            $model->logo=UploadedFile::getInstance($model,'logo');
//            if($model->logo){
//                $filenName='/images/'.uniqid().'.'.$model->logo->extension;
//                $model->logo->saveAs(\Yii::getAlias('@webroot').$filenName.false);
//                $model->logo=$filenName;
//
//            }

            //验证数据
            if($model->validate()){
                //获取文件路径

                $model->save(false);

                return $this->redirect(['brand/index']);
            }

        }




        return $this->render('add',['model'=>$model]);
    }
    //设置修改方法
    public function  actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        $requset=new Request();

        if($requset->isPost){
            $model->load($requset->post());
            //获取上传图片
//            $model->logo=UploadedFile::getInstance($model,'logo');
//            if($model->logo){
//                $filenName='/images/'.uniqid().'.'.$model->logo->extension;
//                $model->logo->saveAs(\Yii::getAlias('@webroot').$filenName.false);
//                $model->logo=$filenName;
//
//            }

            //验证数据
            if($model->validate()){
                //获取文件路径

                $model->save(false);

                return $this->redirect(['brand/index']);
            }

        }




        return $this->render('add',['model'=>$model]);


    }
    //设置删除方法
    public function actionDelete($id){
        $model=Brand::findOne($id);
        $model->status='-1';

        $model->save(false);
        return $this->redirect(['brand/index']);

    }
    //设置显示主页的方法
    public function actionIndex(){
     $model= Brand::find()->where(['>','status',0]);

        $total=$model->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>1,

        ]);
        $cate=$model->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['model'=>$cate,'page'=>$page]);

    }

    public function actions(){
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,
            ],
            'ss-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
              /*  'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
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

//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
            },
            ],
        ];
    }
//    public  function actionTset(){
//
//$ak = 'j_v6K1ylBsT6P2K0XBF4Exkh0IvuyPNIEzotsfun';
//$sk = 'IPyLYqslbmuBuBN-7GJE92-TF_Q_EwpUDZjMQnjK';
//$domain = 'http://or9s3lb9y.bkt.clouddn.com';
//$bucket = 'yiishop';
//
//$qiniu = new Qiniu($ak, $sk,$domain, $bucket);
//        //要上的文件
//        $fileName=\Yii::getAlias('@webroot').'/upload/1.jpg';
//        $key='1.jpg';
////$key = time();
//$re=$qiniu->uploadFile($fileName,$key);
//
//$url = $qiniu->getLink($key);
//        var_dump($url);
//
//    }

}