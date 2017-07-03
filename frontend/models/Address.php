<?php
namespace frontend\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Address extends  ActiveRecord{

    public static function tableName()
    {
        return 'address';
    }
    public function rules()
    {
        return [
            [['name', 'province', 'city', 'county', 'detail', 'tel'], 'required'],
            [['member_id', 'is_default'], 'integer'],
            [['name', 'province', 'city', 'county'], 'string', 'max' => 100],
            [['detail'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
        ];
    }

    public function attributeLabels()
    {
        return [

            'name'=>'收货人',
            'member_id' => '所属用户',
            'tel'=>'电话',
            'detail'=>'详细地址',

             'province'=>'省',
              'city'=>'市',
             'county'=>'县',
            'is_default' => '是否默认地址',
            ];
    }


}