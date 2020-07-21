<?php

function renderTest($questions)
{
    echo "
        <form 
             class=\"test\"
             method=\"POST\"
             name=\"form\"
             action=\"test-result.php\"
             enctype=\"multipart/form-data\"
        >";
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
            } else {
                $type = "radio";
            }

            $inputId = $question->id . $answer->id;

            echo "<input id='$inputId' name=\"$question->id\" type='$type' value=\"$answer->id\"/> <label for='$inputId'>$answer->text</label>";

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
    $sqlQuestion->execute();
    while ($rowQuestion = $sqlQuestion->fetch(PDO::FETCH_ASSOC)) {
        $questionId = $rowQuestion['id'];
        $answersArray = array();
        $sql = $connection->prepare("SELECT * FROM answers WHERE question_id = '" . $questionId . "';");
        $sql->execute();
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($answersArray, new TestAnswer($row['id'], $row['answer'], boolval($row['is_correct'])));
        }
        array_push($questions, new Question($rowQuestion['id'], $rowQuestion['question'], $answersArray));
    }

    return $questions;
}

