<?php

include_once("classes/TestAnswer.php");
include_once("classes/Question.php");

function renderTest($questions, $testId)
{
    echo "
        <form 
             class=\"test\"
             method=\"POST\"
             name=\"form\"
             action=\"test-result.php\"
             enctype=\"multipart/form-data\"
        >";
    echo "<input hidden='true' name='testId' value='$testId'>";
    foreach ($questions as $question) {
        echo "<div class=\"question\">";
        echo "<div class=\"text\">";
        echo $question->question;
        echo "</div>";

        echo "<div class=\"answers\">";
        echo "<ul>";

        foreach ($question->answers as $answer) {
            echo "<li>";
            if ($question->amountOfCorrectQuestions > 1) {
                $type = "checkbox";
                $name = $question->id . "[]";
            } else {
                $type = "radio";
                $name = $question->id;
            }

            $inputId = $question->id . $answer->id;
            

            echo "<input id='$inputId' name=\"$name\" type='$type' value=\"$answer->id\"/> <label for='$inputId'>$answer->text</label>";

            echo "</li>";
        }

        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }

    echo "<button type='submit' class='submit-test'>Submit</button>";
    echo "</form>";
}

function getQuestions($connection, $testId)
{
    $questions = array();
    $sqlQuestion = $connection->prepare("SELECT * FROM questions WHERE test_id = '" . $testId . "';");
   
    if(!$sqlQuestion->execute()) {
        throw "Error ".$sqlQuestion->errorInfo();
    }

    while ($rowQuestion = $sqlQuestion->fetch(PDO::FETCH_ASSOC)) {
        $questionId = $rowQuestion['id'];
        $answersArray = array();
        $sql = $connection->prepare("SELECT * FROM answers WHERE question_id = '" . $questionId . "';");
        
        if(!$sql->execute()) {
            throw "Error ".$sql->errorInfo();
        };

        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($answersArray, new TestAnswer($row['id'], $row['answer'], boolval($row['is_correct'])));
        }
        array_push($questions, new Question($rowQuestion['id'], $rowQuestion['question'], $answersArray));
    }

    return $questions;
}