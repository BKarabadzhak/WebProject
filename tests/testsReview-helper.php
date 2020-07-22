<?php

function renderTestReview($questions, $testId, $connection)
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
        echo "<button class=\"comment-btn\" type=\"button\" id=\"$question->id\" onclick=\"addQuestionComment(this)\">Add comment</button>";
        echo "</div>";

        echo "<div id=\"div" . $question->id . "\"></div>";

        echo "<div id=\"divSubmited" . $question->id . "\">";

        $submittedComments = array();
        $sql = $connection->prepare("SELECT * FROM questions_comments WHERE question_id = '" . $question->id . "';");

        if (!$sql->execute()) {
            throw "Error " . $sql->errorInfo();
        };

        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($submittedComments, new Comment($row['id'], $row['comment_name'], $row['comment']));
        }

        foreach ($submittedComments as $comment) {
            echo "<div class=\"comment\" id=\"com" . $comment->id . "\">
            <div>
            <span>Comment name: " . $comment->name . "</span><br>
            <span>Comment: " . $comment->comment . "</span><br>
            </div>
            <button class=\"comment-btn\" type=\"button\" id=\"butDel" . $comment->id . "\" onclick=\"deleteComment(this)\">Delete</button>
            </div>";
        }
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
            echo "<button type=\"button\" class=\"comment-btn\" id=\"AnsBut" . "$answer->id\" onclick=\"addAnswerComment(this)\">Add comment</button>";

            echo "</li>";

            echo "<div id=\"divAnsAnsBut" . $answer->id . "\"></div>";

            echo "<div id=\"divAnsSubmitedAnsBut" . $answer->id . "\">";


            $submittedCommentsToAnswer = array();
            $sql = $connection->prepare("SELECT * FROM answers_comments WHERE answer_id = '" . $answer->id . "';");

            if (!$sql->execute()) {
                throw "Error " . $sql->errorInfo();
            };

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                array_push($submittedCommentsToAnswer, new Comment($row['id'], $row['comment_name'], $row['comment']));
            }

            foreach ($submittedCommentsToAnswer as $comment) {
                echo "<div class=\"comment\" id=\"comAns" . $comment->id . "\">
            <div>
            <span>Comment name: " . $comment->name . "</span><br>
            <span>Comment: " . $comment->comment . "</span><br>
            </div>
            <button type=\"button\" class=\"comment-btn\" id=\"butDelAns" . $comment->id . "\" onclick=\"deleteCommentAns(this)\">Delete</button>
            </div>";
            }

            echo "</div>";
        }

        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }

    echo "</form>";
    echo "<div class='align-center'><a href='index.php'>Start Page</a> <br> <a href='dashboard.php'>Tests List</a></div>";
}
