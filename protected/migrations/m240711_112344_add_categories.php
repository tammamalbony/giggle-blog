<?php

class m240711_112344_add_categories extends CDbMigration
{
	public function up()
	{
		  // Create category table
		  $this->createTable('category', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ));

        // Add category_id to blog_post table
        $this->addColumn('blog_post', 'category_id', 'integer NOT NULL');

        // Add foreign key for category_id in blog_post table
        $this->addForeignKey('fk_blog_post_category', 'blog_post', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		 // Drop foreign key and category_id column from blog_post table
		 $this->dropForeignKey('fk_blog_post_category', 'blog_post');
		 $this->dropColumn('blog_post', 'category_id');
 
		 // Drop category table
		 $this->dropTable('category');
		echo "m240711_112344_add_categories does not support migration down.\n";
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