<?php
/**
 * Clase que genera el formulario para registrar un contacto
 *
 * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
 */
class ContactoForm extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);
        $this->setName('contacto');
        $contacto_id = new Zend_Form_Element_Hidden('contacto_id');
        $contacto_nombres = new Zend_Form_Element_Text('contacto_nombres');
        $contacto_nombres->setLabel('Nombre(s)')
                ->setRequired(true)
                ->addFilter('StripTags')->addFilter('StringTrim')->addValidator('NotEmpty');
        $contacto_apellidos = new Zend_Form_Element_Text('contacto_apellidos');
        $title->setLabel('Apellido(s)')
                ->setRequired(true)
                ->addFilter('StripTags')->addFilter('StringTrim')->addValidator('NotEmpty');
        $submit = new Zend_Form_Element_Submit('Guardar');
        $submit->setAttrib('id', 'btnEnviar');
        $this->addElements(array($contacto_id, $contacto_nombres, $contacto_apellidos, $submit));
    }

}
