<?php

$from=yii\bootstrap\ActiveForm::begin();




echo $from->field($model,'username');
echo $from->field($model,'password');
echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();
