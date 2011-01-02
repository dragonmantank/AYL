<?php

class Admin_QuestionsController extends Zend_Controller_Action
{
    public function editAction()
    {
        $form = new Admin_Form_AddQuestion();
        $repo = new AYL_Repo_Question();
        $question = $repo->find($this->getRequest()->getParam('question'));

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();

                $question->text = $data['text'];
                $question->save();
            }
        }

        $form->getElement('text')->setValue($question->text);
        $form->getElement('submit')->setLabel('Save Question');

        $this->view->form = $form;
        $this->view->question = $question;
    }

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