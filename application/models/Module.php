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
     * Removes a module, its pages, and questions
     */
    public function delete()
    {
        foreach($this->Pages as $page) {
            $page->delete();
        }

        foreach($this->Questions as $question) {
            $question->delete();
        }

        $repo = new AYL_Repo_TestStatus();
        $statuses = $repo->fetchAllBy('module_id', $this->id);
        foreach($statuses as $status) {
            $status->delete();
        }

        parent::delete();
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

    /**
     * Pulls out all of the pages and resets the orders
     * Since the slide program needs to make sure to have sequential pages,
     * this makes sure that there are no missing pages.
     */
    public function reorderPages()
    {
        $repo = new AYL_Repo_Page();
        $pages = $repo->fetchAll('module_id', $this->id);
        $pages->orderBy('order');

        $order = 1;
        foreach($pages as $page) {
            $page->order = $order;
            $page->save();
            $order++;
        }
    }

    /**
     * Pulls out all of the questions and resets the orders
     * Since the slide program needs to make sure to have sequential questions,
     * this makes sure that there are no missing questions.
     */
    public function reorderQuestions()
    {
        $repo = new AYL_Repo_Question();
        $questions = $repo->fetchAll('module_id', $this->id);
        $questions->orderBy('order');

        $order = 1;
        foreach($questions as $questions) {
            $questions->order = $order;
            $questions->save();
            $order++;
        }
    }
}