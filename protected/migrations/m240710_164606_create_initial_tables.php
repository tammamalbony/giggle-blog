<?php

class m240710_164606_create_initial_tables extends CDbMigration
{
	public function up()
	{
		 // Create 'user' table
		 $this->createTable('user', array(
            'id' => 'pk',
            'email' => 'varchar(255) NOT NULL UNIQUE',
            'password' => 'varchar(255) NOT NULL',
            'verification_token' => 'varchar(255) DEFAULT NULL',
            'is_verified' => 'tinyint(1) NOT NULL DEFAULT 0',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        // Create 'blog_post' table
        $this->createTable('blog_post', array(
            'id' => 'pk',
            'author_id' => 'int NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'description' => 'text',
            'content' => 'text',
            'visibility' => 'tinyint(1) NOT NULL DEFAULT 1',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        // Add foreign key for 'author_id' in 'blog_post' table
        $this->addForeignKey('fk_blog_post_author', 'blog_post', 'author_id', 'user', 'id', 'CASCADE', 'RESTRICT');

        // Create 'comment' table
        $this->createTable('comment', array(
            'id' => 'pk',
            'post_id' => 'int NOT NULL',
            'author_id' => 'int NOT NULL',
            'content' => 'text',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        // Add foreign keys for 'post_id' and 'author_id' in 'comment' table
        $this->addForeignKey('fk_comment_post', 'comment', 'post_id', 'blog_post', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_comment_author', 'comment', 'author_id', 'user', 'id', 'CASCADE', 'RESTRICT');

        // Create 'like' table
        $this->createTable('like', array(
            'id' => 'pk',
            'post_id' => 'int NOT NULL',
            'user_id' => 'int NOT NULL',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        // Add foreign keys for 'post_id' and 'user_id' in 'like' table
        $this->addForeignKey('fk_like_post', 'like', 'post_id', 'blog_post', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_like_user', 'like', 'user_id', 'user', 'id', 'CASCADE', 'RESTRICT');
	}

	public function down()
	{
		
		$this->dropForeignKey('fk_like_user', 'like');
        $this->dropForeignKey('fk_like_post', 'like');
        $this->dropForeignKey('fk_comment_author', 'comment');
        $this->dropForeignKey('fk_comment_post', 'comment');
        $this->dropForeignKey('fk_blog_post_author', 'blog_post');

        // Drop tables
        $this->dropTable('like');
        $this->dropTable('comment');
        $this->dropTable('blog_post');
        $this->dropTable('user');
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}