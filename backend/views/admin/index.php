
<table class="table">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>密码</th>
        <th>token</th>
        <th>email</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>登陆时间</th>
        <th>ip</th>

        <th>操作</th>



    </tr>
    <?php foreach ($model as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->username?></td>
            <td><?=$model->password_hash?></td>



            <td><?=$model->password_reset_token?></td>
            <td><?=$model->email?></td>
            <td><?=\backend\models\User::$status[$model->status]?></td>
            <td><?=date('Y-m-d H:i:s',$model->created_at)?></td>
            <td><?=date('Y-m-d H:i:s',$model->updated_at)?></td>

            <td><?=$model->ip?></td>





            <td><?=\yii\bootstrap\Html::a('修改',['admin/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

                <?=\yii\bootstrap\Html::a('删除',['admin/delete','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>

        </tr>

    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('增加',['admin/add'],['class'=>'btn btn-warning btn-xs'])?></td>
    <?=\yii\bootstrap\Html::a('推出',['admin/logout'],['class'=>'btn btn-warning btn-xs'])?></td>
</table>