
<table class="table">
    <tr>
        <th>ID</th>
        <th>用户id</th>


        <th>状态</th>

        <th>发货</th>





    </tr>
    <?php foreach ($model as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->member_id?></td>

            <td><?=\frontend\models\Order::$status[$model->status]?></td>
            <td><?=$model->status==1?\yii\helpers\Html::a('亲需要发货吗',['order/add','id'=>$model->id],['class'=>'btn btn-info btn-xs']):'我的天'?></td>
          </tr>
    <?php endforeach;?>


</table>