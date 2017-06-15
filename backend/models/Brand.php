<?php
namespace backend\models;
use yii\db\ActiveRecord;

class Brand extends ActiveRecord{
    //定义验证规则
    public $code;
   public static $status=['0'=>'隐藏','1'=>'显示','-1'=>'以标记删除'];
    public function rules(){
        return[
            [['name','intro','sort','status','code'],'required'],
//            ['logo','file','extensions'=>'jpg,png,gif'],
            ['logo','string'],
        ];

    }

//设置名字
    public function attributeLabels(){
        return[
            'name'=>'名称',
            'intro'=>'简介',
            'logo'=>'LOGO图片',
            'sort'=>'排序',
            'status'=>'状态',
            'code'=>'验证码',
        ];
    }
}