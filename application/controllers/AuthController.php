<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
       $this->_helper->layout->setLayout('layout-login');
        
    }

    public function indexAction()
    {
        $this->_redirect('/auth/login/');
    }

    public function loginAction()
    {
        
        $authForm = new Application_Form_AuthForm();        

        if ($this->getRequest()->isPost()) {
 
            $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
            $validatorEmail = new Zend_Validate_EmailAddress();
            $validatorPass = new Zend_Validate_StringLength(array('min' => 6, 'max' => 12));

            $email = $this->getRequest()->getPost('email');
            $pass = $this->getRequest()->getPost('password');
            if ($authForm->isValid($this->getRequest()->getPost())) {
                
                if ($validatorEmail->isValid($email)) {
                    
                }else{
                    foreach ($validatorEmail->getMessages() as $messageId => $message) {
                        echo '<div class="row"><div class="text-center col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12 alert alert-danger" role="alert">El formato de email no es valido </div></div>';                 
                    }
                }
                if ($validatorPass->isValid($pass)) {
                    
                }else{
                    foreach ($validatorPass->getMessages() as $messageId => $message) {
                        echo '<div class="row"><div class="text-center col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12 alert alert-danger" role="alert">La contraseña debe tener entre 6 y 12 caracteres</div></div>';
                    } 
                }
                
                $authAdapter->setTableName('usuario')
                            ->setIdentityColumn('email')
                            ->setCredentialColumn('pass')
                            ->setIdentity($email)
                            ->setCredential($pass);

                $result = Zend_Auth::getInstance()->authenticate($authAdapter);            
     
                if ($result->isValid()) {       
                    $storage = Zend_Auth::getInstance()->getStorage();
                    $data = $authAdapter->getResultRowObject();
                    $storage->write($data);
                    $sesion = new Zend_Session_Namespace();
                    $usuarioTabla = new Application_Model_DbTable_Usuario();
                    $select = $usuarioTabla->select()->where('email = ?', $data->email);
                    $usuario = $usuarioTabla->fetchRow($select);
                    $sesion->_user = $usuario;
                    
                    $this->redirect('/index');
                    return;
                }else{
                    echo "error";
                }
            }

 
        }
        
        $this->view->action = "login";
        $this->view->authForm = $authForm;
    }

    public function signinAction()
    {        
       $createUsuarioForm = new Application_Form_CreateUsuarioForm();    
       $usuarioTabla = new Ventas_Model_DbTable_Usuaro(); 
       $validatorPass = new Zend_Validate_StringLength(array('min' => 6, 'max' => 12));

            
       if ($this->getRequest()->isPost()) {             
            $nombre = $this->getRequest()->getPost('nombre');
            $email = $this->getRequest()->getPost('email');                   
            $pass = $this->getRequest()->getPost('password');   
            var_dump($email);
            if ($validatorPass->isValid($pass)) {
                if ($createUsuarioForm->isValid($this->getRequest()->getPost())) {                                    
                    $newRow = $usuarioTabla->createRow();
                    $newRow->nombre = $nombre;
                    $newRow->email = $email;
                    $newRow->pass = $pass;
                    $newRow->rol = 12;
                    $newRow->save();                    
                    $this->_redirect('/ventas');                
                }                
            }else{                
                echo '<div class="row"><div class="text-center col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12 alert alert-danger" role="alert">No se pudo crear el usuario </div></div>';                                 
            }
        }

        $this->view->createUsuarioForm = $createUsuarioForm;    
        $this->view->action = "registrarse";
    }

    public function logoutAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        Zend_Session::destroy(true);

        $this->_redirect('/auth/login');
    }


}







