<?php

class Admin_Form_AddQuestion extends Zend_Form
{
    public function init()
    {
        $text = new Zend_Form_Element_Textarea('text');
        $submit = new Zend_Form_Element_Submit('submit');

        $text->setLabel('Question:')
             ->setAttrib('style', 'height: 150px')
             ->setRequired();

        $submit->setLabel('Add Question');

        $this->addElements(array(
            $text, $submit,
        ));
    }
}