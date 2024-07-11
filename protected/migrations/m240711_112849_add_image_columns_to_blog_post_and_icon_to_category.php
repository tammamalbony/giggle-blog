<?php

class m240711_112849_add_image_columns_to_blog_post_and_icon_to_category extends CDbMigration
{
	public function up()
	{
		 // Add image and cover_image columns to blog_post table
		 $this->addColumn('blog_post', 'image', 'string DEFAULT NULL');
		 $this->addColumn('blog_post', 'cover_image', 'string DEFAULT NULL');
 
		 // Add icon column to category table
		 $this->addColumn('category', 'icon', 'string DEFAULT NULL');
	}

	public function down()
	{
		 // Drop image and cover_image columns from blog_post table
		 $this->dropColumn('blog_post', 'image');
		 $this->dropColumn('blog_post', 'cover_image');
 
		 // Drop icon column from category table
		 $this->dropColumn('category', 'icon');
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