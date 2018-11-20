<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m160831_125747_create_articles_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->defaultValue(''),
            'second_title' => $this->string()->notNull()->defaultValue(''),
            'top_menu_id' => $this->integer()->notNull()->defaultValue(0),
            'menu_id' => $this->integer()->notNull()->defaultValue(0),
            'keyword' => $this->string()->defaultValue(''),
            'uname' => $this->string()->defaultValue(''),
            'content' => $this->string()->defaultValue(''),
            'author_id' => $this->integer()->defaultValue(0),
            'author_name' => $this->string()->defaultValue(''),
            'createdAt' => $this->integer()->defaultValue(0),
            'updatedAt' => $this->integer()->defaultValue(0),
            'publish_time' => $this->integer()->defaultValue(0),
            'status' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('articles');
    }
}
