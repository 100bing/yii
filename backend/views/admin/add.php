<?php

$from=yii\bootstrap\ActiveForm::begin();




echo $from->field($model,'username');
echo $from->field($model,'password');

echo $from->field($model,'status')->radioList(\backend\models\Goods::$status);
echo $from->field($model,'email');
echo $from->field($model,'role')->checkboxList(\backend\models\User::getRoleOption());
echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();
