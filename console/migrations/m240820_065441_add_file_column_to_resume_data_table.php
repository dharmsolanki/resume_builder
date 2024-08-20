<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%resume_data}}`.
 */
class m240820_065441_add_file_column_to_resume_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%resume_data}}', 'file', $this->string()->null()->comment('File path'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%resume_data}}', 'file');
    }
}
