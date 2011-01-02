<?php

class Admin_ModulesController extends Zend_Controller_Action
{
    public function addAction()
    {
        $form = new Admin_Form_AddModule();

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $data = $form->getValues();
                try {
                    $module = new Model_Module();
                    $module->name = $data['name'];
                    $module->description = $data['description'];
                    $date = new DateTime($data['date_available']);
                    $module->date_available = $date->format('Y-m-d h:i:s');
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
        $module_id = $this->getRequest()->getParam('mod');

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $page = new Model_Page($form->getValues());
                try {
                    $repo = new AYL_Repo_Module();
                    $module = $repo->find($module_id);
                    $page->module_id = $module->id;
                    $page->order = (count($module->Pages)+1);
                    $page->save();
                    $this->_helper->redirector->gotoUrl('/admin/modules/edit/id/'.$this->getRequest()->getParam('mod'));
                } catch(Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            } else {
                $this->view->message = "There was a problem with your submission";
            }
        }

        $this->view->module_id = $module_id;
        $this->view->form = $form;
    }

    public function addquestionAction()
    {
        $form = new Admin_Form_AddQuestion();
        $module_id = $this->getRequest()->getParam('mod');

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $question = new Model_Question($form->getValues());
                try {
                    $repo = new AYL_Repo_Module();
                    $module = $repo->find($module_id);
                    $question->module_id = $module->id;
                    $question->order = (count($module->Questions) + 1);
                    $question->save();
                    $this->_helper->redirector->gotoUrl('/admin/questions/edit/question/'.$question->id);
                } catch(Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            } else {
                $this->view->message = "There was a problem with your submission";
            }
        }

        $this->view->module_id = $module_id;
        $this->view->form = $form;
    }

    public function editAction()
    {
        $form = new Admin_Form_AddQuestion();
        $repo = new AYL_Repo_Module();
        $module = $repo->find($this->getRequest()->getParam('id'));
        $pages = $module->Pages;

        $this->view->pages = $pages;
        $this->view->module = $module;
        $this->view->form = $form;
    }

    public function indexAction()
    {
        $repo = new AYL_Repo_Module();
        $modules = $repo->fetchAll();

        $this->view->modules = $modules;
    }
}