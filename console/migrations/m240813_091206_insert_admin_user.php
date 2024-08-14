<?php

use yii\db\Migration;

/**
 * Class m240813_091206_insert_admin_user
 */
class m240813_091206_insert_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'role' => 1,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('Drc@1234'),
            'email' => 'admin@gmail.com',
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240813_091206_insert_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240813_091206_insert_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
