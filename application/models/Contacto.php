<?php

class Application_Model_Contacto {

    protected $_contacto_id;
    protected $_contacto_nombres;
    protected $_contacto_apellidos;
    protected $_contacto_empresa;
    protected $_contacto_telefono;
    protected $_contacto_correo;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propiedad inválida');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propiedad inválida');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set_' .$key;
            $method = preg_replace_callback("/(?:^|_)([a-z])/", function($matches) {
              return strtoupper($matches[1]);
            }, $method);
            $method = lcfirst($method);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    function getContactoNombres() {
        return $this->_contacto_nombres;
    }

    function getContactoId() {
        return $this->_contacto_id;
    }

    function getContactoApellidos() {
        return $this->_contacto_apellidos;
    }

    function getContactoEmpresa() {
        return $this->_contacto_empresa;
    }

    function getContactoTelefono() {
        return $this->_contacto_telefono;
    }

    function getContactoCorreo() {
        return $this->_contacto_correo;
    }

    function setContactoNombres($_contacto_nombres) {
        $this->_contacto_nombres = $_contacto_nombres;
        return $this;
    }

    function setContactoId($_contacto_id) {
        $this->_contacto_id = $_contacto_id;
        return $this;
    }

    function setContactoApellidos($_contacto_apellidos) {
        $this->_contacto_apellidos = $_contacto_apellidos;
        return $this;
    }

    function setContactoEmpresa($_contacto_empresa) {
        $this->_contacto_empresa = $_contacto_empresa;
        return $this;
    }

    function setContactoTelefono($_contacto_telefono) {
        $this->_contacto_telefono = $_contacto_telefono;
        return $this;
    }

    function setContactoCorreo($_contacto_correo) {
        $this->_contacto_correo = $_contacto_correo;
        return $this;
    }

}
