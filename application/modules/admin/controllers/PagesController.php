<?php

class Admin_PagesController extends Zend_Controller_Action
{
    public function updateorderAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $pageList = explode(',', $this->getRequest()->getPost('pages'));

        $repo = new AYL_Repo_Page();
        $pages = $repo->fetchAllBy('module_id', $this->getRequest()->getParam('mod'));

        $order = 1;
        foreach($pageList as $pageId) {
            if(!empty($pageId)) {
                list(, $id) = explode('-', $pageId);
                $page = $pages->fetchOneBy('id', $id);
                $page->order = $order;
                $page->save();
                
                $order++;
            }
        }

        echo json_encode(array('status' => 1));
    }
}