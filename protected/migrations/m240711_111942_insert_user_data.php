<?php

class m240711_111942_insert_user_data extends CDbMigration
{
	public function up()
	{
		$this->execute("
            INSERT INTO `user` (`id`, `email`, `password`, `verification_token`, `is_verified`, `created_at`, `updated_at`, `first_name`, `last_name`, `username`, `terms`) VALUES
            (1, 'Wafaabufaour1@gmail.com', '\$2y\$13\$07TqbV26xrwlpLpR5NASMuZQRVzyUirv9AT6B.kITn4SJztVoYhey', NULL, 1, '2024-07-11 11:14:48', '2024-07-11 11:14:48', 'wafa1', 'af1', 'wafaaf1', 1),
            (2, 'Wafaabufaour2@gmail.com', '\$2y\$13\$WfzkHu0jK2XugDXNoMqt5OZOcdsKueIyWe4sOqrQeKxfUpgRWB9zi', NULL, 1, '2024-07-11 11:16:49', '2024-07-11 11:16:49', 'wafa2', 'af2', 'wafaaf2', 1),
            (3, 'Wafaabufaour3@gmail.com', '\$2y\$13\$Qms1vrgnNe13mo9ksbXP/.t1ig4SEoeX09WN8Q8tHLUNzL/FWtWGO', 'adf5dec7e6ebb8c57dc94b00467334e8', 0, '2024-07-11 11:17:35', '2024-07-11 11:17:35', 'wafa3', 'af3', 'wafaaf3', 1);
        ");
	}

	public function down()
	{
		$this->execute("
		DELETE FROM `user` WHERE `id` IN (1, 2, 3);
	");
		echo "m240711_111942_insert_user_data does not support migration down.\n";
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