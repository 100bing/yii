<?php
namespace frontend\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Locations extends ActiveRecord{
    public function rules()
    {
        return [
            ['name', 'required'],


        ];
    }

}