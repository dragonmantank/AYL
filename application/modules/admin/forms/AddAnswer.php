<?php

class Admin_Form_AddAnswer extends Zend_Form
{
    public function init()
    {
        $text = new Zend_Form_Element_Textarea('text');
        $value = new Zend_Form_Element_Text('value');
        $submit = new Zend_Form_Element_Submit('Create Module');

        $text->setLabel('Answer:')
             ->setRequired();

        $value->setLabel('Value:')
              ->setRequired();

        $submit->setLabel('Add Question');

        $this->addElements(array(
            $text, $value, $submit,
        ));
    }
}