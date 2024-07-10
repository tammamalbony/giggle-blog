<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow', 'actions'=>array('index','view','register','verify','ajaxEmailCheck'), 'users'=>array('*')),
			array('allow', 'actions'=>array('create','update','verification','resendVerification'), 'users'=>array('@')),
			array('allow', 'actions'=>array('admin','delete'), 'users'=>array('admin')),
			array('deny', 'users'=>array('*')),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionRegister()
    {
        $model = new User;
     	// $this->performAjaxValidation($model);
		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			$model->verification_token = md5(uniqid(mt_rand(), true));
			if ($model->save()) {
				$verificationUrl = $this->createAbsoluteUrl('user/verify', array('token' => $model->verification_token));
				Yii::log("Verification URL: $verificationUrl", CLogger::LEVEL_INFO);
				$body = "Please click on the following link to verify your account: <a href='{$verificationUrl}'>Verify Account</a>";
				if (Yii::app()->mail->sendMail($model->email, 'Verify Your Account', $body)) {
					Yii::app()->user->setFlash('success', 'Thank you for registering. Please check your email to verify your account.');
					$this->redirect(array('site/login'));
				} else {
					Yii::app()->user->setFlash('error', 'Error while sending verification email.');
				}
			}
		}

		$this->render('register', array('model' => $model));
    }

    public function actionVerify($token)
	{
		$user = User::model()->findByAttributes(array('verification_token' => $token));
		if ($user) {
			$user->is_verified = 1;
			$user->verification_token = null;
			if ($user->save(false)) {
				Yii::app()->user->setFlash('success', 'Your account has been verified.');
				Yii::app()->user->setState('isVerified', true);
				$this->redirect(array('site/index'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'Invalid verification token.');
			$this->redirect(array('user/verification'));
		}
	}
	public function actionVerification()
	{
		$this->render('verification');
	}

	public function actionResendVerification()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if ($user && !$user->is_verified) {
			$user->verification_token = md5(uniqid(rand(), true)); // Generate a new token
			if ($user->save(false)) {
				$verificationUrl = Yii::app()->createAbsoluteUrl('user/verify', ['token' => $user->verification_token]);
				$body = "Please click on the following link to verify your account: <a href='{$verificationUrl}'>Verify Account</a>";
				if (Yii::app()->mail->sendMail($user->email, 'Verify Your Account', $body)) {
					Yii::app()->user->setFlash('success', 'A new verification email has been sent to your email address.');
				} else {
					Yii::app()->user->setFlash('error', 'Error while sending verification email.');
				}
			} else {
				Yii::app()->user->setFlash('error', 'Error while generating new verification token.');
			}
		} else {
			Yii::app()->user->setFlash('error', 'Your account is already verified or user not found.');
		}

		$this->redirect(array('user/verification'));
	}

    public function actionAjaxEmailCheck()
    {
        $email = Yii::app()->request->getParam('email');
        $exists = User::model()->exists('email=:email', array(':email' => $email));
        echo json_encode(!$exists);
    }
	public function actionAjaxUsernameCheck()
	{
		$username = $_GET['username'];
		$exists = User::model()->exists('username=:username', [':username' => $username]);
		echo CJSON::encode(!$exists);
	}


}
