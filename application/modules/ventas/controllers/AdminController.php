<?php

class Ventas_AdminController extends Zend_Controller_Action
{

    private $_dataUsuario = null;

    private $_auth = null;

    public function init()
    {
    	$this->_session = new Zend_Session_Namespace();
    	$this->_auth = Zend_Auth::getInstance();
        $this->_dataUsuario = Zend_Auth::getInstance()->getIdentity();

    	$this->_helper->layout->setLayout('layout-admn');    	
    	$this->_helper->layout()->nombre = $this->_session->_user->nombre;
    	$this->_helper->layout()->rol = $this->_session->_user->rol;
        if (!$this->_auth->hasIdentity()) {
            $this->_redirect('/auth/login');
        }
        if (!$this->_dataUsuario->rol == 0) {
        	$this->_redirect('/ventas');
        }
    }

    public function indexAction()
    {
        $articulosTabla = new Application_Model_DbTable_Articulo();
        $pedidoTabla = new Application_Model_DbTable_Pedido();
        $usuarioTabla = new Application_Model_DbTable_Usuario();

        $articulos = $articulosTabla->fetchAll();
        $pedidos = $pedidoTabla->fetchAll();
        $usuarios = $usuarioTabla->fetchAll();

        $this->view->articulos = $articulos;
        $this->view->pedidos = $pedidos;
        $this->view->usuarios = $usuarios;
    }

    public function createArticuloAction()
    {
        $this->_helper->layout->setLayout('layout');
        $createArticuloForm = new Ventas_Form_CreateArticuloForm();                
        $articuloTabla = new Ventas_Model_DbTable_Articulo();
        $validator = new Zend_Validate_Digits();

        if ($this->getRequest()->isPost()) {        	
        	$nombre = $this->getRequest()->getPost('nombre');
            $precio = $this->getRequest()->getPost('precio');
            if ($validator->isValid($precio)) {
                if ($createArticuloForm->isValid($this->getRequest()->getPost())) {
                	$newRow = $articuloTabla->createRow();
                	$newRow->nombre = $nombre;
                	$newRow->precio = $precio;
                	$newRow->save();
                	$this->_redirect('/index');
                }
            }else{
                foreach ($validator->getMessages() as $messageId => $message) {
                    echo '<div class="row"><div class="text-center col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12 alert alert-danger" role="alert">El precio deve ser un valor numerico </div></div>';                 
                }
            }
        }
        $this->view->createArticuloForm = $createArticuloForm;
    }

    public function editArticuloAction()
    {
       $this->_helper->layout->setLayout('layout');
       $createArticuloForm = new Ventas_Form_CreateArticuloForm();    
       $articuloTabla = new Ventas_Model_DbTable_Articulo(); 
       $validator = new Zend_Validate_Float();       
       $id = (int) $this->getRequest()->getParam('id');
       if ($this->getRequest()->isPost()) {       		
        	$nombre = $this->getRequest()->getPost('nombre');
            $precio = (double)$this->getRequest()->getPost('precio');
            if ($validator->isValid($precio)) {
                if ($createArticuloForm->isValid($this->getRequest()->getPost())) {
                	$data = array(
			            'idArticulo'=>$id,
			            'nombre'=>$nombre,
			            'precio'=>$precio
		            );

                	$where = $articuloTabla->getAdapter()->quoteInto('idArticulo = ?', $id);
            		$articuloTabla->update($data,$where);
                	$this->_redirect('/index');
                }
            }else{
                foreach ($validator->getMessages() as $messageId => $message) {
                    echo '<div class="row"><div class="text-center col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12 alert alert-danger" role="alert">El precio deve ser un valor numerico </div></div>';                 
                }
            }
        }else{
        	$articulo = $articuloTabla->fetchRow($articuloTabla->select()->where('idArticulo = ?', $id));
            $data = array(                
                'nombre'=>$articulo->nombre,
                'precio'=>$articulo->precio
            );
            $createArticuloForm->populate($data);
        }
        $this->view->createArticuloForm = $createArticuloForm;    
    }

    public function deleteArticuloAction()
    {
    	$this->_helper->layout->setLayout('layout');
    	$articuloTabla = new Ventas_Model_DbTable_Articulo();
        $id = $this->getRequest()->getParam('id');                        

        if ($this->getRequest()->isPost()) {
            $where = $articuloTabla->getAdapter()->quoteInto('idArticulo = ?', $id);
            $articuloTabla->delete($where);   
            $this->_redirect('/ventas/admin');
        }else{
        	$articulo = $articuloTabla->fetchRow($articuloTabla->select()->where('idArticulo = ?',$id));
        	$this->view->articulo = $articulo;
        }

    }

    public function editUsuarioAction()
    {
       $this->_helper->layout->setLayout('layout');
       $editUsuarioForm = new Ventas_Form_EditUsuarioForm();    
       $usuarioTabla = new Ventas_Model_DbTable_Usuaro(); 

       $email = $this->getRequest()->getParam('id');       
        	
       if ($this->getRequest()->isPost()) {       		
        	$nombre = $this->getRequest()->getPost('nombre');
            $rol = (int)$this->getRequest()->getPost('rol');
            if ($editUsuarioForm->isValid($this->getRequest()->getPost())) {                
            	$data = array(		            
		            'nombre'=>$nombre,
		            'rol'=>$rol
	            );

            	$where = $usuarioTabla->getAdapter()->quoteInto('email = ?', $email);
        		$usuarioTabla->update($data,$where);
            	$this->_redirect('/ventas/admin');                
            }else{                
                echo '<div class="row"><div class="text-center col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12 alert alert-danger" role="alert">No se pudo editar el usuario </div></div>';                                 
            }
        }else{
        	$usuario = $usuarioTabla->fetchRow($usuarioTabla->select()->where('email = ?', $email));
            $data = array(                
                'nombre'=>$usuario->nombre,
                'email'=>$usuario->email,
                'rol'=>$usuario->rol
            );
            $editUsuarioForm->populate($data);            
        }
        $this->view->editUsuarioForm = $editUsuarioForm;    
    }


}









