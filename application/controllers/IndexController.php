<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $repo = new AYL_Repo_Module();
        $modules = $repo->fetchAll();

        $this->view->user_id = Zend_Auth::getInstance()->getIdentity()->id;
        $this->view->modules = $modules;
    }

    public function restrictedAction()
    {
        
    }
}

