<?php

class Question {
    public $id;
    public $question;
    public $answers;
    public $amountOfCorrectQuestions;

    function __construct($id, $question, $answers)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answers = $answers;

        $this->amountOfCorrectQuestions = 0;
        foreach ($answers as $ans) {
            if ($ans->isCorrect) {
                $this->amountOfCorrectQuestions++;
            }
        }
    }

    public function getCorrectAnswers() 
    {
        $correctAns = array();
        foreach($this->answers as $answer) {
            if($answer->isCorrect) {
                array_push($correctAns, $answer);
            }
        }

        return $correctAns;
    }
}

?>
