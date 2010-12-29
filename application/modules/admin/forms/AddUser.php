<?php

class Admin_Form_AddUser extends Zend_Form
{
    public function init()
    {
        $username = new Zend_Form_Element_Text('username');
        $real_name = new Zend_Form_Element_Text('real_name');
        $password = new Zend_Form_Element_Text('password');
        $email = new Zend_Form_Element_Text('email');
        $admin = new Zend_Form_Element_Select('admin');
        $submit = new Zend_Form_Element_Submit('submit');

        $username->setLabel('Username:')
                 ->setRequired();

        $real_name->setLabel('Real Name:')
                  ->setRequired();

        $password->setLabel('Password:')
                 ->setRequired();

        $email->setLabel('E-mail Address:')
              ->setRequired()
              ->addValidator(new Zend_Validate_EmailAddress());

        $admin->setLabel('Is Admin:')
              ->setMultiOptions(array(0 => 'No', 1 => 'Yes'));

        $submit->setLabel('Create User');

        $this->addElements(array(
            $username, $real_name, $password, $email, $admin, $submit,
        ));
    }
}