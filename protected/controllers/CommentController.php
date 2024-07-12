<?php

class CommentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update', 'delete'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin'),
				'users' => array('admin'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (Yii::app()->user->getState('isVerified') != 1) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}
		$model = new Comment;

		if (isset($_POST['Comment'])) {
			$model->attributes = $_POST['Comment'];
			$model->post_id = $_POST['Comment']['post_id'];
			$model->author_id = Yii::app()->user->id;
			$model->created_at = new CDbExpression('NOW()');
			if ($model->save()) {
				$commentData = [
					'author' => [
						'username' => Yii::app()->user->name
					],
					'content' => CHtml::encode($model->content),
					'created_at' => $model->created_at,
				];
				echo json_encode(['success' => true, 'comment' => $commentData]);
				return;
			} else {
				echo json_encode(['success' => false, 'message' => 'Failed to save comment.']);
				return;
			}
		}

		$this->render(
			'create',
			array(
				'model' => $model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Comment'])) {
			$model->attributes = $_POST['Comment'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render(
			'update',
			array(
				'model' => $model,
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
		if (Yii::app()->user->getState('isVerified') != 1) {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}

		if (Yii::app()->request->isPostRequest) {
			// // CSRF Protection
			// $csrfToken = Yii::app()->request->getPost('YII_CSRF_TOKEN');
			// if (!Yii::app()->request->validateCsrfToken($csrfToken)) {
			// 	throw new CHttpException(401, 'Invalid CSRF token.');
			// }
	

			$comment = $this->loadModel($id);
			$post = BlogPost::model()->findByPk($comment->post_id);

			if ($post->author_id !== Yii::app()->user->id) {
				echo CJSON::encode(['status' => 'error', 'message' => 'You are not authorized to delete comments on this post.']);
				Yii::app()->end();
			}

			$transaction = Yii::app()->db->beginTransaction();
			try {
				if ($comment->delete()) {
					$transaction->commit();
					echo CJSON::encode(['status' => 'success']);
				} else {
					$transaction->rollback();
					echo CJSON::encode(['status' => 'error', 'message' => 'Failed to delete the comment.']);
				}
			} catch (Exception $e) {
				$transaction->rollback();
				echo CJSON::encode(['status' => 'error', 'message' => 'An error occurred while deleting the comment.']);
			}

			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}




	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Comment');
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
		$model = new Comment('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Comment']))
			$model->attributes = $_GET['Comment'];

		$this->render(
			'admin',
			array(
				'model' => $model,
			)
		);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Comment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Comment::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Comment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
