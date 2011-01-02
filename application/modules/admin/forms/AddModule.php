<?php

class Admin_Form_AddModule extends Zend_Form
{
    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $description = new Zend_Form_Element_Textarea('description');
        $date_available = new Zend_Form_Element_Text('date_available');
        $submit = new Zend_Form_Element_Submit('Create Module');

        $name->setLabel('Module Name:')
             ->setRequired();

        $date_available->setLabel('Date Available:')
                       ->setRequired();

        $description->setLabel('Description:')
                    ->setRequired();

        $this->addElements(array(
            $name, $date_available, $description, $submit,
        ));
    }
}