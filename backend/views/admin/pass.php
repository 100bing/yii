<?php

$from=yii\bootstrap\ActiveForm::begin();




echo $from->field($model,'oldpassword');
echo $from->field($model,'newpassword');


echo $from->field($model,'repassword');
echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();
