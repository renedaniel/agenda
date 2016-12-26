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
        $data = array(
            'contacto_id' => $contacto->getContactoId(),
            'contacto_nombres' => $contacto->getContactoNombres(),
            'contacto_apellidos' => $contacto->getContactoApellidos(),
            'contacto_correo' => $contacto->getContactoCorreo(),
        );

        if (null === ($id = $contacto->getContactoId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $registro = array(
            'contacto_id' => $row->contacto_id,
            'contacto_nombres' => $row->contacto_nombres,
            'contacto_apellidos' => $row->contacto_empresa,
            'contacto_telefono' => $row->contacto_telefono,
            'contacto_correo' => $row->contacto_correo,
        );
        return $registro;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $registros = array();
        foreach ($resultSet as $row) {
            $registro = new Application_Model_Contacto();
            $registro = array(
                'contacto_id' => $row->contacto_id,
                'contacto_nombres' => $row->contacto_nombres,
                'contacto_apellidos' => $row->contacto_empresa,
                'contacto_telefono' => $row->contacto_telefono,
                'contacto_correo' => $row->contacto_correo,
            );
            $registros[] = $registro;
        }
        return $registros;
    }

}
