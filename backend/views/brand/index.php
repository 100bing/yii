
<table class="table">
    <tr>
        <th>ID</th>

        <th>名称</th>
        <th>简介</th>


        <th>logo图片</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>



    </tr>
    <?php foreach ($model as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>

            <td><img src="<?=$model->logo?>" style="width: 50px"></td>
            <td><?=$model->sort?></td>
            <td><?=\backend\models\Brand::$status[$model->status]?></td>



        




            <td><?=\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

                <?=\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

        </tr>

    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('增加',['brand/add'],['class'=>'btn btn-warning btn-xs'])?></td>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',

]);