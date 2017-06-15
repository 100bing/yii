<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_detail`.
 */
class m170608_104422_create_article_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_detail', [
            'artice_id' => $this->primaryKey()->comment('文章id'),
            'content'=>$this->text()->comment('简介'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_detail');
    }
}
