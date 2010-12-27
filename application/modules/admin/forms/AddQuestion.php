<?php

class Admin_Form_AddQuestion extends Zend_Form
{
    public function init()
    {
        $text = new Zend_Form_Element_Textarea('text');
        $submit = new Zend_Form_Element_Submit('Create Module');

        $text->setLabel('Question:')
             ->setRequired();

        $submit->setLabel('Add Question');

        $this->addElements(array(
            $text, $submit,
        ));
    }
}