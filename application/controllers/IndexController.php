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
        $this->view->title = 'Contactos';
    }

    /**
     * Método que muestra la vista con la información de la aplicación
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
    public function acercaAction() {
        $this->view->title = 'Sobre la aplicación';
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
            $data['data'] = $contactos->getContactos();
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
            $data = $contactos->getContactoById($contactoId);
            $this->getHelper('json')->sendJson($data);
        }
        $this->_helper->redirector('index', 'index');
    }

    /**
     * Método que genera el formulario para agregar/editar un contacto vía ajax
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
    function edicionContactoAction() {
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->view->title = "Agregar contacto";
            $form = new Application_Form_Contacto();
            //Si se envian datos, los evalúamos
            $request = $this->getRequest()->getPost();
            //Revisamos si se va a editar un usuario para cargar los datos
            if (isset($request['contactoId']) && !empty($request['contactoId'])) {
                $this->view->title = "Editar contacto";
                $contacto = new Application_Model_Contacto();
                $mapper  = new Application_Model_ContactoMapper();
                $contacto = $mapper->getContactoById($request['contactoId']); 
                $form->populate($contacto);
            } elseif (!empty($request)) {
                if ($form->isValid($request)) {
                    $contacto = new Application_Model_Contacto($form->getValues());
                    $mapper  = new Application_Model_ContactoMapper();
                    if ($mapper->save($contacto)) {
                        $this->getResponse()->setHeader('exito', true);
                    }
                }
            }
            $this->view->form = $form;
            $this->_helper->layout()->disableLayout();   
            return;          
        }
        $this->_helper->redirector('index', 'index');
    }

    /**
     * Método que permite eliminar un usuario vía ajax
     *
     * @author René Daniel Galicia Vázquez <renedaniel191992@gmail.com>  
     * @return void
     */
    function eliminarContactoAction() {
        if ($this->getRequest()->isXmlHttpRequest()){
            $contactoId = $this->getRequest()->getPost('contactoId');
            if (isset($contactoId) && !empty($contactoId)) {
                $mapper  = new Application_Model_ContactoMapper();
                if ($mapper->delete($contactoId)) {
                    $this->getResponse()->setHeader('exito', true);
                    $this->_helper->layout()->disableLayout(); 
                    $this->_helper->viewRenderer->setNoRender(true);
                }
            }
            return;
        }
        $this->_helper->redirector('index', 'index');
    }

}
