<?php

use yii\db\Migration;

/**
 * Handles the creation for table `template`.
 */
class m160718_173403_create_notification_template_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('notification_template', [
            'id' => $this->primaryKey(),
            'event' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),
            'sender_id' => $this->integer()->null(),
            'target_mode' => $this->string(255)->notNull(),
            'target_id' => $this->integer()->null(),
            'notify_database' => $this->boolean()->notNull(),
            'notify_email' => $this->boolean()->notNull(),
        ]);
        $this->addForeignKey('notification_template_sender_fk', 'notification_template', 'sender_id', 'user', 'id');
        $this->addForeignKey('notification_template_target_fk', 'notification_template', 'target_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('notification_template');
    }
}
