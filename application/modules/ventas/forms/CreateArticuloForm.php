<?php

class Ventas_Form_CreateArticuloForm extends Twitter_Bootstrap3_Form
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
        		'text', 'precio', array(
	            'label' => 'Precio',
	            'required' => true,
	            'validator'=>'Digits',
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

