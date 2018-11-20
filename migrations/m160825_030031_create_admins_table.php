<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admins`.
 */
class m160825_030031_create_admins_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admins', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'accessToken' => $this->string()->defaultValue(''),
            'authKey' => $this->string()->defaultValue(''),
            'createdAt' => $this->integer()->defaultValue(0),
            'updatedAt' => $this->integer()->defaultValue(0),
            'status' => $this->integer()->defaultValue(0),
        ]);

        $this->createIndex(
            'email_status_index',
            'admins',
            'email',
            'status'        
        );
        
        $this->createIndex(
            'accessToken_index',
            'admins',
            'accessToken'      
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admins');
        $this->dropIndex('email_status_index');
        $this->dropIndex('accessToken_index');
    }
}
