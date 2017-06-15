<?php


$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'name')->textInput();
echo $from->field($model,'intro')->textarea();
echo $from->field($model,'sort')->textarea();
echo $from->field($model,'status')->radioList(\backend\models\Article_category::$status);
echo $from->field($model,'is_help')->radioList(\backend\models\Article_category::$is_help);



echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
$from=\yii\bootstrap\ActiveForm::end();
