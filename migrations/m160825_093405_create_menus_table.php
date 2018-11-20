<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menus`.
 */
class m160825_093405_create_menus_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menus', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'uname' => $this->string()->notNull()->unique(),
            'icon' => $this->string()->notNull()->defaultValue(''),
            'desc' => $this->string()->notNull()->defaultValue(''),
            'keywords' => $this->string()->notNull()->defaultValue(''),
            'uuid' => $this->string()->notNull()->defaultValue(''),
            'pid' => $this->integer()->defaultValue(0),
            'sortNo' => $this->integer()->defaultValue(0),
            'type' => $this->integer()->defaultValue(0),
            'status' => $this->integer()->defaultValue(0),
            'createdAt' => $this->integer()->defaultValue(0),
            'updatedAt' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menus');
    }
}
