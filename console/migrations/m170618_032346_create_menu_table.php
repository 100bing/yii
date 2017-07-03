<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170618_032346_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'label'=>$this->string(20)->notNull()->comment('����'),
            'url'=>$this->string(255)->comment('��ַ/·��'),
            'parent_id'=>$this->integer()->comment('�ϼ��˵�'),
            'sort'=>$this->integer()->comment('����'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
