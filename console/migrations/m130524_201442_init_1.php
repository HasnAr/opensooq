<?php

use yii\db\Migration;

class m130524_201442_init_1 extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        

        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'type' => "ENUM('phones', 'tablets', 'cars')"
            ], $tableOptions);

       

        
        
        

        $this->addForeignKey(
            'fk-post-cat_id',
            'post',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
       
        
    }

    public function down()
    {
        $this->dropTable('{{%categories}}');
    }
}
