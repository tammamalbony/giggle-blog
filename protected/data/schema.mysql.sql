CREATE TABLE IF NOT EXISTS `user` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `verification_token` VARCHAR(255) DEFAULT NULL,
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `user`
ADD COLUMN `first_name` VARCHAR(255) NOT NULL AFTER `email`,
ADD COLUMN `last_name` VARCHAR(255) NOT NULL AFTER `first_name`,
ADD COLUMN `username` VARCHAR(255) NOT NULL UNIQUE AFTER `last_name`;

CREATE TABLE IF NOT EXISTS `blog_post` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `author_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `content` TEXT,
    `visibility` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`author_id`) REFERENCES `user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comment` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post_id` INT NOT NULL,
    `author_id` INT NOT NULL,
    `content` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`post_id`) REFERENCES `blog_post`(`id`),
    FOREIGN KEY (`author_id`) REFERENCES `user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `like` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`post_id`) REFERENCES `blog_post`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `email`, `password`, `verification_token`, `is_verified`, `created_at`, `updated_at`, `first_name`, `last_name`, `username`, `terms`) VALUES
            (1, 'Wafaabufaour1@gmail.com', '\$2y\$13\$07TqbV26xrwlpLpR5NASMuZQRVzyUirv9AT6B.kITn4SJztVoYhey', NULL, 1, '2024-07-11 11:14:48', '2024-07-11 11:14:48', 'wafa1', 'af1', 'wafaaf1', 1),
            (2, 'Wafaabufaour2@gmail.com', '\$2y\$13\$WfzkHu0jK2XugDXNoMqt5OZOcdsKueIyWe4sOqrQeKxfUpgRWB9zi', NULL, 1, '2024-07-11 11:16:49', '2024-07-11 11:16:49', 'wafa2', 'af2', 'wafaaf2', 1),
            (3, 'Wafaabufaour3@gmail.com', '\$2y\$13\$Qms1vrgnNe13mo9ksbXP/.t1ig4SEoeX09WN8Q8tHLUNzL/FWtWGO', 'adf5dec7e6ebb8c57dc94b00467334e8', 0, '2024-07-11 11:17:35', '2024-07-11 11:17:35', 'wafa3', 'af3', 'wafaaf3', 1);

-- Create category table
CREATE TABLE `category` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Add category_id to blog_post table
ALTER TABLE `blog_post`
ADD COLUMN `category_id` INT NOT NULL;

-- Add foreign key for category_id in blog_post table
ALTER TABLE `blog_post`
ADD CONSTRAINT `fk_blog_post_category`
FOREIGN KEY (`category_id`) REFERENCES `category`(`id`)
ON DELETE CASCADE
ON UPDATE CASCADE;

-- Add image and cover_image columns to blog_post table
ALTER TABLE `blog_post`
ADD COLUMN `image` VARCHAR(255) DEFAULT NULL,
ADD COLUMN `cover_image` VARCHAR(255) DEFAULT NULL;

-- Add icon column to category table
ALTER TABLE `category`
ADD COLUMN `icon` VARCHAR(255) DEFAULT NULL;


-- Insert initial categories
INSERT INTO `category` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
		(1, 'Skin Care', '1b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(2, 'Hair Care', '2b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(3, 'Sports', '3b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(4, 'Books', '4b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
		(5, 'Music', '5b.png', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


-- Inserting blog posts for wafaaf1 (user id 1)
INSERT INTO `blog_post` (`author_id`, `category_id`, `title`, `description`, `content`, `visibility`, `created_at`, `updated_at`, `image`, `cover_image`) VALUES
(1, 1, 'Skin care: 5 tips for healthy skin', 'Tips for maintaining healthy skin.', 'Protect yourself from the sun. One of the most important ways to take care of your skin is to protect it from the sun. ... Don\'t smoke. Smoking makes your skin look older and contributes to wrinkles. ... Treat your skin gently. … Eat a healthy diet. … Manage stress.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1.png', '1a.jpg'),
(1, 2, 'Protect Your Hair', 'Ways to protect your hair from damage.', 'There are several ways to protect your hair from damage. Avoid excessive heat styling, protect your hair from the sun, use a wide-toothed comb or a brush with soft bristles to prevent breakage, and minimize chemical treatments such as hair coloring or perming.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '2.png', '2a.jpg'),
(1, 4, 'Insights into Life and Relationships', 'Books that provide valuable insights into life and relationships.', 'Here are five highly regarded books that provide valuable insights into life and relationships: The Seven Principles for Making Marriage Work by John Gottman and Nan Silver. This book is based on extensive research and provides practical advice for maintaining a healthy and lasting marriage. It covers communication, conflict resolution, and emotional connection. Men Are from Mars, Women Are from Venus by John Gray. A classic book that explores the differences between men and women in relationships. It offers practical advice on how to understand and communicate with your partner more effectively. The Five Love Languages: The Secret to Love That Lasts by Gary Chapman. This book introduces the concept of love languages—different ways people express and receive love. Understanding your partner\'s love language can enhance your relationship and ensure both partners feel loved and appreciated. The Road Less Traveled: A New Psychology of Love, Traditional Values, and Spiritual Growth by M. Scott Peck. This book combines psychological and spiritual insights to explore personal growth, love, and the journey to a fulfilling life. It emphasizes the importance of discipline, responsibility, and self-awareness in building meaningful relationships. Attached: The New Science of Adult Attachment and How It Can Help You Find—and Keep—Love by Amir Levine and Rachel Heller. This book delves into the science of attachment theory and how it affects relationships. It helps readers understand their attachment style and how it influences their interactions with others, offering strategies for building healthier connections.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '4.png', '4a.jpg');

-- Inserting blog posts for wafaaf2 (user id 2)
INSERT INTO `blog_post` (`author_id`, `category_id`, `title`, `description`, `content`, `visibility`, `created_at`, `updated_at`, `image`, `cover_image`) VALUES
(2, 3, '10 Reasons Why Sport is Important', 'Reasons to engage in sports.', 'Physical Fitness: Engaging in sports helps improve cardiovascular health, build muscle strength, enhance flexibility, and maintain a healthy weight. Regular physical activity reduces the risk of chronic diseases such as heart disease, diabetes, and obesity. Mental Health: Sports can reduce stress, anxiety, and depression by releasing endorphins, the body\'s natural mood lifters. It also promotes better sleep, which is crucial for overall mental well-being. Social Interaction: Participating in sports provides opportunities to socialize and build relationships. It enhances teamwork and communication skills, which are beneficial for mental and emotional health. Discipline and Self-Esteem: Sports teach discipline, goal-setting, and perseverance. Achieving personal or team goals can boost self-esteem and confidence, which positively impacts mental health. Coordination and Balance: Many sports require a combination of balance, coordination, and agility. These physical skills can help prevent injuries in daily activities and improve overall physical stability.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '3.png', '3a.jpg'),
(2, 5, 'Top 5 Arabic Fun Songs', 'Popular Arabic fun songs.', 'The most 5 songs Arabic fun: Boshret Kheir by Hussain Al Jassmi. This upbeat and catchy song became an anthem of positivity and hope. It\'s widely loved for its energetic rhythm and uplifting lyrics. 3 Daqat by Abu ft. Yousra. A romantic and cheerful song that quickly became a hit across the Arab world. Its joyful melody and playful lyrics make it perfect for celebrations. Ya Tabtab Wa Dallaa by Nancy Ajram. A bubbly and fun song by the famous Lebanese singer Nancy Ajram. Its playful lyrics and catchy tune make it a hit at any festive occasion. Ya Bent El Geran by Mahmoud El Esseily. This catchy song has an upbeat tempo and is perfect for getting people dancing and in a festive mood. Lama Rahet by Saad Lamjarred. Saad Lamjarred is known for his energetic songs, and Lama Rahet is a fun track that\'s popular at parties.', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '5.png', '5a.jpg');

-- Set the post with id 2 as private
UPDATE `blog_post` SET `visibility` = 0 WHERE `id` = 2;

-- Insert demo likes
INSERT INTO `like` (`post_id`, `user_id`, `created_at`) VALUES
(1, 1, CURRENT_TIMESTAMP),
(1, 2, CURRENT_TIMESTAMP),
(3, 1, CURRENT_TIMESTAMP),
(4, 1, CURRENT_TIMESTAMP),
(5, 2, CURRENT_TIMESTAMP);

-- Insert demo comments
INSERT INTO `comment` (`post_id`, `author_id`, `content`, `created_at`) VALUES
(1, 1, 'I found these skin care tips to be very effective.', CURRENT_TIMESTAMP),
(1, 2, 'This article is really helpful.', CURRENT_TIMESTAMP),
(2, 1, 'I appreciate the focus on healthy living.', CURRENT_TIMESTAMP),
(2, 2, 'More people need to read this!', CURRENT_TIMESTAMP),
(3, 1, 'Fantastic write-up on books!', CURRENT_TIMESTAMP),
(3, 2, 'So insightful and useful.', CURRENT_TIMESTAMP),
(5, 3, 'The energy in these songs is contagious.', CURRENT_TIMESTAMP),
(5, 2, 'Absolutely love this playlist!', CURRENT_TIMESTAMP),
(3, 1, 'I\'m definitely going to share this with my friends.', CURRENT_TIMESTAMP),
(5, 3, 'Can\'t stop listening to these!', CURRENT_TIMESTAMP);


CREATE INDEX idx_blog_post_author_id ON blog_post(author_id);
CREATE INDEX idx_blog_post_visibility ON blog_post(visibility);
CREATE INDEX idx_blog_post_created_at ON blog_post(created_at);
CREATE INDEX idx_comment_blog_post_id ON comment(blog_post_id);