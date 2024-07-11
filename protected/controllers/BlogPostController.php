<?php

class BlogPostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			// 'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'admin', 'create', 'update', 'delete' actions
				'actions' => array('admin', 'create', 'update', 'delete', 'myposts'),
				'users' => array('@'),
				'expression' => '$user->getState("isVerified") == 1', // Only allow verified users
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render(
			'view',
			array(
				'model' => $this->loadModel($id),
			)
		);
	}

	/**
	 * Displays a private model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewPrivate($id)
	{
		$this->render(
			'viewPrivate',
			array(
				'model' => $this->loadModel($id),
			)
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
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

		$this->render(
			'create',
			array(
				'model' => $model,
				'categories' => $categories,
			)
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
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

		$this->render(
			'update',
			array(
				'model' => $model,
				'categories' => $categories,
			)
		);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		if ($model->author_id !== Yii::app()->user->id) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}

		$model->delete();

		// Redirect to admin page
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'visibility = 1'; // Only public posts

		// Check if there's a search query
		if (isset($_GET['q'])) {
			$q = $_GET['q'];
			$criteria->addCondition('title LIKE :q OR description LIKE :q OR content LIKE :q');
			$criteria->params[':q'] = '%' . $q . '%';
		}

		// Filter by author
		if (isset($_GET['author_id']) && !empty($_GET['author_id'])) {
			$criteria->addCondition('author_id = :author_id');
			$criteria->params[':author_id'] = $_GET['author_id'];
		}

		// Filter by category
		if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
			$criteria->addCondition('category_id = :category_id');
			$criteria->params[':category_id'] = $_GET['category_id'];
		}

		// Filter by date range
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

		// Fetch authors who have posts
		$authorsCriteria = new CDbCriteria();
		$authorsCriteria->join = 'INNER JOIN blog_post ON t.id = blog_post.author_id';
		$authorsCriteria->distinct = true;
		$authors = User::model()->findAll($authorsCriteria);

		// Fetch categories with posts
		$categoriesCriteria = new CDbCriteria();
		$categoriesCriteria->join = 'INNER JOIN blog_post ON t.id = blog_post.category_id';
		$categoriesCriteria->distinct = true;
		$categories = Category::model()->findAll($categoriesCriteria);

		$this->render(
			'index',
			array(
				'dataProvider' => $dataProvider,
				'authors' => $authors,
				'categories' => $categories,
			)
		);
	}


	public function actionMyposts()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'visibility = 1'; // Only public posts

		// Check if there's a search query
		if (isset($_GET['q'])) {
			$q = $_GET['q'];
			$criteria->addCondition('title LIKE :q OR description LIKE :q OR content LIKE :q');
			$criteria->params[':q'] = '%' . $q . '%';
		}

		$criteria->order = 'created_at DESC'; // Order by latest posts

		$dataProvider = new CActiveDataProvider(
			'BlogPost',
			array(
				'criteria' => $criteria,
				'pagination' => array(
					'pageSize' => 10,
				),
			)
		);

		$this->render(
			'index',
			array(
				'dataProvider' => $dataProvider,
			)
		);
	}

	/**
	 * Manages all models.
	 */
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
					'pageSize' => 10,
				),
			)
		);

		$this->render(
			'admin',
			array(
				'dataProvider' => $dataProvider,
			)
		);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BlogPost the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = BlogPost::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BlogPost $model the model to be validated
	 */

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'blog-post-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
