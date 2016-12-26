<?php

class Application_Form_Contacto extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post');
    	$this->setAttribs(array(
    		'id' => 'formularioContacto',
    		'class' => 'col s12'
    	));
    	//Agregamos el input del nombre
        $this->addElement('text', 'contacto_nombres', array(
            'label'      => 'Nombre(s):',
            'required'   => true,
            'filters'    => array('StringTrim'),
			'validators' => array(
            	array('NotEmpty', true, array('messages' => 'El campo Nombre(s) es obligatorio')),
                
            )
        ));     	
    	//Agregamos el input del email
        $this->addElement('text', 'contacto_correo', array(
            'label'      => 'Email:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
            	array('NotEmpty', true, array('messages' => 'El campo Email es obligatorio')),
                array('EmailAddress', true, array('messages' => 'Debe escribir un email válido')),
            )
        ));  
        //Agregamos el botón de enviar
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enviar',
            'class' => 'btn-large btnd'
        ));  	
        //Cambiamos la forma de generar los tags
		$this->clearDecorators();
		$this->addDecorator('FormElements')
		->addDecorator('HtmlTag', array('tag' => '<div>', 'class' => 'row'))
		->addDecorator('Form');

		$this->setElementDecorators(array(
			array('ViewHelper'),
			array('Errors'),
			array('Description'),
			array('Label', array('separator'=>' ')),
			array('HtmlTag', array('tag' => 'div', 'class'=>'input-field col s12')),
		));

		//Quitamos el label del botón de enviar
		$this->getElement('submit')->removeDecorator('Label');

		//Zend_Debug::dump($this);exit;
    }


}

