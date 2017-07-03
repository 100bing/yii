<?=\yii\bootstrap\Html::a('主页',['goods/index'],['class'=>'btn btn-warning btn-xs'])?>
<table class="table">
    <tr>

        <th>Logo图片</th>


        <th>操作</th>



    </tr>
    <?php foreach ($model as $model):?>
        <tr>

            <td><img src="<?=$model->img?>" style="width: 50px"></td>





            <td>  <?php if(Yii::$app->user->can('goods_img/edit')){
                    echo \yii\bootstrap\Html::a('修改',['goods_img/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs']);}?>
                <?php if(Yii::$app->user->can('oods_img/delete')){
                    echo \yii\bootstrap\Html::a('删除',['goods_img/delete','id'=>$model->id],['class'=>'btn btn-warning btn-xs']);}?>


        </tr>

    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('增加',['goods_img/add','id'=>$id],['class'=>'btn btn-warning btn-xs'])?></td>
</table>