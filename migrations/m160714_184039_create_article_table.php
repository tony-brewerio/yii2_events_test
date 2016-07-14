<?php

use yii\db\Migration;

/**
 * Handles the creation for table `article`.
 */
class m160714_184039_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),
        ]);
        $this->addForeignKey('article_user_fk', 'article', 'author_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
