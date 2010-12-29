<?php

class Admin_FileController extends Zend_Controller_Action
{
    public function browseAction()
    {
        $this->_helper->layout->disableLayout();
        try {
            $files = new DirectoryIterator(APPLICATION_PATH.'/../public/images/uploaded');
        } catch (Exception $e) {
            $files  = array();
        }

        $this->view->files = $files;
    }

    public function uploadAction()
    {
        
    }
}