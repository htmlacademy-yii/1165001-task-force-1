<?php

use yii\db\Migration;

/**
 * Class m210924_220020_update_replies_table
 */
class m210924_220020_update_replies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('replies', 'budget', $this->integer());
        $this->dropForeignKey('replies_ibfk_1', 'replies');
        $this->dropForeignKey('replies_ibfk_2', 'replies');
        $this->dropColumn('replies', 'rate');
        $this->dropColumn('replies', 'sender_id');
        $this->renameColumn('replies', 'description', 'comment');
        $this->renameColumn('replies', 'sender_id', 'executor_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210924_220020_update_replies_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210924_220020_update_replies_table cannot be reverted.\n";

        return false;
    }
    */
}
