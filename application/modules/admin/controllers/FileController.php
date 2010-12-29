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
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $funcNum = $_GET['CKEditorFuncNum'] ;

        $upload = new Zend_File_Transfer_Adapter_Http();
        $upload->setDestination(APPLICATION_PATH.'/../public/images/uploaded');
        $upload->receive();

        try {
            $url = '/images/uploaded/'.basename($upload->getFileName());
        } catch(Zend_File_Transfer_Exception $e) {
            $message = $e->getMessage();
            $url = '';
        }

        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    }
}