<?php

class AYL_TestScorer
{
    /**
     * Number of correct answers
     * @var int
     */
    protected $correct = 0;

    /**
     * Number of incorrect answers
     * @var int
     */
    protected $incorrect = 0;

    /**
     * Answers to score
     * @var PhpORM_Collection
     */
    protected $user_answers;

    /**
     * Takes a module and a user ID
     */
    public function __construct($user_answers)
    {
        $this->user_answers = $user_answers;
    }

    /**
     * Returns the number of correct answers
     * @return int
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Returns the number of incorrect answers
     * @return int
     */
    public function getIncorrect()
    {
        return $this->incorrect;
    }

    /**
     * Scores the test
     */
    public function score()
    {
        $qrepo = new AYL_Repo_Question();
        $arepo = new AYL_Repo_Answer();
        $this->correct = 0;

        foreach($this->user_answers as $set) {
            $question = $qrepo->find($set->question_id);
            $answer = $arepo->find($set->answer_id);
            if($question->isCorrect($answer)) {
                $this->correct++;
            } else {
                $this->incorrect++;
            }
        }
    }

    /**
     * Returns whether or not the user passed the test
     *
     * @return bool
     */
    public function passed()
    {
        return ($this->correct == count($this->user_answers) ? true : false);
    }
}