<?php
use yii\web\JsExpression;

$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'name')->textInput();

echo $from->field($model,'intro')->textarea();
echo $from->field($model,'logo')->hiddenInput();
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['ss-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
      $("#img_logo").attr('src',data.fileUrl).show();
        $("#brand-logo").val(data.fileUrl);


    }
}
EOF
        ),
    ]
]);
if($model->logo){
    echo\yii\helpers\Html::img($model->logo,['height'=>'50']);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'50']);
}

echo $from->field($model,'sort')->textInput();

echo $from->field($model,'status')->radioList(\backend\models\Brand::$status);

echo $from->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction'=>'brand/captcha',
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>'
]);
echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
$from=\yii\bootstrap\ActiveForm::end();
