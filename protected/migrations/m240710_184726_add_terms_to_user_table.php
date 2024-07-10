<?php

class m240710_184726_add_terms_to_user_table extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'terms', 'BOOLEAN NOT NULL DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('user', 'terms');
		echo "m240710_184726_add_terms_to_user_table does not support migration down.\n";
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