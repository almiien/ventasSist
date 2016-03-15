<?php

class Application_Form_AuthForm extends Twitter_Bootstrap3_Form
{

    public function init()
    {
        $this->setMethod('post',array(
            'separator' => PHP_EOL
        ));                       
 
        $this->addElement(
            	'text', 'email', array(
                'label' => 'Email:',
                'required' => true,
                'filters' => array('StringTrim'),
                'class'=>'form-control',                
            ));
 
        $this->addElement('password', 'password', array(
	            'label' => 'Password:',
	            'required' => true,
	            'StringLength'=>array(6),
            ));
 
        $this->addElement('submit', 'submit', array(
	            'ignore'   => true,
	            'label'    => 'Login',
                'class'=>'btn-block btn-primary',
            ));
    }


}

