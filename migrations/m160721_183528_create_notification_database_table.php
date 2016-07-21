<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notification_database`.
 */
class m160721_183528_create_notification_database_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('notification_database', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer(),
            'target_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),
            'viewed' => $this->boolean()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);
        $this->addForeignKey('notification_database_sender_fk', 'notification_database', 'sender_id', 'user', 'id');
        $this->addForeignKey('notification_database_target_fk', 'notification_database', 'target_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('notification_database');
    }
}
