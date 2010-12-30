<?php

class Admin_Form_AddPage extends Zend_Form
{
    public function init()
    {
        $title = new Zend_Form_Element_Text('title');
        $text = new Zend_Form_Element_Textarea('text');
        $submit = new Zend_Form_Element_Submit('submit');

        $title->setLabel('Page Title:')
              ->setRequired();

        $text->setLabel('Text:')
             ->setRequired();

        $submit->setLabel('Add Page');

        $this->addElements(array(
            $title, $text, $submit,
        ));
    }
}