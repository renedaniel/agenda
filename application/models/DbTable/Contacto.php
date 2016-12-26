<?php
/**
 * Clase para conectar a la bd con la tabla de contacto
 *
 * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
 */
class Application_Model_DbTable_Contacto extends Zend_Db_Table_Abstract {

    protected $_name = 'contacto';
    protected $_primary = 'contacto_id';

}
