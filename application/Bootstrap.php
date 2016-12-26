<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * Función que carga las constantes declaradas en el archivo ini
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
    protected function _initConstants() {
        $options = $this->getOption('constants');

        if (is_array($options)) {
            foreach($options as $key => $value) {
                if(!defined($key)) {
                    define($key, $value);
                }
            }
        }
    }

}

