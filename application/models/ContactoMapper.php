<?php
/**
 * Clase para mapear los datos de los contactos
 *
 * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
 */
class Application_Model_ContactoMapper {

    protected $_dbTable;
    protected $_db;

    /**
     * Método que establece la tabla utilizada por el modelo
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>
     * @param Application_Model_DbTable_Contacto $dbTable tabla del modelo
     * @return Application_Model_ContactoMapper $this
     */
    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('La tabla proporcionada es inválida');
        }
        $this->_dbTable = $dbTable;
        $this->_db = $this->_dbTable->getAdapter();
        return $this;
    }

    /**
     * Método que obtiene el la tabla utilizada por el modelo
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>    
     * @return Application_Model_DbTable_Contacto tabla utilizada por el modelo
     */
    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Contacto');
        }
        return $this->_dbTable;
    }

    /**
     * Método que obtiene el adaptador de la BD
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>    
     * @return Zend_Db_Adapter_Abstract adaptador de la BD utilizado por la tabla
     */
    public function getDb() {
        if (null === $this->_db) {
            $this->setDbTable('Application_Model_DbTable_Contacto');
        }
        return $this->_db;
    }

    /**
     * Método que guarda o actualiza un contacto utilizando transacciones
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>    
     * @return Boolean indicando si se guardo/actualizó o no el contacto
     */
    public function save(Application_Model_Contacto $contacto) {
        $data = $contacto->toArray();
        $contactoId = $contacto->getContactoId();
        if (!isset($contactoId) || empty($contactoId)) {
            unset($data['contacto_id']);
            //Guardamos un nuevo contacto
            $this->getDb()->beginTransaction();
            try {
                $this->getDb()->insert('contacto', $data);
                $this->getDb()->commit();
                return true;
            } catch (Exception $e) {
                $this->getDb()->rollBack();
                return false;
            }
        } else {
            //Actualizamos el contacto
            $this->getDb()->beginTransaction();
            try {
                $this->getDb()->update('contacto', $data, 'contacto_id = '.$contactoId);
                $this->getDb()->commit();
                return true;
            } catch (Exception $e) {
                $this->getDb()->rollBack();
                return false;
            }
        }
    }

    /**
     * Método que elimina un contacto por su id utilizando transacciones
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>    
     * @return Boolean indicando si se elimino o no el contacto
     */
    public function delete($contactoId) {
        $this->getDb()->beginTransaction();
        try {
            $this->getDb()->delete('contacto', 'contacto_id = '.$contactoId);
            $this->getDb()->commit();
            return true;
        } catch (Exception $e) {
            $this->getDb()->rollBack();
            return false;
        }
    }

    /**
     * Método que utiliza el PA getContactoById() para obtener un contacto por su id
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>    
     * @return Array $resultSet Arreglo con los datos del valor encontrado, vacío si no existe el id
     */
    public function getContactoById($contactoId) {
        $resultSet = $this->getDbTable()->getAdapter()->query("CALL getContactoById(?)", $contactoId);
        return reset($resultSet->fetchAll());
    }

    /**
     * Método que utiliza el PA getContactos() para obtener todos los contactos de la BD
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>    
     * @return Array $resultSet Arreglo con todos los contactos en la BD
     */
    public function getContactos() {
        $resultSet = $this->getDbTable()->getAdapter()->query("CALL getContactos()");
        return $resultSet->fetchAll();
    }

}
