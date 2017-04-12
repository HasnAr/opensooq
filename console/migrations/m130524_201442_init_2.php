<?php

use yii\db\Migration;

class m130524_201442_init_2 extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'tag' => $this->string(32)->notNull()->unique(),
            ], $tableOptions);

        $this->createTable('{{%postTags}}', [
            'post_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            ], $tableOptions);

        $this->addForeignKey(
            'fk-post-tag_id',
            'postTags',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-tag-post_id',
            'postTags',
            'tag_id',
            'tags',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        $this->dropTable('{{%tags}}');
    }
}
