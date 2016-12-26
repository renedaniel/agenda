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
        $this->view->title = 'Hoola';
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

}
