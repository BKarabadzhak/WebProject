<?php

$jsonData = file_get_contents('php://input');
$dataClassObject = json_decode($jsonData);
$associativeArray = json_decode(json_encode($dataClassObject), TRUE);



function renderTestReview($questions, $testId)
{
    echo "
        <form 
             class=\"test\"
             method=\"POST\"
             name=\"form\"
             action=\"./tests/testsReview-helper.php\"
             enctype=\"multipart/form-data\"
        >";  
    echo "<input hidden='true' name='testId' value='$testId'>";
    foreach ($questions as $question) {
        echo "<div class=\"question\">";
        echo "<div class=\"text\">";
        echo $question->question;
        echo "<button type=\"button\" id=\"$question->id\" onclick=\"addQuestionComment(this)\">Add comment</button>";
        echo "</div>";

        echo "<div id=\"div" . $question->id . "\"></div>";

        echo "<div id=\"divSubmited" . $question->id . "\"></div>";

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

    //echo "<input type=\"submit\" value=\"Submit\" class='submit-test' />";
    echo "</form>";
}
