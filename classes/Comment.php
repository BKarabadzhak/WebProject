<?php

class Comment
{
    public $id;
    public $name;
    public $comment;

    public function __construct($id, $name, $comment)
    {
        $this->id = $id;
        $this->name = $name;
        $this->comment = $comment;
    }
}
