
<table class="table">
    <tr>
        <th>ID</th>

        <th>名称</th>
        <th>简介</th>



        <th>排序</th>
        <th>状态</th>
        <th>帮助</th>
        <th>操作</th>



    </tr>
<!--    --><?php //foreach ($model as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->intro?></td>


        <td><?=$model->sort?></td>
        <td><?=\backend\models\Article_category::$status[$model->status]?></td>
        <td><?=\backend\models\Article_category::$is_help[$model->is_help]?></td>








        <td><?=\yii\bootstrap\Html::a('修改',['article_category/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

            <?=\yii\bootstrap\Html::a('删除',['article_category/delete','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

    </tr>

<?php //endforeach;?>
<?=\yii\bootstrap\Html::a('增加',['article_category/add'],['class'=>'btn btn-warning btn-xs'])?></td>
</table>