<?php

class RbacCommand extends CConsoleCommand {

    private $_authManager;

    public function getHelp() {

        $description = "DESCRIPTION\n";
        $description .= '    ' . "This command generates an initial RBAC authorization hierarchy.\n";
        return parent::getHelp() . $description;
    }

    /**
     * The default action - create the RBAC structure.
     */
    public function actionIndex() {

        $this->ensureAuthManagerDefined();

        //first we need to remove all operations, 
        //roles, child relationship and assignments
        $this->_authManager->clearAll();
        
        //Operaciones para administración de set de actividades
        $this->_authManager->createOperation("designer", "Access to the designer system");
        $this->_authManager->createOperation("manageActivitySets", "Manage the Activity Sets");
        $this->_authManager->createOperation("createActivitySet", "Create an Activity Set");
        $this->_authManager->createOperation("editor", "Manage the edition tool");
        
        //Operaciones para los usuarios
        $this->_authManager->createOperation("application", "Perform activities in the platform");
        
        //Creación del rol y asignación de permisos
        $role = $this->_authManager->createRole("administrator");
        $role->addChild("designer");
        $role->addChild("manageActivitySets");
        $role->addChild("createActivitySet");
        $role->addChild("editor");
        
        //Creación del rol y asignación de permisos
        $role = $this->_authManager->createRole("operator");
        $role->addChild("designer");
        $role->addChild("manageActivitySets");
        $role->addChild("editor");
        
        //Creación del rol y asignación de permisos
        $role = $this->_authManager->createRole("user");
        $role->addChild("application");
                
        //Temp user assignment, this must be doing by the administration interface
        $auth=Yii::app()->authManager;
        $auth->assign('administrator',1);
        $auth->assign('operator',2);
        $auth->assign('operator',3);
        $auth->assign('operator',4);
        $auth->assign('operator',5);

        //provide a message indicating success
        echo "Authorization hierarchy successfully generated.\n";
    }
    public function actionDelete() {
        $this->ensureAuthManagerDefined();
        $message = "This command will clear all RBAC definitions.\n";
        $message .= "Would you like to continue?";
        //check the input from the user and continue if they indicated 
        //yes to the above question
        if ($this->confirm($message)) {
            $this->_authManager->clearAll();
            echo "Authorization hierarchy removed.\n";
        } else
            echo "Delete operation cancelled.\n";
    }
    protected function ensureAuthManagerDefined() {
        //ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
        if (($this->_authManager = Yii::app()->authManager) === null) {
            $message = "Error: an authorization manager, named 'authManager' must be con-figured to use this command.";
            $this->usageError($message);
        }
    }
}