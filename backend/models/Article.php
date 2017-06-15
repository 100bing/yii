<?php
namespace backend\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Article extends ActiveRecord{
    public static $status=['0'=>'隐藏','1'=>'正常','-1'=>'删除'];
    public function rules(){
        return[
            [['name','intro','sort','status','article_category_id'],'required'],
        ];
    }
    public function attributeLabels(){

        return[
            'name'=>'名称',
            'intro'=>'简介',
            'sort'=>'排序',
            'status'=>'状态',
            'article_category_id'=>'文章分类id',



        ];
    }
    public function behaviors(){

        return[
            'time'=>[
                'class'=>TimestampBehavior::className(),
                'attributes' =>[
                    self::EVENT_BEFORE_VALIDATE=>['create_time']


                ],
            ]

        ];
    }
    //对应关系
    public function getArticel_category(){
        return $this->hasOne(Article_category::className(),['id'=>'article_category_id']);

    }
}


