<?php
include_once("tests/tests-helper.php");
include_once("database-connection.php");
require_once("index_start.php");

if (!$_POST['testId']) {
    echo "Something going wrong";
    exit();
}

$connection = openCon();
$questions = getQuestions($connection, $_POST["testId"]);
$answered_questions_ids = array_slice(array_keys($_POST), 1);
$points = 0;

foreach($questions as $question) {
    $answerId = getAnswer($question, $answered_questions_ids, $_POST);
    
    if($answerId) {
        if(is_array($answerId)) {
            foreach($answerId as $ansId) {
                if(isCorrectAns($question, $ansId)) {
                    $points += 1 / $question->amountOfCorrectQuestions;
                }
            }
        } else {
            if(isCorrectAns($question, $answerId)) {
                $points++;
            }
        }
    }
}

echo "<div class=\"dialog\"> 
<div>You've earned $points points.</div>
<div><a href='index.php'>Start Page</a></div>
</div>";


function getAnswer($question, $asnwered_ids, $post)  {
    foreach($asnwered_ids as $id) {
        if($question->id == $id) {
            return $post[$id]; 
        }
    }

    return null;
}

function isCorrectAns($question, $answerId) {
    $correctAnss = $question->getCorrectAnswers();

    foreach($correctAnss as $cAns) {
        if($cAns->id == $answerId) {
            return true;
        } 
    }
    return false;
}

require_once("index_end.php");
?>
