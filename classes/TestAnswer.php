<?php

class TestAnswer
{
    public $id;
    public $text;
    public $isCorrect;

    public function __construct($id, $text, $isCorrect = false)
    {
        $this->id = $id;
        $this->text = $text;
        $this->isCorrect = $isCorrect;
    }
}
