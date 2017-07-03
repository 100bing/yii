<?php

$from=yii\bootstrap\ActiveForm::begin();




echo $from->field($model,'label');
echo $from->field($model,'url');

echo $from->field($model,'parent_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Menu::find()->all(),'id','label'),['prompt'=>'请选择']);
echo $from->field($model,'sort');

echo yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();
