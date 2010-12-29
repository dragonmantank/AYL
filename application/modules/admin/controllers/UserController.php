<?php

class Admin_UserController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $repo = new AYL_Repo_User();
        $users = $repo->fetchAll();
        $users->orderBy('username');

        $this->view->users = $users;
    }
}