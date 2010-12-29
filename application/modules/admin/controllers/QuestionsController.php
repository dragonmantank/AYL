<?php

class Admin_QuestionsController extends Zend_Controller_Action
{
    public function setcorrectAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $question_id = $this->getRequest()->getParam('question');
        $answer_id = $this->getRequest()->getParam('answer');

        $repo = new AYL_Repo_Question();
        $question = $repo->find($question_id);
        $question->correct_answer_id = $answer_id;
        $question->save();
    }
}