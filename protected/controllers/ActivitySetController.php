<?php

class ActivitySetController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
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
            $model=new ActivitySet;

            //El directorio donde se creara la información para las 
            $setsPath=Yii::app()->baseUrl.Yii::app()->params['setsPath'];
            if(isset($_POST['ActivitySet'])){
                $model->attributes=$_POST['ActivitySet'];
                $name=strtolower(preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})",'',$model->title));
                $model->name=str_replace(" ","_", $name);
                if($model->isNewRecord){
                    $model->status_id=1;
                }
                if($model->save()){
                    //Crea el directorio del set de actividades
                    $pathSet="protected/data/sets/".$model->name;
                    if(!file_exists($pathSet)){
                        mkdir($pathSet);
                    }
                    //Almacena las imágenes y el audio
                    if($_FILES['ActivitySet']['name']['poster']){
                        $model->poster=CUploadedFile::getInstance($model,'poster');
                        $model->poster->saveAs($pathSet.'/poster.jpg');
                        $model->poster=$pathSet.'/poster.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['background']){
                        $model->background=CUploadedFile::getInstance($model,'background');
                        $model->background->saveAs($pathSet.'/background.jpg');
                        $model->background=$pathSet.'/background.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['paralax_1']){
                        $model->paralax_1=CUploadedFile::getInstance($model,'paralax_1');
                        $model->paralax_1->saveAs($pathSet.'/paralax_1.jpg');
                        $model->paralax_1=$pathSet.'/paralax_1.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['paralax_2']){
                        $model->paralax_2=CUploadedFile::getInstance($model,'paralax_2');
                        $model->paralax_2->saveAs($pathSet.'/paralax_2.jpg');
                        $model->paralax_2=$pathSet.'/paralax_2.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['paralax_3']){
                        $model->paralax_3=CUploadedFile::getInstance($model,'paralax_3');
                        $model->paralax_3->saveAs($pathSet.'/paralax_3.jpg');
                        $model->paralax_3=$pathSet.'/paralax_3.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['soundtrack']){
                        $model->soundtrack=CUploadedFile::getInstance($model,'soundtrack');
                        $model->soundtrack->saveAs($pathSet.'/soundtrack.ogg');
                        $model->soundtrack=$pathSet.'/soundtrack.ogg';
                    }
                    $model->update();
                    $this->redirect(array('view','id'=>$model->id));
                }
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
	public function actionUpdate($id){
            $model=$this->loadModel($id);
            if(isset($_POST['ActivitySet'])){
                $model->attributes=$_POST['ActivitySet'];
                $model->status_id=intval($_POST['status']);
                if($model->save()){
                    //Crea el directorio del set de actividades
                    $pathSet="protected/data/sets/".$model->name;
                    //Almacena las imágenes y el audio
                    if($_FILES['ActivitySet']['name']['poster']){
                        $model->poster=CUploadedFile::getInstance($model,'poster');
                        $model->poster->saveAs($pathSet.'/poster.jpg');
                        $model->poster=$pathSet.'/poster.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['background']){
                        $model->background=CUploadedFile::getInstance($model,'background');
                        $model->background->saveAs($pathSet.'/background.jpg');
                        $model->background=$pathSet.'/background.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['paralax_1']){
                        $model->paralax_1=CUploadedFile::getInstance($model,'paralax_1');
                        $model->paralax_1->saveAs($pathSet.'/paralax_1.jpg');
                        $model->paralax_1=$pathSet.'/paralax_1.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['paralax_2']){
                        $model->paralax_2=CUploadedFile::getInstance($model,'paralax_2');
                        $model->paralax_2->saveAs($pathSet.'/paralax_2.jpg');
                        $model->paralax_2=$pathSet.'/paralax_2.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['paralax_3']){
                        $model->paralax_3=CUploadedFile::getInstance($model,'paralax_3');
                        $model->paralax_3->saveAs($pathSet.'/paralax_3.jpg');
                        $model->paralax_3=$pathSet.'/paralax_3.jpg';
                    }
                    if($_FILES['ActivitySet']['name']['soundtrack']){
                        $model->soundtrack=CUploadedFile::getInstance($model,'soundtrack');
                        $model->soundtrack->saveAs($pathSet.'/soundtrack.ogg');
                        $model->soundtrack=$pathSet.'/soundtrack.ogg';
                    }
                    $model->update();
                    $this->redirect(array('view','id'=>$model->id));
                }
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
	public function actionIndex(){
            if(Yii::app()->user->checkAccess('manageActivitySets')){
                $dataProvider=new CActiveDataProvider('ActivitySet');
		$this->render('index',array(
                    'dataProvider'=>$dataProvider,
		));
            }else{
                $this->redirect(array('site/index')); 
            }
	}
        
        /**
        * This is the default 'index' action that is invoked
        * when an action is not explicitly requested by users.
        */
        public function actionHome() {
            // collect user input data
            if(Yii::app()->user->isGuest){
                $this->redirect(array('site/login'));
            }else{
                if(Yii::app()->user->checkAccess('application')){
                    if(array_key_exists('movie',$_GET)&&trim($_GET['movie'])!==""){
                        $name=filter_var($_GET['movie'],FILTER_SANITIZE_STRING);
                        $model=ActivitySet::getByName($name);
                        $this->render('home',array('model' => $model));
                    }
                }else{
                    $this->redirect(array('site/login'));
                }
            }
        }

	/**
	 * Manages all models.
	 */
	public function actionAdmin(){
            if(Yii::app()->user->checkAccess('createActivitySet')){
		$model=new ActivitySet();
		$this->render('admin',array(
                    'model'=>$model,
                    'activitySets'=>ActivitySet::model()->findAll(),
                    'currentUser'=>User::getCurrentUser(),
                    'users'=>User::model()->findAll()
		));
            }else{
                $this->redirect(array('site/index'));
            }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ActivitySet the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ActivitySet::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ActivitySet $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='activity-set-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
