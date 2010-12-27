<?php

class ModulesController extends Zend_Controller_Action
{
    public function loadAction()
    {
        $repo = new AYL_Repo_Module();
        $module = $repo->find($this->getRequest()->getParam('id'));

        $_SESSION['module_id'] = $module->id;
        $_SESSION['page_number'] = 0;
        $_SESSION['question_number'] = 1;
        
        $this->view->module = $module;
    }

    public function questionsAction()
    {
        $repo = new AYL_Repo_Module();
        $module = $repo->find($_SESSION['module_id']);
        $questions = $module->Questions;

        $question = (isset($_SESSION['question_number']) ? $_SESSION['question_number'] : 1);

        if($this->getRequest()->isPost()) {
            $answer = $this->getRequest()->getPost('answer');
            $question = ++$question;
            if($question > count($questions)) {
                $this->_helper->_redirector('index', 'index');
            } else {
                $_SESSION['question_number'] = $question;
            }
        }

        $this->view->question = $questions->fetchOneBy('order', $question);
    }

    public function viewAction()
    {
        $repo = new AYL_Repo_Module();
        $module = $repo->find($_SESSION['module_id']);
        $action = $this->getRequest()->getParam('go');
        $lastPage = $_SESSION['page_number'];

        $this->view->back = true;

        // Check if we're on a valid page number
        if($lastPage > 0) {
            // If we're going backward, decrement. Otherwise increment.
            if($action == 'back') {
                $pageNum = --$lastPage;
                // If we're back on the first page, disable the back button
                if($pageNum == 1) {
                    $this->view->back = false;
                }
            } else {
                $pageNum = ++$lastPage;
            }
        } else {
            // We're not, so set it to one and disable the back button
            $pageNum = 1;
            $this->view->back = false;
        }

        
        if($pageNum > count($module->Pages)) {
            $this->_helper->_redirector('questions', 'modules');
        }
        
        $_SESSION['page_number'] = $pageNum;

        $page = $module->Pages->fetchOneBy('order', $pageNum);

        $this->view->page = $page;
    }
}