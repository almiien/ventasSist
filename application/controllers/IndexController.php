<?php

class IndexController extends Zend_Controller_Action
{

    private $_dataUsuario = null;

    private $_auth = null;

    public function init()
    {
    	$this->_auth = Zend_Auth::getInstance();
        $this->_dataUsuario = Zend_Auth::getInstance()->getIdentity();
    }

    public function indexAction()
    {
        if (!$this->_auth->hasIdentity()) {
            $this->_redirect('/auth/login');
        }else{
        	switch($this->_dataUsuario->rol){
        		case 0:
	                $this->_redirect('/ventas/admin');
	                break;
	            case 1:
	                $this->_redirect('/ventas/');
	                break;
                default:
                    $this->_redirect('/ventas/');
	       }        	
        }
    }

    public function pedidoAction()
    {
        // action body
    }


}



