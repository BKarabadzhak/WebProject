<?php

class Question {
    private $question;
    private $correctAnswer;
    private $answers;

    function __construct()
    {
        $this->question = "";
        $this->correctAnswer = "";
        $this->answers = array();
    }

    function __construct1($question, $correctAnswer, $answers)
    {
        $this->question = $question;
        $this->correctAnswer = $correctAnswer;
        $this->answers = $answers;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function setQuestion($question) {
        $this->question = $question;
    }

    public function getCorrectAnswer() {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer($correctAnswer) {
        $this->correctAnswer = $correctAnswer;
    }

    public function getAnswers() {
        return $this->answers;
    }

    public function setAnswers($answers) {
        $this->answers = $answers;
    }
}

?>