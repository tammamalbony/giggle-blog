<?php

class m240711_113602_add_initial_categories extends CDbMigration
{
	public function up()
	{
		$this->execute("
		INSERT INTO `category` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
		(1, 'Skin Care', '1b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(2, 'Hair Care', '2b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(3, 'Sports', '3b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(4, 'Books', '4b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(5, 'Music', '5b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
	");
	}

	public function down()
	{
		$this->execute("
			DELETE FROM `category` WHERE `id` IN (1, 2, 3, 4, 5);
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