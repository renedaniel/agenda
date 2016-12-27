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
        //Agregamos el input oculto para el id
        $this->addElement('hidden', 'contacto_id', array(
            'label'      => false,
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));  
        //Agregamos el input del nombre
        $this->addElement('text', 'contacto_nombres', array(
            'label'      => 'Nombre(s):',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'El campo Nombre(s) es obligatorio')),
                array('Alnum', true, array(
                    'messages' => 'El campo Nombre(s) sólo acepta letras y/o números',
                    'allowWhiteSpace' => true,
                )),
                array('Db_NoRecordExists', true, array(
                        'table' => 'contacto',
                        'field' => 'contacto_nombres',
                        'messages' => array(
                            'recordFound' => 'Ya existe un contacto con este nombre'
                ))),
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
        //Agregamos el input de la dirección
        $this->addElement('text', 'contacto_direccion', array(
            'label'      => 'Dirección:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'El campo Dirección es obligatorio')),
                
            )
        ));   
        //Agregamos el input del teléfono
        $this->addElement('text', 'contacto_telefono', array(
            'label'      => 'Teléfono:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'El campo Teléfono es obligatorio')),
                array('Digits', true, array('messages' => 'El campo Teléfono sólo puede tener números')),
                array('StringLength', true, array('messages' => 'El campo Teléfono debe contener almenos 10 caracteres', 'min' => 10)),
                array('Db_NoRecordExists', true, array(
                        'table' => 'contacto',
                        'field' => 'contacto_telefono',
                        'messages' => array(
                            'recordFound' => 'Ya existe un contacto con este teléfono'
                ))),
            )
        ));     	
    	//Agregamos el input del email
        $this->addElement('text', 'contacto_correo', array(
            'label'      => 'Email:',
            'required'   => false,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('EmailAddress', true, array('messages' => 'Debe escribir un email válido')),
                array('Db_NoRecordExists', true, array(
                        'table' => 'contacto',
                        'field' => 'contacto_correo',
                        'messages' => array(
                            'recordFound' => 'Ya existe un contacto con este correo'
                ))),
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

    /**
     * Callback para ejecutar al momento de validar los datos
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     */
    public function isValid($data) {
        //Si se está actualizando un contacto, quitamos el validador de duplicados en los campos correspondientes
        if (isset($data['contacto_id']) && !empty($data['contacto_id'])) {
            //Campo nombres
            $this->getElement('contacto_nombres')
                ->getValidator('Db_NoRecordExists')
                ->setExclude('contacto_id != ' . $data['contacto_id']);
            //Campo teléfono
            $this->getElement('contacto_telefono')
                ->getValidator('Db_NoRecordExists')
                ->setExclude('contacto_id != ' . $data['contacto_id']);
            //Campo correo
            $this->getElement('contacto_correo')
                ->getValidator('Db_NoRecordExists')
                ->setExclude('contacto_id != ' . $data['contacto_id']);
        }
        return parent::isValid($data);
    }

}

