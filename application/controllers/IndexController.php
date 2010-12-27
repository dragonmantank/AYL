<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $repo = new AYL_Repo_Module();
        $modules = $repo->fetchAll();

        $this->view->modules = $modules;
    }
}

