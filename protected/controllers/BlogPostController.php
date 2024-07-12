<?php
class BlogPostController extends Controller
{
	public $layout = '//layouts/main';

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array(
				'allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'admin', 'create', 'update', 'delete', 'myposts', 'toggleVisibility'
				'actions' => array('admin', 'create', 'save', 'update', 'edit', 'delete', 'myposts', 'toggleVisibility', 'uploadImage', 'checkImageExists', 'getLikes', 'realTimePosts'),
				'users' => array('@'),
				'expression' => '$user->getState("isVerified") == 1', // Only allow verified users
			),
			array(
				'deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		if ($model->visibility == 0 && $model->author_id !== Yii::app()->user->id) {
			throw new CHttpException(403, 'You are not authorized to view this post.');
		}
		$commentModel = new Comment;
		$category = $model->category;
		$this->render(
			'view',
			array(
				'model' => $model,
				'commentModel' => $commentModel,
				'category' => $category,
			)
		);
	}

	public function actionDelete()
	{
		if (Yii::app()->request->isPostRequest) {
			$id = Yii::app()->request->getPost('id');
			$model = $this->loadModel($id);
			if ($model->author_id !== Yii::app()->user->id) {
				throw new CHttpException(403, 'You are not authorized to perform this action.');
			}

			if ($model->delete()) {
				echo CJSON::encode(['status' => 'success']);
			} else {
				echo CJSON::encode(['status' => 'error', 'message' => 'Failed to delete the post.']);
			}
			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}



	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'visibility = 1'; // Only public posts

		if (isset($_GET['q'])) {
			$q = $_GET['q'];
			$criteria->addCondition('title LIKE :q OR description LIKE :q OR content LIKE :q');
			$criteria->params[':q'] = '%' . $q . '%';
		}

		if (isset($_GET['author_id']) && !empty($_GET['author_id'])) {
			$criteria->addCondition('author_id = :author_id');
			$criteria->params[':author_id'] = $_GET['author_id'];
		}

		if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
			$criteria->addCondition('category_id = :category_id');
			$criteria->params[':category_id'] = $_GET['category_id'];
		}

		if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
			$criteria->addCondition('created_at >= :date_from');
			$criteria->params[':date_from'] = $_GET['date_from'];
		}
		if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
			$criteria->addCondition('created_at <= :date_to');
			$criteria->params[':date_to'] = $_GET['date_to'];
		}

		$criteria->order = 'created_at DESC'; // Order by latest posts

		$dataProvider = new CActiveDataProvider(
			'BlogPost',
			array(
				'criteria' => $criteria,
				'pagination' => array(
					'pageSize' => isset($_ENV['ITEMS_PER_PAGE']) ? $_ENV['ITEMS_PER_PAGE'] : 10,
				),
			)
		);

		$authorsCriteria = new CDbCriteria();
		$authorsCriteria->join = 'INNER JOIN blog_post ON t.id = blog_post.author_id';
		$authorsCriteria->distinct = true;
		$authors = User::model()->findAll($authorsCriteria);

		$categoriesCriteria = new CDbCriteria();
		$categoriesCriteria->join = 'INNER JOIN blog_post ON t.id = blog_post.category_id';
		$categoriesCriteria->distinct = true;
		$categories = Category::model()->findAll($categoriesCriteria);

		$this->render('index', array('dataProvider' => $dataProvider, 'authors' => $authors, 'categories' => $categories));
	}

	public function actionMyPosts()
	{
		$currentUserId = Yii::app()->user->id;

		$criteria = new CDbCriteria();
		$criteria->condition = 'author_id = :author_id'; // Only current user's posts
		$criteria->params = array(':author_id' => $currentUserId);

		if (isset($_GET['q'])) {
			$q = $_GET['q'];
			$criteria->addCondition('title LIKE :q OR description LIKE :q OR content LIKE :q');
			$criteria->params[':q'] = '%' . $q . '%';
		}

		if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
			$criteria->addCondition('category_id = :category_id');
			$criteria->params[':category_id'] = $_GET['category_id'];
		}

		if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
			$criteria->addCondition('created_at >= :date_from');
			$criteria->params[':date_from'] = $_GET['date_from'];
		}
		if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
			$criteria->addCondition('created_at <= :date_to');
			$criteria->params[':date_to'] = $_GET['date_to'];
		}

		$criteria->order = 'created_at DESC'; // Order by latest posts

		$dataProvider = new CActiveDataProvider(
			'BlogPost',
			array(
				'criteria' => $criteria,
				'pagination' => array(
					'pageSize' => isset($_ENV['ITEMS_PER_PAGE']) ? $_ENV['ITEMS_PER_PAGE'] : 10,
				),
			)
		);

		$categoriesCriteria = new CDbCriteria();
		$categoriesCriteria->join = 'INNER JOIN blog_post ON t.id = blog_post.category_id';
		$categoriesCriteria->distinct = true;
		$categories = Category::model()->findAll($categoriesCriteria);

		$this->render('myposts', array('dataProvider' => $dataProvider, 'categories' => $categories));
	}

	public function actionAdmin()
	{
		if (Yii::app()->user->getState('isVerified') != 1) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}

		$criteria = new CDbCriteria();
		$criteria->condition = 'author_id = :author_id';
		$criteria->params = array(':author_id' => Yii::app()->user->id);
		$criteria->order = 'created_at DESC';

		$dataProvider = new CActiveDataProvider(
			'BlogPost',
			array(
				'criteria' => $criteria,
				'pagination' => array(
					'pageSize' => isset($_ENV['ITEMS_PER_PAGE']) ? $_ENV['ITEMS_PER_PAGE'] : 10,
				),
			)
		);

		// Collect data for the chart
		$chartData = array();
		foreach ($dataProvider->data as $post) {
			$chartData[] = array(
				'date' => date('Y-m-d', strtotime($post->created_at)),
				'likes' => $post->getLikeCount(),
				'comments' => $post->getCommentCount(),
			);
		}

		$this->render(
			'admin',
			array(
				'dataProvider' => $dataProvider,
				'chartData' => $chartData
			)
		);
	}


	public function loadModel($id)
	{
		$model = BlogPost::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		if ($model->visibility == 0 && $model->author_id !== Yii::app()->user->id) {
			throw new CHttpException(403, 'You are not authorized to view this post.');
		}
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'blog-post-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionToggleVisibility()
	{
		if (Yii::app()->request->isPostRequest) {
			$id = Yii::app()->request->getPost('id');
			$visibility = Yii::app()->request->getPost('visibility');
			$post = BlogPost::model()->findByPk($id);

			if ($post !== null) {
				if ($post->author_id === Yii::app()->user->id) {
					$post->visibility = $visibility;
					if ($post->save()) {
						echo CJSON::encode(['status' => 'success']);
						Yii::app()->end();
					} else {
						echo CJSON::encode(['status' => 'error', 'message' => 'Failed to save post visibility.']);
						Yii::app()->end();
					}
				} else {
					echo CJSON::encode(['status' => 'error', 'message' => 'You are not authorized to perform this action.']);
					Yii::app()->end();
				}
			} else {
				echo CJSON::encode(['status' => 'error', 'message' => 'Post not found.']);
				Yii::app()->end();
			}
		} else {
			echo CJSON::encode(['status' => 'error', 'message' => 'Invalid request method.']);
			Yii::app()->end();
		}
	}


	public function actionEdit($id)
	{
		$model = $this->loadModel($id);
		if ($model->author_id !== Yii::app()->user->id) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}
		$this->renderEdit($model);
	}

	public function actionCreate()
	{
		$model = new BlogPost;
		$this->renderCreate($model);
	}

	public function actionSave()
	{
		if (Yii::app()->request->isAjaxRequest && isset($_POST['BlogPost'])) {
			$model = new BlogPost;
			$model->attributes = $_POST['BlogPost'];
			$model->author_id = Yii::app()->user->id;

			if (isset($_FILES['BlogPost'])) {
				if (isset($_FILES['BlogPost']['name']['image']) && !empty($_FILES['BlogPost']['name']['image'])) {
					$imageFile = CUploadedFile::getInstance($model, 'image');
					if ($imageFile) {
						$imageFileName = $imageFile->name;
						$imageFilePath = Yii::getPathOfAlias('webroot') . "/" . (isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads") . "/" . $imageFileName;
						if ($imageFile->saveAs($imageFilePath)) {
							$model->image = Yii::app()->baseUrl . "/" . (isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads") . "/" . $imageFileName;
						}
					}
				}
				if (isset($_FILES['BlogPost']['name']['cover_image']) && !empty($_FILES['BlogPost']['name']['cover_image'])) {
					$coverImageFile = CUploadedFile::getInstance($model, 'cover_image');
					if ($coverImageFile) {
						$coverImageFileName = $coverImageFile->name;
						$coverImageFilePath = Yii::getPathOfAlias('webroot') . "/" . (isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads") . "/" . $coverImageFileName;
						if ($coverImageFile->saveAs($coverImageFilePath)) {
							$model->cover_image = Yii::app()->baseUrl . "/" . (isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads") . "/" . $coverImageFileName;
						}
					}
				}
			}

			if ($model->validate() && $model->save()) {
				echo CJSON::encode(['status' => 'success', 'id' => $model->id]);
			} else {
				echo CJSON::encode(['status' => 'error', 'errors' => $model->getErrors()]);
			}
			Yii::app()->end();
		}
		throw new CHttpException(400, 'Invalid request.');
	}

	public function actionUpdate()
	{
		if (Yii::app()->request->isAjaxRequest && isset($_POST['BlogPost'])) {
			if (!isset($_POST['BlogPost']['id'])) {
				echo CJSON::encode(['status' => 'error', 'message' => 'Blog post ID is missing']);
				Yii::app()->end();
				return;
			}

			$id = $_POST['BlogPost']['id'];
			$model = $this->loadModel($id);
			if ($model->author_id !== Yii::app()->user->id) {
				echo CJSON::encode(['status' => 'error', 'message' => 'Not authorized']);
				Yii::app()->end();
				return;
			}

			$model->attributes = $_POST['BlogPost'];

			if (isset($_FILES['BlogPost'])) {
				if (isset($_FILES['BlogPost']['name']['image']) && !empty($_FILES['BlogPost']['name']['image'])) {
					$imageFile = CUploadedFile::getInstance($model, 'image');
					if ($imageFile) {
						$imageFileName = $imageFile->name;
						$imageFilePath = Yii::getPathOfAlias('webroot') . "/" . isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads" . "/" . $imageFileName;
						if ($imageFile->saveAs($imageFilePath)) {
							$model->image = Yii::app()->baseUrl . "/" . isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads" . "/" . $imageFileName;
						}
					}
				}
				if (isset($_FILES['BlogPost']['name']['cover_image']) && !empty($_FILES['BlogPost']['name']['cover_image'])) {
					$coverImageFile = CUploadedFile::getInstance($model, 'cover_image');
					if ($coverImageFile) {
						$coverImageFileName = $coverImageFile->name;
						$coverImageFilePath = Yii::getPathOfAlias('webroot') . "/" . isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads" . "/" . $coverImageFileName;
						if ($coverImageFile->saveAs($coverImageFilePath)) {
							$model->cover_image = Yii::app()->baseUrl . "/" . isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads" . "/" . $coverImageFileName;
						}
					}
				}
			}

			if ($model->validate() && $model->save()) {
				echo CJSON::encode(['status' => 'success', 'id' => $model->id]);
			} else {
				echo CJSON::encode(['status' => 'error', 'errors' => $model->getErrors()]);
			}
			Yii::app()->end();
		}
		throw new CHttpException(400, 'Invalid request.');
	}



	protected function renderCreate($model)
	{
		$categories = CHtml::listData(Category::model()->findAll(), 'id', 'name');
		$this->render('create', array('model' => $model, 'categories' => $categories));
	}

	protected function renderEdit($model)
	{
		$categories = CHtml::listData(Category::model()->findAll(), 'id', 'name');
		$this->render('update', array('model' => $model, 'categories' => $categories));
	}
	public function actionUploadImage()
	{
		$output = ['status' => 'error', 'message' => 'File upload failed'];
		Yii::log('Starting file upload process', 'info');

		if (isset($_FILES['image']) || isset($_FILES['cover_image'])) {
			Yii::log('File found in request', 'info');

			// Check which file is being uploaded
			$file = isset($_FILES['image']) ? CUploadedFile::getInstanceByName('image') : CUploadedFile::getInstanceByName('cover_image');

			if ($file) {
				Yii::log('File instance created', 'info');
				$fileName = $file->name;
				$uploadDir = isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
				$filePath = Yii::getPathOfAlias('webroot') . "/$uploadDir/" . $fileName;

				if (file_exists($filePath)) {
					Yii::log('File already exists', 'error');
					$output['message'] = 'File with the same name already exists.';
				} else {
					if ($file->saveAs($filePath)) {
						Yii::log('File saved successfully', 'info');
						$output = ['status' => 'success', 'url' => $fileName];
					} else {
						Yii::log('Failed to save file on server', 'error');
						$output['message'] = 'Failed to save file on server.';
					}
				}
			} else {
				Yii::log('Failed to get instance of uploaded file', 'error');
				$output['message'] = 'Failed to get instance of uploaded file.';
			}
		} else {
			Yii::log('No file uploaded', 'error');
			$output['message'] = 'No file uploaded.';
		}

		echo CJSON::encode($output);
		Yii::app()->end();
	}



	public function actionCheckImageExists()
	{
		$output = ['status' => 'error', 'message' => 'Invalid request'];

		if (isset($_POST['url'])) {
			$url = $_POST['url'];
			if (empty($url)) {
				$output = ['status' => 'error', 'message' => 'URL cannot be empty'];
			} else {
				$base = isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
				$filePath = Yii::getPathOfAlias('webroot') . "/" . $base . "/" . $url;

				if (file_exists($filePath)) {
					$imageInfo = getimagesize($filePath);
					$fileSize = filesize($filePath);
					$mimeType = mime_content_type($filePath);

					$maxWidth = isset($_ENV['MAX_IMAGE_WIDTH']) ? $_ENV['MAX_IMAGE_WIDTH'] : 1023;
					$maxHeight = isset($_ENV['MAX_IMAGE_HIGHT']) ? $_ENV['MAX_IMAGE_HIGHT'] : 1023;
					$maxSize = 1024 * (isset($_ENV['MAX_IMAGE_SIZE']) ? $_ENV['MAX_IMAGE_SIZE'] : 1023);
					$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

					if ($imageInfo) {
						$width = $imageInfo[0];
						$height = $imageInfo[1];

						if ($width > $maxWidth || $height > $maxHeight) {
							$output = ['status' => 'error', 'message' => 'Image dimensions should not exceed ' . $maxWidth . 'px * ' . $maxHeight . 'px.'];
						} elseif ($fileSize > $maxSize) {
							$output = ['status' => 'error', 'message' => 'Image size should not exceed ' . $maxSize . 'KB.'];
						} elseif (!in_array($mimeType, $allowedMimeTypes)) {
							$output = ['status' => 'error', 'message' => 'File type must be an image.'];
						} else {
							$output = ['status' => 'success', 'message' => 'File exists and is valid'];
						}
					} else {
						$output = ['status' => 'error', 'message' => 'Invalid image file.'];
					}
				} else {
					$output = ['status' => 'error', 'message' => 'File does not exist'];
				}
			}
		}

		echo CJSON::encode($output);
		Yii::app()->end();
	}

	public function actionGetLikes($id)
	{
		$post = $this->loadModel($id);
		$likes = $post->getLikes();
		$usernames = array_map(function ($like) {
			return $like->user->username;
		}, $likes);

		echo CJSON::encode($usernames);
		Yii::app()->end();
	}
	public function actionRealTimePosts()
	{

		if (Yii::app()->user->getState('isVerified') != 1) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}

		$query = isset($_GET['query']) ? $_GET['query'] : '';

		$letters = explode(' ', $query);
		$likePattern = '';
		foreach ($letters as $letter) {
			$likePattern .= $letter . '% ';
		}
		$likePattern = rtrim($likePattern);


		$sql = "
				SELECT 
					bp.*, 
					u.username, 
					COUNT(DISTINCT c.id) AS comments_count, 
					COUNT(DISTINCT l.id) AS likes_count, 
					cat.name AS category_name,
					cat.icon
				FROM 
					blog_post bp
					JOIN user u ON bp.author_id = u.id
					LEFT JOIN comment c ON c.post_id = bp.id
					LEFT JOIN `like` l ON l.post_id = bp.id
					JOIN category cat ON bp.category_id = cat.id
					INNER JOIN (
						SELECT author_id
						FROM blog_post
						GROUP BY author_id
						HAVING COUNT(*) >= 2
					) AS authors ON bp.author_id = authors.author_id
				WHERE 
					bp.visibility = 1 
					AND (bp.title LIKE :likePattern OR bp.title LIKE :query OR bp.description LIKE :query OR bp.content LIKE :query)
				GROUP BY 
					bp.id
				HAVING 
					comments_count > 0
				ORDER BY 
					bp.created_at DESC;
			";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(':likePattern', $likePattern, PDO::PARAM_STR);
		$command->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
		$posts = $command->queryAll();
		echo CJSON::encode($posts);
		Yii::app()->end();
	}



}
