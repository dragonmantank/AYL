<?php

class Model_TestStatus extends PhpORM_Entity
{
    protected $_daoObjectName = 'AYL_Dao_TestStatus';

    protected $id;
    protected $module_id;
    protected $user_id;
    protected $status;
}