<?php
/**
 * @var id
 * @var module_id
 * @var text
 * @var correct_answer_id
 * @var order
 */
class Model_Question extends PhpORM_Entity
{
    protected $_allowDynamicAttributes = false;
    protected $_daoObjectName = 'AYL_Dao_Question';
    protected $_relationships = array(
        'Answers' => array(
            'repo' => 'AYL_Repo_Answer',
            'entity' => 'Model_Answer',
            'key' => array('foreign' => 'question_id', 'local' => 'id'),
            'type' => 'many',
        ),
        'CorrectAnswer' => array(
            'repo' => 'AYL_Repo_Answer',
            'entity' => 'Model_Answer',
            'key' => array('foreign' => 'id', 'local' => 'correct_answer_id'),
            'type' => 'one',
        ),
    );

    protected $id;
    protected $module_id;
    protected $text;
    protected $correct_answer_id = 0;
    protected $order = 0;

    public function answer(Model_Answer $answer, $user_id)
    {
        $user_answer = new Model_UserAnswer();
        $user_answer->question_id = $this->id;
        $user_answer->answer_id = $answer->id;
        $user_answer->user_id = $user_id;
        $user_answer->save();
    }

    public function isCorrect(Model_Answer $answer)
    {
        if($this->CorrectAnswer !== null) {
            if($this->CorrectAnswer->id == $answer->id) {
                return true;
            }
        }

        return false;
    }
}