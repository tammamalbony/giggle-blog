<?php

class m240711_120341_set_post_2_as_private extends CDbMigration
{
	public function up()
	{
		$this->execute("
			UPDATE `blog_post`
			SET `visibility` = 0
			WHERE `id` = 2;
		");
	}

	public function down()
	{
		$this->execute("
			UPDATE `blog_post`
			SET `visibility` = 1
			WHERE `id` = 2;
		");
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