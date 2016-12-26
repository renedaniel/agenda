<?php
/**
 * Clase para generar el formulario para guardar un contacto
 *
 * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
 */
class Application_Form_Contacto extends Zend_Form
{

    /**
     * Método que ejecuta la configuración inicial par generar el formulario
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
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
        //Agregamos el input de los apellidos
        $this->addElement('text', 'contacto_apellidos', array(
            'label'      => 'Apellido(s):',
            'required'   => false,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('Alnum', true, array(
                    'messages' => 'El campo Apellido(s) sólo acepta letras y/o números',
                    'allowWhiteSpace' => true,
                )),
                
            )
        ));   
        //Agregamos el input del nombre
        $this->addElement('text', 'contacto_direccion', array(
            'label'      => 'Dirección:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'El campo Dirección es obligatorio')),
                
            )
        ));   
        //Agregamos el input del nombre
        $this->addElement('text', 'contacto_telefono', array(
            'label'      => 'Teléfono:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'El campo Teléfono es obligatorio')),
                
            )
        ));     	
    	//Agregamos el input del email
        $this->addElement('text', 'contacto_correo', array(
            'label'      => 'Email:',
            'required'   => false,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true, array('messages' => 'Debe escribir un email válido')),
            )
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

    }

}

