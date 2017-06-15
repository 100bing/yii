<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Goods_img extends ActiveRecord{


    //创建规则
    public function rules(){
        return[
            [['img'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'img' => '图片'
        ];
    }

}
