<?php

class m240711_145920_insert_demo_likes_and_comments extends CDbMigration
{
	public function up()
	{
		 // Insert demo likes
		 $this->insert('like', ['post_id' => 1, 'user_id' => 1, 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
		 $this->insert('like', ['post_id' => 1, 'user_id' => 2, 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
		 $this->insert('like', ['post_id' => 3, 'user_id' => 1, 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
		 $this->insert('like', ['post_id' => 4, 'user_id' => 1, 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
		 $this->insert('like', ['post_id' => 5, 'user_id' => 2, 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
 
		 // Insert demo comments
		 $this->insert('comment', ['post_id' => 1, 'author_id' => 1, 'content' => 'Great tips on skin care!', 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
		 $this->insert('comment', ['post_id' => 1, 'author_id' => 2, 'content' => 'Very useful information.', 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
		 $this->insert('comment', ['post_id' => 3, 'author_id' => 1, 'content' => 'I loved the book recommendations.', 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
		 $this->insert('comment', ['post_id' => 4, 'author_id' => 2, 'content' => 'Thanks for the insights!', 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
		 $this->insert('comment', ['post_id' => 5, 'author_id' => 3, 'content' => 'These songs are amazing.', 'created_at' => new CDbExpression('CURRENT_TIMESTAMP')]);
	}

	public function down()
	{
		  // Remove demo likes
		  $this->delete('like', ['post_id' => 1, 'user_id' => 1]);
		  $this->delete('like', ['post_id' => 1, 'user_id' => 2]);
		  $this->delete('like', ['post_id' => 3, 'user_id' => 1]);
		  $this->delete('like', ['post_id' => 4, 'user_id' => 1]);
		  $this->delete('like', ['post_id' => 5, 'user_id' => 2]);
  
		  // Remove demo comments
		  $this->delete('comment', ['post_id' => 1, 'author_id' => 1]);
		  $this->delete('comment', ['post_id' => 1, 'author_id' => 2]);
		  $this->delete('comment', ['post_id' => 3, 'author_id' => 1]);
		  $this->delete('comment', ['post_id' => 4, 'author_id' => 2]);
		  $this->delete('comment', ['post_id' => 5, 'author_id' => 3]);
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