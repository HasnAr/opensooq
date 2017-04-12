<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'type' => $this->enum('Cars', 'Mobiles', 'Tablets')->notNull()->unique(),
            ], $tableOptions);

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


        // $this->createTable('{{%postCat}}', [
        //     'post_id' => $this->integer()->notNull(),
        //     'cat_id' => $this->->integer()->notNull(),
        //     ], $tableOptions);

        $this->addForeignKey(
            'fk-post-cat_id',
            'post',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-post-cat_id',
            'post',
            'tag_id',
            'postTags',
            'tag_id',
            'CASCADE'
        );
        // $this->addForeignKey(
        //     'fk-cat-post_id',
        //     'postCat',
        //     'cat_id',
        //     'categories',
        //     'id',
        //     'CASCADE'
        // );
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
