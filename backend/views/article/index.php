
<table class="table">
    <tr>
        <th>ID</th>

        <th>名称</th>
        <th>简介</th>


        <th>文章分类id</th>
        <th>排序</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>查看详情</th>

        <th>文章分类详情</th>
        <th>操作</th>




    </tr>
    <?php foreach ($model as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?=$model->article_category_id?></td>


            <td><?=$model->sort?></td>
            <td><?=\backend\models\Article_category::$status[$model->status]?></td>
            <td><?=date('Y-m-d G-i-s',$model->create_time)?></td>
            <td><?=\yii\bootstrap\Html::a('查看',['article_detail/index','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
              </td>
            <td><?=\yii\bootstrap\Html::a('查看',['article_category/index','id'=>$model->article_category_id],['class'=>'btn btn-info btn-xs'])?>
            </td>









            <td><?=\yii\bootstrap\Html::a('修改',['article/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

                <?=\yii\bootstrap\Html::a('删除',['article/delete','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

        </tr>

    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('增加',['article/add'],['class'=>'btn btn-info btn-xs'])?></td>
</table>