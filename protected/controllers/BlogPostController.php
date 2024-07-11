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
				'actions' => array('admin', 'create', 'update', 'delete', 'myposts', 'toggleVisibility'),
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

		$this->render('view', array('model' => $model));
	}

	public function actionCreate()
	{
		$model = new BlogPost;

		if (isset($_POST['BlogPost'])) {
			$model->attributes = $_POST['BlogPost'];
			$model->author_id = Yii::app()->user->id;
			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$categories = CHtml::listData(Category::model()->findAll(), 'id', 'name');

		$this->render('create', array('model' => $model, 'categories' => $categories));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if ($model->author_id !== Yii::app()->user->id) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}

		if (isset($_POST['BlogPost'])) {
			$model->attributes = $_POST['BlogPost'];
			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$categories = CHtml::listData(Category::model()->findAll(), 'id', 'name');

		$this->render('update', array('model' => $model, 'categories' => $categories));
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

    $this->render('admin', array(
        'dataProvider' => $dataProvider,
        'chartData' => $chartData
    ));
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

}
