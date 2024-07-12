<?php

class m240712_163020_add_indexes_to_optimize_query extends CDbMigration
{
	public function up()
	{
		$this->createIndex('idx_blog_post_author_id', 'blog_post', 'author_id');
		$this->createIndex('idx_blog_post_visibility', 'blog_post', 'visibility');
		$this->createIndex('idx_blog_post_created_at', 'blog_post', 'created_at');
		$this->createIndex('idx_comment_blog_post_id', 'comment', 'blog_post_id');
	}

	public function down()
	{
		$this->dropIndex('idx_blog_post_author_id', 'blog_post');
		$this->dropIndex('idx_blog_post_visibility', 'blog_post');
		$this->dropIndex('idx_blog_post_created_at', 'blog_post');
		$this->dropIndex('idx_comment_blog_post_id', 'comment');
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