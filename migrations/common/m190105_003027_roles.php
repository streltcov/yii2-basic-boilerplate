<?php

use yii\db\Migration;

/**
 * Class m180406_003027_accesstokens
 */
class m190105_003027_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('roles', [
            'id' => $this->primaryKey(),
            'role' => $this->string()->notNull()
        ]);

        $this->batchInsert('roles', ['role'], [
            ['user'],
            ['administrator'],
            ['supervisor']
        ]);
    } // end function


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('roles');
        return true;
    } // end function

} // end class
