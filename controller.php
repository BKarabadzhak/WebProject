<?php
include "database-connection.php";

if ($_POST['testName']) {
    $GLOBALS['testName'] = $_POST['testName'];
} else {
    showErrorMessageFileIsNotNamed();
}

if ($_FILES["file"]["tmp_name"]) {

    $connection = openCon();
    $GLOBALS['connection'] = $connection;

    addRowInTests($connection);

    $row = 1;
    if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($row != 1) {
                addRowInQuestions($connection, $data);
                addRowInAnswers($connection, $data);
            }
            $row++;
        }

        fclose($handle);
    }
} else {
    showErrorMessageFileIsNotSet();
}

echo "<p>Your test " . $GLOBALS['testName'] . " has been loaded.</p>";

function showErrorMessageFileIsNotNamed()
{
    echo "<p>File isn't named</p>";
}

function showErrorMessageFileIsNotSet()
{
    echo "<p>File isn't set</p>";
}

function addRowInTests($connection)
{
    $sql = $connection->prepare("INSERT INTO tests (name) VALUES (?)");
    $sql->execute(array($GLOBALS['testName']));

    setCurrentTestId($connection, $GLOBALS['testName']);
}

function addRowInQuestions($connection, $data)
{
    $sql = $connection->prepare("INSERT INTO questions (question, test_id) VALUES (?, ?)");
    $sql->execute(array($data[0], $GLOBALS['testId']));

    setQuestionId($connection);
}

function addRowInAnswers($connection, $data)
{
    $answersNumber = count($data) - 2;
    $correctAnswersNumber = $data[1];

    if ($correctAnswersNumber > $answersNumber) {
        echo 'The number of correct answers is more than the answers themselves (the line is incorrect)';
        return;
    }

    $boolean = null;
    for ($i = 0; $i < $answersNumber; $i++) {
        $sql = $connection->prepare("INSERT INTO answers (answer, is_correct, question_id) VALUES (?, ?, ?)");
        if ($i < $correctAnswersNumber) {
            $boolean = true;
        } else {
            $boolean = false;
        }

        $sql->execute(array($data[$i + 2], $boolean, $GLOBALS['questionId']));
    }
}

function setCurrentTestId($connection, $testName)
{
    $sql = $connection->prepare("SELECT id FROM tests WHERE name = '" . $testName . "';");
    $sql->execute();
    $id = $sql->fetch(PDO::FETCH_ASSOC);
    $GLOBALS['testId'] = $id['id'];
}

function setQuestionId($connection)
{
    $GLOBALS['questionId'] = $connection->lastInsertId();
}
