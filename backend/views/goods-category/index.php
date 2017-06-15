
<table class="table">
    <tr>
        <th>ID</th>

        <th>名称</th>


        <th>父id</th>
        <th>介绍</th>

        <th>操作</th>



    </tr>
    <?php foreach ($model as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->parent_id==0?'顶级分类':$model->goodsCategory->name?></td>
            <td><?=$model->intro?></td>

            <td><?=\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

                <?=\yii\bootstrap\Html::a('删除',['goods-category/delete','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

        </tr>

    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('增加',['goods-category/add'],['class'=>'btn btn-warning btn-xs'])?></td>
</table>
<?php
////分页工具条
//echo \yii\widgets\LinkPager::widget([
//    'pagination'=>$page,
//    'nextPageLabel'=>'下一页',
//    'prevPageLabel'=>'上一页',
//
//]);