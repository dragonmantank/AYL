<?php

class Admin_Form_AddModule extends Zend_Form
{
    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $description = new Zend_Form_Element_Textarea('description');
        $submit = new Zend_Form_Element_Submit('Create Module');

        $name->setLabel('Module Name:')
             ->setRequired();

        $description->setLabel('Description:')
                    ->setRequired();

        $this->addElements(array(
            $name, $description, $submit,
        ));
    }
}