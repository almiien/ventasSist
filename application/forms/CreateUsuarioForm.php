<?php

class Application_Form_CreateUsuarioForm extends Twitter_Bootstrap3_Form
{

    public function init()
    {
        $this->setMethod('post',array(
            'separator' => PHP_EOL
        ));                       
 
        $this->addElement(
            	'text', 'nombre', array(
                'label' => 'Nombre:',
                'required' => true,
                'filters' => array('StringTrim'),
                'class'=>'form-control',                            
            ));
 
        $this->addElement(
        		'text', 'email', array(
	            'label' => 'Email',                           	           
            ));
 		 $this->addElement('password', 'password', array(
	            'label' => 'Password:',
	            'required' => true,
	            'StringLength'=>array(6),
            ));
        $this->addElement('submit', 'submit', array(
                'ignore'   => true,
                'label'    => 'Aceptar',
                'class'=>'btn-block btn-primary',
            ));
        $this->addElement('submit', 'regresar', array(
                'ignore'   => true,
                'label'    => 'cancelar',
                'class'=>'btn-block btn-danger',
                'href' => '/ventas/admin',
            ));    
    }


}

