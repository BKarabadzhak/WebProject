<?php
include_once "database-connection.php";
include_once("classes/Question.php");
include_once("classes/TestAnswer.php");

$jsonData = file_get_contents('php://input');
$dataClassObject = json_decode($jsonData);
$associativeArray = json_decode(json_encode($dataClassObject), TRUE);

if ($associativeArray == null) {
    echo "Go back to the <a href=\"dashboard.php\">page</a> and select the test you want.";
    exit();
}

$testId = $associativeArray['testId'];
$connection = openCon();

$questionss = getQuestions($connection, $testId);

class SimpleXMLExtended extends SimpleXMLElement
{
    public function addCData($cdata_text)
    {
        $node = dom_import_simplexml($this);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdata_text));
    }
}

$xml = new SimpleXMLExtended("<?xml version=\"1.0\" encoding=\"UTF-8\"?><quiz></quiz>");

foreach ($questionss as $questions) {
    $numberOfCorrectAnswers = $questions->amountOfCorrectQuestions;
    $weightCorrectAnswer = 100 / $numberOfCorrectAnswers;

    $question = $xml->addChild('question');
    $question->addAttribute('type', 'multichoice');
    $name = $question->addChild('name');
    $name->addChild('text', $questions->id);
    $questiontext = $question->addChild('questiontext');
    $questiontext->addAttribute('format', 'html');
    $questiontext->addChild('text')->addCData("<p>" . $questions->question . "</p>");
    $generalfeedback = $question->addChild('generalfeedback');
    $generalfeedback->addAttribute('format', 'html');
    $generalfeedback->addChild('text');
    $question->addChild('defaultgrade', '1.0000000');
    $question->addChild('penalty', '0.3333333');
    $question->addChild('hidden', '0');
    $question->addChild('idnumber');
    if ($numberOfCorrectAnswers == 1) {
        $question->addChild('single', 'true');
    } else {
        $question->addChild('single', 'false');
    }
    $question->addChild('shuffleanswers', 'true');
    $question->addChild('answernumbering', 'abc');
    $correctfeedback = $question->addChild('correctfeedback');
    $correctfeedback->addAttribute('format', 'html');
    $correctfeedback->addChild('text', 'Вашият отговор е верен.');
    $partiallycorrectfeedback = $question->addChild('partiallycorrectfeedback');
    $partiallycorrectfeedback->addAttribute('format', 'html');
    $partiallycorrectfeedback->addChild('text', 'Вашият отговор отчасти е верен.');
    $incorrectfeedback = $question->addChild('incorrectfeedback');
    $incorrectfeedback->addAttribute('format', 'html');
    $incorrectfeedback->addChild('text', 'Вашият отговор не е верен.');
    $question->addChild('shownumcorrect');
    foreach ($questions->answers as $answerr) {
        $answer = $question->addChild('answer');
        if ($answerr->isCorrect == true) {
            $answer->addAttribute('fraction', $weightCorrectAnswer);
        } else {
            $answer->addAttribute('fraction', '0');
        }
        $answer->addAttribute('format', 'html');
        $answer->addChild('text')->addCData("<p>" . $answerr->text . "</p>");
        $feedback = $answer->addChild('feedback');
        $feedback->addAttribute('format', 'html');
        $feedback->addChild('text');
    }
}

$fileName = "./XMLFiles/file" . $testId . ".xml";
if (!file_exists($fileName)) {
    $xml->saveXML($fileName);
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

?>