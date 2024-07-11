<?php

class m240711_115050_insert_initial_blog_posts extends CDbMigration
{
	public function up()
	{
		// Inserting blog posts for wafaaf1 (user id 1)
		$this->execute("
		 INSERT INTO `blog_post` (`author_id`, `category_id`, `title`, `description`, `content`, `visibility`, `created_at`, `updated_at`, `image`, `cover_image`) VALUES
		 (1, 1, 'Skin care: 5 tips for healthy skin', 'Tips for maintaining healthy skin.', 'Protect yourself from the sun. One of the most important ways to take care of your skin is to protect it from the sun. ... Don\'t smoke. Smoking makes your skin look older and contributes to wrinkles. ... Treat your skin gently. … Eat a healthy diet. … Manage stress.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '/custom/img/s2/1.png', '/custom/img/s2/1a.jpg'),
		 (1, 2, 'Protect Your Hair', 'Ways to protect your hair from damage.', 'There are several ways to protect your hair from damage. Avoid excessive heat styling, protect your hair from the sun, use a wide-toothed comb or a brush with soft bristles to prevent breakage, and minimize chemical treatments such as hair coloring or perming.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '/custom/img/s2/2.png', '/custom/img/s2/2a.jpg'),
		 (1, 4, 'Insights into Life and Relationships', 'Books that provide valuable insights into life and relationships.', 'Here are five highly regarded books that provide valuable insights into life and relationships: The Seven Principles for Making Marriage Work by John Gottman and Nan Silver. This book is based on extensive research and provides practical advice for maintaining a healthy and lasting marriage. It covers communication, conflict resolution, and emotional connection. Men Are from Mars, Women Are from Venus by John Gray. A classic book that explores the differences between men and women in relationships. It offers practical advice on how to understand and communicate with your partner more effectively. The Five Love Languages: The Secret to Love That Lasts by Gary Chapman. This book introduces the concept of love languages—different ways people express and receive love. Understanding your partner\'s love language can enhance your relationship and ensure both partners feel loved and appreciated. The Road Less Traveled: A New Psychology of Love, Traditional Values, and Spiritual Growth by M. Scott Peck. This book combines psychological and spiritual insights to explore personal growth, love, and the journey to a fulfilling life. It emphasizes the importance of discipline, responsibility, and self-awareness in building meaningful relationships. Attached: The New Science of Adult Attachment and How It Can Help You Find—and Keep—Love by Amir Levine and Rachel Heller. This book delves into the science of attachment theory and how it affects relationships. It helps readers understand their attachment style and how it influences their interactions with others, offering strategies for building healthier connections.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '/custom/img/s2/4.png', '/custom/img/s2/4a.jpg');
	 	");

		// Inserting blog posts for wafaaf2 (user id 2)
		$this->execute("
		 INSERT INTO `blog_post` (`author_id`, `category_id`, `title`, `description`, `content`, `visibility`, `created_at`, `updated_at`, `image`, `cover_image`) VALUES
		 (2, 3, '10 Reasons Why Sport is Important', 'Reasons to engage in sports.', 'Physical Fitness: Engaging in sports helps improve cardiovascular health, build muscle strength, enhance flexibility, and maintain a healthy weight. Regular physical activity reduces the risk of chronic diseases such as heart disease, diabetes, and obesity. Mental Health: Sports can reduce stress, anxiety, and depression by releasing endorphins, the body\'s natural mood lifters. It also promotes better sleep, which is crucial for overall mental well-being. Social Interaction: Participating in sports provides opportunities to socialize and build relationships. It enhances teamwork and communication skills, which are beneficial for mental and emotional health. Discipline and Self-Esteem: Sports teach discipline, goal-setting, and perseverance. Achieving personal or team goals can boost self-esteem and confidence, which positively impacts mental health. Coordination and Balance: Many sports require a combination of balance, coordination, and agility. These physical skills can help prevent injuries in daily activities and improve overall physical stability.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '/custom/img/s2/3.png', '/custom/img/s2/3a.jpg'),
		 (2, 5, 'Top 5 Arabic Fun Songs', 'Popular Arabic fun songs.', 'The most 5 songs Arabic fun: Boshret Kheir by Hussain Al Jassmi. This upbeat and catchy song became an anthem of positivity and hope. It\'s widely loved for its energetic rhythm and uplifting lyrics. 3 Daqat by Abu ft. Yousra. A romantic and cheerful song that quickly became a hit across the Arab world. Its joyful melody and playful lyrics make it perfect for celebrations. Ya Tabtab Wa Dallaa by Nancy Ajram. A bubbly and fun song by the famous Lebanese singer Nancy Ajram. Its playful lyrics and catchy tune make it a hit at any festive occasion. Ya Bent El Geran by Mahmoud El Esseily. This catchy song has an upbeat tempo and is perfect for getting people dancing and in a festive mood. Lama Rahet by Saad Lamjarred. Saad Lamjarred is known for his energetic songs, and Lama Rahet is a fun track that\'s popular at parties.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '/custom/img/s2/5.png', '/custom/img/s2/5a.jpg');
		");
	}

	public function down()
	{
		 // Deleting blog posts for wafaaf1 (user id 1)
		 $this->execute("
		 DELETE FROM `blog_post` WHERE `author_id` = 1 AND `category_id` IN (1, 2, 4);
		");

		// Deleting blog posts for wafaaf2 (user id 2)
		$this->execute("
			DELETE FROM `blog_post` WHERE `author_id` = 2 AND `category_id` IN (3, 5);
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