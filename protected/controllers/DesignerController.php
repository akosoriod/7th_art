<?php
class DesignerController extends Controller {
    
    /**
     * Default action for DesignerController
     */
    public function actionIndex() {
        if(Yii::app()->user->checkAccess('designer')){
            $this->render('index');
        }else{
            $this->redirect((array('site/index')));
        }
    }
}
