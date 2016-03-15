<?php

class Ventas_Form_EditUsuarioForm extends Twitter_Bootstrap3_Form
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
                'disabled' => true,	            	            
            ));
 		
 		$this->addElement(
        		'select', 'rol', array(
	            'label' => 'Rol',
	            'required' => true,                
	            'multiOptions' => array( '0' => 'Administrador', '1' => 'Cliente',)
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

