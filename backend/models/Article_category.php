<?php
namespace backend\models;
use yii\db\ActiveRecord;

class Article_category extends ActiveRecord{
    public static $is_help=['0'=>'不需要帮助','1'=>'帮助'];
    public static $status=['0'=>'隐藏','1'=>'正常','-1'=>'删除'];
    public function rules(){
        return[
            [['name','intro','sort','status','is_help'],'required'],
        ];
    }
    public function attributeLabels(){

        return[
            'name'=>'名称',
            'intro'=>'简介',
            'sort'=>'排序',
            'status'=>'状态',

            'is_help'=>'类型',

        ];
    }
}