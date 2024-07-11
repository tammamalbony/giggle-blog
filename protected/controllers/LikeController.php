<?php

class LikeController extends Controller
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
				'actions' => array('create', 'update', 'toggle'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete'),
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
		$this->render('view', array(
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
		$model = new Like;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Like'])) {
			$model->attributes = $_POST['Like'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create', array(
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

		if (isset($_POST['Like'])) {
			$model->attributes = $_POST['Like'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Like');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		)
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Like('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Like']))
			$model->attributes = $_GET['Like'];

		$this->render('admin', array(
			'model' => $model,
		)
		);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Like the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Like::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Like $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'like-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionToggle()
	{
		if (Yii::app()->request->isAjaxRequest && isset($_POST['post_id'])) {
			$postId = $_POST['post_id'];
			$userId = Yii::app()->user->id;
	
			// Check if the user has already liked the post
			$like = Like::model()->findByAttributes(array('post_id' => $postId, 'user_id' => $userId));
	
			if ($like) {
				// Unlike the post
				if ($like->delete()) {
					$likeCount = Like::model()->countByAttributes(array('post_id' => $postId));
					echo CJSON::encode(array('success' => true, 'liked' => false, 'likeCount' => $likeCount, 'message' => 'Post unliked.'));
				} else {
					echo CJSON::encode(array('success' => false, 'message' => 'Error unliking the post.'));
				}
			} else {
				// Like the post
				$like = new Like();
				$like->post_id = $postId;
				$like->user_id = $userId;
				$like->created_at = new CDbExpression('NOW()');
				if ($like->save()) {
					$likeCount = Like::model()->countByAttributes(array('post_id' => $postId));
					echo CJSON::encode(array('success' => true, 'liked' => true, 'likeCount' => $likeCount, 'message' => 'Post liked.'));
				} else {
					$errors = $like->getErrors();
					echo CJSON::encode(array('success' => false, 'message' => 'Error liking the post.', 'errors' => $errors));
				}
			}
		} else {
			throw new CHttpException(400, 'Invalid request.');
		}
	}
	
	
}
