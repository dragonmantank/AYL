<?php

class Admin_ModulesController extends Zend_Controller_Action
{
    public function addAction()
    {
        $form = new Admin_Form_AddModule();

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $module = new Model_Module($form->getValues());
                try {
                    $module->save();
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

    public function addanswerAction()
    {
        $form = new Admin_Form_AddAnswer();

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $answer = new Model_Answer($form->getValues());
                try {
                    $answer->question_id = $this->getRequest()->getParam('question');
                    $answer->save();
                    $this->_helper->redirector->gotoUrl('/admin/modules/editquestion/question/'.$answer->question_id);
                } catch(Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            } else {
                $this->view->message = "There was a problem with your submission";
            }
        }

        $this->view->form = $form;
    }

    public function addpageAction()
    {
        $form = new Admin_Form_AddPage();

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $page = new Model_Page($form->getValues());
                try {
                    $page->module_id = $this->getRequest()->getParam('mod');
                    $page->save();
                    $this->_helper->redirector->gotoUrl('/admin/modules/edit/id/'.$this->getRequest()->getParam('mod'));
                } catch(Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            } else {
                $this->view->message = "There was a problem with your submission";
            }
        }

        $this->view->form = $form;
    }

    public function addquestionAction()
    {
        $form = new Admin_Form_AddQuestion();

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $question = new Model_Question($form->getValues());
                try {
                    $question->module_id = $this->getRequest()->getParam('mod');
                    $question->save();
                    $this->_helper->redirector->gotoUrl('/admin/modules/editquestion/question/'.$question->id);
                } catch(Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            } else {
                $this->view->message = "There was a problem with your submission";
            }
        }

        $this->view->form = $form;
    }

    public function editAction()
    {
        $repo = new AYL_Repo_Module();
        $module = $repo->find($this->getRequest()->getParam('id'));

        $this->view->module = $module;
    }

    public function editquestionAction()
    {
        $repo = new AYL_Repo_Question();
        $question = $repo->find($this->getRequest()->getParam('question'));

        $this->view->question = $question;
    }

    public function indexAction()
    {
        $repo = new AYL_Repo_Module();
        $modules = $repo->fetchAll();

        $this->view->modules = $modules;
    }
}