<?php


$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'name')->textInput();
echo $from->field($model,'intro')->textarea();
echo $from->field($ac,'content')->textarea();
echo $from->field($model,'article_category_id')->dropDownList(\yii\helpers\ArrayHelper::map($user,'id','name'));
echo $from->field($model,'sort')->textarea();
echo $from->field($model,'status')->radioList(\backend\models\Article_category::$status);




echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
$from=\yii\bootstrap\ActiveForm::end();
