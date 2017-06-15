<?php
use yii\web\JsExpression;
 $from=yii\bootstrap\ActiveForm::begin();


echo $from->field($model,'name');
echo $from->field($model,'stock')->textInput();
echo $from->field($intro, 'content')->widget(crazyfd\ueditor\Ueditor::className(),[]) ;
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
        $("#goods-logo").val(data.fileUrl);


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
echo $from->field($model,'goods_category_id')->hiddenInput();
echo '  <ul id="treeDemo" class="ztree"></ul>';
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNodes=\yii\helpers\Json::encode($categories);
$js=new \yii\web\JsExpression(
    <<<JS
     var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
		onClick: function (event, treeId, treeNode) {
     //console.log(treeNode.id );
     //赋值
     $('#goods-goods_category_id').val(treeNode.id);

}

        }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes ={$zNodes};

        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);
        //获取父节点 更具id
        var node=zTreeObj.getNodeByParam("id", $('#goodscategory-parent_id').val(),null);
        zTreeObj.selectNode(node);



JS

);
$this->registerJs($js);

echo $from->field($model,'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Brand::find()->all(),'id','name'));
echo $from->field($model,'market_price');
echo $from->field($model,'shop_price');
echo $from->field($model,'is_on_sale')->radioList(\backend\models\Goods::$is_on_sale);
echo $from->field($model,'status')->radioList(\backend\models\Goods::$status);
echo $from->field($model,'sort');
echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();

