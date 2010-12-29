<?php

class Admin_UserController extends Zend_Controller_Action
{
    public function addAction()
    {
        $form = new Admin_Form_AddUser();

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $data = $form->getValues();
                $data['password'] = hash('sha384', $data['password']. 'MySecretHash');

                $user = new Model_User($data);
                try {
                    $user->save();
                    $this->_helper->redirector('index');
                } catch(Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            } else {
                $this->view->message = "There was a problem with your submission";
            }
        }

        $this->view->form = $form;
    }

    public function indexAction()
    {
        $repo = new AYL_Repo_User();
        $users = $repo->fetchAll();
        $users->orderBy('username');

        $this->view->users = $users;
    }
}