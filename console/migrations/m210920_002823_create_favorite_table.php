<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorite}}`.
 */
class m210920_002823_create_favorite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorite}}', [
            'id' => $this->primaryKey(),
            'liker' => $this->integer()->notNull(),
            'liked' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-favorite-liker',
            'favorite',
            'liker',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-favorite-liked',
            'favorite',
            'liked',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%favorite}}');

        $this->dropForeignKey(
            'k-favorite-liker',
            'favorite'
        );

        $this->dropForeignKey(
            'k-favorite-liked',
            'favorite'
        );
    }
}
