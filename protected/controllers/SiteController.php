<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the login action that is invoked
     */
    public function actionLogin() {
        if(!Yii::app()->user->isGuest){
            $this->redirect(array('index'));
        }
        $model = new LoginForm;
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the next page if valid
            if ($model->validate() && $model->login()){
                try{
                    //Se verifica si el usuario existe en la base de datos, sino se crea
                    $dbUser=User::getByUsername(Yii::app()->user->_uid);
                    if(!$dbUser){
                        User::createLDAPUser(Yii::app()->user->_givenName,Yii::app()->user->_sn,Yii::app()->user->_uid,Yii::app()->user->_mail);
                        $dbUser=User::getByUsername(Yii::app()->user->_uid);
                    }
                    Yii::app()->user->id=$dbUser->id;
                    //Redirecciona al index donde se define a qué vista pasar
                    $this->redirect(array('index'));
                }catch(Exception $e){
                    Yii::app()->user->logout();
                }
            }
        }
        $this->render('login', array('model' => $model));
    }
    
    /**
     * This is the login action that is invoked
     */
    public function actionAdmin() {
        if(!Yii::app()->user->isGuest){
            $this->redirect(array('index'));
        }
        $model = new LoginFormAdmin;
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['LoginFormAdmin'])) {
            $model->attributes = $_POST['LoginFormAdmin'];
            // validate user input and redirect to the next page if valid
            if ($model->validate() && $model->login()){
                if(Yii::app()->user->checkAccess('createActivitySet')){
                    $this->redirect(array('activitySet/admin'));
                }else{
                    $this->redirect(array('designer/'));
                }
            }
        }
        $this->render('admin', array('model' => $model));
    }
    
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // collect user input data
        if(Yii::app()->user->isGuest){
            $this->redirect(array('login'));
        }else{
            //Acceso del administrador
            if(Yii::app()->user->checkAccess('createActivitySet')){
                $this->redirect(array('activitySet/admin')); 
            //Acceso del operador
            }else if(Yii::app()->user->checkAccess('designer')){
                //$this->redirect(array('designer/index'));
		$this->redirect(array('activitySet/oper')); 
            }else if(Yii::app()->user->checkAccess('application')){
                //Se valida si es la primera vez que ingresa al sitio
                $user=User::getCurrentUser();
                if(intval($user->entries)===0){
                    $this->redirect(array('site/aboutus'));
                }else{
                    $this->render('index',array(
                        'activitySets'=>ActivitySet::getPublished()
                    ));
                    $user->entries++;
                    $user->update();
                }
            }else{
                // renders the view file 'protected/views/site/index.php'
                // using the default layout 'protected/views/layouts/main.php'
                $model = new LoginForm;
                $this->render('login', array('model' => $model));
            }
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        $redirectTo=Yii::app()->homeUrl;
        if(Yii::app()->user->checkAccess('designer')){
            Yii::app()->user->logout();
             $this->redirect(array('site/admin'));
        }else{
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    /**
    * Displays the about_us page
    */
    public function actionAboutUs() {
        if(isset($_POST['AGREE'])) {
            //Si acepta, se auenta el contador de entradas y se redirecciona al index
            $user=User::getCurrentUser();
            $user->entries++;
            $user->update();
            $this->redirect('site/index');
        } elseif (isset($_POST['DECLINE'])) {
            $this->redirect(array('site/logout'));
        } else {
           $this->render('about_us');
        }
    }

}
