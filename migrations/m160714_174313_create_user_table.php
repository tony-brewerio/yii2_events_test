<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160714_174313_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'admin' => $this->boolean()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
