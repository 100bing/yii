<?php
namespace backend\models;


use yii\db\ActiveRecord;

class Goods_day_count extends ActiveRecord{
    public function rules(){
        return[
            ['count','required']
        ];
    }
    public function attributeLabels()
    {
        return [
            'count' => '商品数'
        ];
    }

}