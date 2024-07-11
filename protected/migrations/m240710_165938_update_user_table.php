<?php

class m240710_165938_update_user_table extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'first_name', 'string NOT NULL');
        $this->addColumn('user', 'last_name', 'string NOT NULL');
        $this->addColumn('user', 'username', 'string NOT NULL UNIQUE');
	}

	public function down()
	{
		$this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'username');
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