<?php

class m240711_132431_update_blog_posts_with_random_dates extends CDbMigration
{
	public function up()
	{
		$posts = Yii::app()->db->createCommand()
            ->select('id')
            ->from('blog_post')
            ->queryAll();

        foreach ($posts as $post) {
            $randomTimestamp = $this->getRandomTimestamp();
            $this->update('blog_post', array('created_at' => $randomTimestamp), 'id=:id', array(':id' => $post['id']));
        }
	}

	public function down()
	{
		echo "m240711_132431_update_blog_posts_with_random_dates does not support migration down.\n";
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

	private function getRandomTimestamp()
    {
        $startTimestamp = strtotime('-1 year');
        $endTimestamp = time();
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
        return date('Y-m-d H:i:s', $randomTimestamp);
    }
}