<?php

class Model_Module extends PhpORM_Entity
{
    protected $_allowDynamicAttributes = false;
    protected $_daoObjectName = 'AYL_Dao_Module';
    protected $_relationships = array(
        'Pages' => array(
            'repo' => 'AYL_Repo_Page',
            'entity' => 'Model_Page',
            'key' => array('foreign' => 'module_id', 'local' => 'id'),
            'type' => 'many',
        ),
        'Questions' => array(
            'repo' => 'AYL_Repo_Question',
            'entity' => 'Model_Question',
            'key' => array('foreign' => 'module_id', 'local' => 'id'),
            'type' => 'many',
        ),
    );

    protected $id;
    protected $name;
    protected $description;
    protected $date_available;
}