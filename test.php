<?php
include("classes/Question.php");
include("classes/TestAnswer.php");

$questions = array(
    new Question(1, "ask1", array(
        new TestAnswer(1 ,"ans1", true),
        new TestAnswer(2,"ans2", true),
        new TestAnswer(3, "ans3")
    )),
    new Question(2, "ask2", array(
        new TestAnswer(1 ,"ans1"),
        new TestAnswer(2,"ans2"),
        new TestAnswer(3, "ans3")
    )),
    new Question(3, "ask3", array(
        new TestAnswer(1 ,"ans1"),
        new TestAnswer(2,"ans2"),
        new TestAnswer(3, "ans3")
    )),
);

//var_dump($questions);
require("index_start.php");
getTest($questions);
require("index_end.php");

function getTest($questions) {
    echo "<form class=\"test\">";
    foreach ($questions as $question) {
        echo "<div class=\"question\">";
        echo "<div class=\"text\">";
        echo $question->question;
        echo "</div>";

        echo "<div class=\"answers\">";
        echo "<ul>";

        foreach ($question->answers as $answer) {
            echo "<li>";
            if($question->amountOfCorrectQuestions > 1) {
                $type = "checkbox";
            } else {
                $type = "radio";
            }

            $inputId = $question->id.$answer->id;

            echo "<input id='$inputId' name=\"$question->id\" type='$type' value=\"$answer->id\"/> <label for='$inputId'> $answer->text";

            echo "</li>";
        }

        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }
    echo "</form>";
}
