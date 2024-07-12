<?php

/**
 * This is the model class for table "blog_post".
 *
 * The followings are the available columns in table 'blog_post':
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property integer $visibility
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property User $author
 * @property Comment[] $comments
 * @property Like[] $likes
 */
class BlogPost extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blog_post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title, content, category_id', 'required'),
			array('category_id, visibility', 'numerical', 'integerOnly' => true),
			array('title, image, cover_image', 'length', 'max' => 255),
			array('description', 'safe'),
			array('id, author_id, title, description, content, category_id, visibility, image, cover_image, created_at, updated_at', 'safe', 'on' => 'search'),
		);
	}


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id'),
			'likes' => array(self::HAS_MANY, 'Like', 'post_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'author_id' => 'Author',
			'title' => 'Title',
			'description' => 'Description',
			'content' => 'Content',
			'visibility' => 'Visibility',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('author_id', $this->author_id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('visibility', $this->visibility);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		)
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlogPost the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Summary of getCommentCount
	 * 
	 *  Check if the current Comments Count  at this post.
	 * 
	 * @return mixed
	 */
	public function getCommentCount()
	{
		return Comment::model()->countByAttributes(array('post_id' => $this->id));
	}

	/**
	 * Summary of getLikeCount
	 * 
	 * Check if the current Likes Count  at this post.
	 * 
	 * @return mixed
	 */
	public function getLikeCount()
	{
		return Like::model()->countByAttributes(array('post_id' => $this->id));
	}


	/**
     * Check if the current user has liked this post.
     *
     * @return boolean True if the current user has liked this post, false otherwise.
     */
    public function isLikedByCurrentUser()
    {
        if (Yii::app()->user->isGuest) {
            return false;
        }

        $userId = Yii::app()->user->id;
        $like = Like::model()->findByAttributes(array('post_id' => $this->id, 'user_id' => $userId));

        return $like !== null;
    }
	public function getLikes()
	{
		return $this->likes; 
	}
}
