<?php
include "database-connection.php";
include("classes/Question.php");
include("classes/TestAnswer.php");

$jsonData = file_get_contents('php://input');
$dataClassObject = json_decode($jsonData);
$associativeArray = json_decode(json_encode($dataClassObject), TRUE);

if ($associativeArray == null) {
    echo "Go back to the <a href=\"dashboard.php\">page</a> and select the test you want.";
    exit();
}

$testId = $associativeArray['testId'];
$connection = openCon();

$questions = getQuestions($connection, $testId);

$xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><quiz></quiz>");

for ($i = 0; $i < count($questions); $i++) {
    $question = $xml->addChild('question');
    //$question->addAttribute();
    $track->addChild('path', "song$i.mp3");
    $track->addChild('title', "Track $i - Track Title");
}

$fileName = "./XMLFiles/file" . $testId . ".xml";
if (!file_exists($fileName)) {
    $xml->saveXML($fileName);
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

?>