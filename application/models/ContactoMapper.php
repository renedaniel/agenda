<?php

class Application_Model_ContactoMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('La tabla proporcionada es inválida');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Contacto');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Contacto $contacto) {
        $data = $contacto->toArray();
        $contactoId = $contacto->getContactoId();
        if (!isset($contactoId) || empty($contactoId)) {
            unset($data['contacto_id']);
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array('contacto_id = ?' => $contactoId));
        }
    }

    public function delete($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return false;
        }
        return $this->getDbTable()->delete('contacto_id = '.$id);
    }

    public function find($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        return $row->toArray();
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $registros = array();
        foreach ($resultSet as $row) {
            $registros[] = $row->toArray();
        }
        return $registros;
    }

}
