<?php

class ModulesController extends Zend_Controller_Action
{
    public function completedAction()
    {
        if($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            if(isset($data['confirm']) && $data['confirm'] == 'Yes') {
                $repo = new AYL_Repo_TestStatus();
                $module_id = $this->getRequest()->getParam('id');
                $user_id = Zend_Auth::getInstance()->getIdentity()->id;
                $status = $repo->fetchOneBy(array(
                    'module_id' => $module_id,
                    'user_id' => $user_id,
                ));

                $status->delete();

                $repo = new AYL_Repo_Module();
                $module = $repo->find($module_id);
                $module->clearAnswers($user_id);

                $this->_forward('load');
            } else {
                $this->_helper->redirector('index', 'index');
            }
        }
    }
    
    public function loadAction()
    {
        $repo = new AYL_Repo_Module();
        $module = $repo->find($this->getRequest()->getParam('id'));

        if($module->getStatus(Zend_Auth::getInstance()->getIdentity()->id) !== null) {
            $this->_forward('completed');
        }
        
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

        $question_number = (isset($_SESSION['question_number']) ? $_SESSION['question_number'] : 1);
        $question = $questions->fetchOneBy('order', $question_number);

        if($this->getRequest()->isPost()) {
            $answerValue = $this->getRequest()->getPost('answer');
            $answer = $question->Answers->fetchOneBy('value', $answerValue);

            $user = Zend_Auth::getInstance()->getIdentity();

            $question->answer($answer, $user->id);

            $question_number = ++$question_number;
            $question = $questions->fetchOneBy('order', $question_number);
            
            if($question_number > count($questions)) {
                $this->_helper->_redirector('score', 'modules');
            } else {
                $_SESSION['question_number'] = $question_number;
            }
        }

        $this->view->question = $question;
    }

    public function scoreAction()
    {
        $user_answers = new PhpORM_Collection();

        $repo = new AYL_Repo_Question();
        $arepo = new AYL_Repo_UserAnswer();

        $questions = $repo->fetchAllBy('module_id', $_SESSION['module_id']);

        foreach($questions as $question) {
            $answer = $arepo->fetchOneBy(array(
                'question_id' => $question->id,
                'user_id' => Zend_Auth::getInstance()->getIdentity()->id,
            ));

            $user_answers->append($answer);
        }

        $scorer = new AYL_TestScorer($user_answers);
        $scorer->score();

        $this->view->scorer = $scorer;

        $testStatus = new Model_TestStatus(array(
            'module_id' => $_SESSION['module_id'],
            'user_id' => Zend_Auth::getInstance()->getIdentity()->id,
            'status' => $scorer->passed(),
        ));
        $testStatus->save();
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