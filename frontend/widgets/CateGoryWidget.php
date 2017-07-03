<?php
namespace frontend\widgets;

use backend\models\GoodsCategory;
use yii\base\Widget;

class CategoryWidget extends Widget{
    public function init(){
        parent::init();
    }
    public function run(){
        //检测redis是否有商品分类缓存
        $redis =new \Redis();
//        var_dump($redis);
//        exit;
    $redis->connect('127.0.0.1');
        $category_html = $redis->get('category_html');
        if($category_html==null){

        $categories = GoodsCategory::findAll(['parent_id'=>0]);
        $category_html = $this->renderFile('@app/widgets/view/category.php',['categories'=>$categories]);

//            $redis->set('category_html',$category_html);
     $redis->setex('category_html',3600000,$category_html);


        }
        return $category_html;

    }
}