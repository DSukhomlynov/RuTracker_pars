<?php

use yii\db\Migration;

/**
 * Handles the creation of table `data`.
 */
class m170714_132844_create_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('data', [
            'id' => $this->primaryKey(),
            'login' => $this->string(),
            'password' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('data');
    }
}
