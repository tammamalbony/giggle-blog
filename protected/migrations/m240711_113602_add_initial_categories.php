<?php

class m240711_113602_add_initial_categories extends CDbMigration
{
	public function up()
	{
		$this->execute("
		INSERT INTO `category` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
		(1, 'Skin Care', '/custom/img/s2/1b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(2, 'Hair Care', '/custom/img/s2/2b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(3, 'Sports', '/custom/img/s2/3b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(4, 'Books', '/custom/img/s2/4b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(5, 'Music', '/custom/img/s2/5b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
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