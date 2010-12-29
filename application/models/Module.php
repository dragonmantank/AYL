<?php

/**
 * @var id int
 * @var name string
 * @var description string
 * @var date_availabe string
 */
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

    /**
     * Clears out all of a user's answers for a module
     * @param int $user_id
     */
    public function clearAnswers($user_id)
    {
        $repo = new AYL_Repo_UserAnswer();
        foreach($this->Questions as $question) {
            $answers = $repo->fetchOneBy(array(
                'user_id' => $user_id,
                'question_id' => $question->id,
            ));
            
            $answers->delete();
        }
    }

    /**
     * Returns the status of a module against a user
     * @param int $user_id
     * @return bool
     */
    public function getStatus($user_id)
    {
        $repo = new AYL_Repo_TestStatus();
        $status = $repo->fetchOneBy(array(
            'module_id' => $this->id,
            'user_id' => $user_id,
        ));

        if($status !== null) {
            return $status->status;
        }

        return null;
    }
}