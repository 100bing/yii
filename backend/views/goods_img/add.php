<?php
use yii\web\JsExpression;
$from=yii\bootstrap\ActiveForm::begin();



echo $from->field($model,'img')->hiddenInput();
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['ss-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
           'formData'=>['goods_id'=>$id],//上传文件
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
//      $("#img_logo").attr('src',data.fileUrl).show();
//
//
//       $("#goods_img-img").val(data.fileUrl);
         var html='<tr  id="'+data.goods_id+'"><td><img src="'+data.fileUrl+'"/></td></tr>';
        $("#img-table").append(html);
   }
}
EOF
        ),
    ]
]);
if($model->img){
    echo\yii\helpers\Html::img($model->img,['height'=>'50']);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'50']);
}

echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();
?>
<table id="img-table">

</table>
