<?php
namespace backend\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class Goods_intro extends ActiveRecord{

    //创建规则
   public function rules(){
       return[
           ['content','required']
       ];
   }
    public function attributeLabels()
    {
        return [
            'content' => '商品描述'
        ];
    }
}