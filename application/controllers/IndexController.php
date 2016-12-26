<?php
/**
 * Controlador principal de la aplicación agenda
 *
 * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
 */
class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    /**
     * Método que muestra la vista con el listado de contactos registrados
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
    public function indexAction() {
        $contactos = new Application_Model_ContactoMapper();
        $this->view->contactos = $contactos->fetchAll();
        $this->view->title = 'Contactos';
    }

    /**
     * Método que envía un JSON con todos los contactos existentes
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
    public function getContactosAction() {
        //Si la petición es ajax envíamos los datos sino redirigimos al index
        if ($this->getRequest()->isXmlHttpRequest()) {
            $contactos = new Application_Model_ContactoMapper();
            $data['data'] = $contactos->fetchAll();
            $this->getHelper('json')->sendJson($data);
        }
        $this->_helper->redirector('index', 'index');
    }

    /**
     * Método que envía un JSON con los datos de un contacto
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
    public function getContactoAction() {
        //Si la petición es ajax y nos envían el id envíamos los datos sino redirigimos al index
        $contactoId = $this->getRequest()->getPost('contactoId');
        if ($this->getRequest()->isXmlHttpRequest() && isset($contactoId)) {
            $contactos = new Application_Model_ContactoMapper();
            $data = $contactos->find($contactoId);
            $this->getHelper('json')->sendJson($data);
        }
        $this->_helper->redirector('index', 'index');
    }

    /**
     * Método que genera el formulario para agregar un contacto
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
    function edicionContactoAction() {
        $this->view->title = "Agregar contacto";
        $form = new Application_Form_Contacto();
        //Si se envian datos, los evalúamos
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $contacto = new Application_Model_Contacto($form->getValues());
                $mapper  = new Application_Model_ContactoMapper();
                $mapper->save($contacto);
                return $this->_helper->redirector('index');
            }
        }
        $this->view->form = $form;
        

    }

}
