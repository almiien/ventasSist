<?php

class Ventas_IndexController extends Zend_Controller_Action
{

    private $_dataUsuario = null;

    private $_auth = null;

    public function init()
    {
        $this->_session = new Zend_Session_Namespace();
        $this->_auth = Zend_Auth::getInstance();
        $this->_dataUsuario = Zend_Auth::getInstance()->getIdentity();
        
        $this->_helper->layout()->nombre = $this->_session->_user->nombre;
        $this->_helper->layout()->rol = $this->_session->_user->rol;
        if (!$this->_auth->hasIdentity()) {
            $this->_redirect('/auth/login');
        }
    }

    public function indexAction()
    {
        $articulosTabla = new Application_Model_DbTable_Articulo();
        //$pedidoTabla = new Application_Model_DbTable_Pedido();        

        $articulos = $articulosTabla->fetchAll();
        //$pedidos = $pedidoTabla->fetchAll();
        
        $this->view->articulos = $articulos;        
    }

    public function pedidoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $pedidoTabla = new Application_Model_DbTable_Pedido();
        $data = array();        
        if ($this->getRequest()->isPost()) {
            foreach ($post= $this->getRequest()->getPost() as $post) {
                if (isset($post['cantidad'])) {
                    array_push($data, $post);                
                }
            }            
            foreach ($data as $pedido) {
                $newRow = $pedidoTabla->createRow();
                $newRow->cantidad = $pedido['cantidad'];
                $newRow->articulo_idArticulo = $pedido['id'];
                $newRow->usuario_email = $this->_dataUsuario->email;
                $newRow->fecha = (new DateTime())->format('Y-m-d H:i:s');
                $newRow->save();                
            }
            echo "ok";
        }        
    }


}



