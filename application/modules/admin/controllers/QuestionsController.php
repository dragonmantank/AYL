<?php

class Admin_QuestionsController extends Zend_Controller_Action
{
    public function deleteAction()
    {
        $repo = new AYL_Repo_Question();
        $question_id = $this->getRequest()->getParam('question');
        $question = $repo->find($question_id);

        if($this->getRequest()->isPost()) {
            if($this->getRequest()->getParam('confirm')) {
                $modrepo = new AYL_Repo_Module();
                $module = $modrepo->find($question->module_id);
                $question->delete();
                $module->reorderQuestions();
            }

            $this->_helper->redirector('edit', 'modules', 'admin', array('id'=> $question->module_id));
        }

        $this->view->question = $question;
    }

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