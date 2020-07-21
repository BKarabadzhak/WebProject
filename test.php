<?php
include_once("classes/Question.php");
include_once("classes/TestAnswer.php");
include_once "database-connection.php";
include_once("./tests/tests-helper.php");

if (!isset($_GET['id'])) {
    echo "First select the test you want to take.<br>";
    echo "Take a test";
    exit();
}

$testId = $_GET['id'];
$connection = openCon();

$questions = getQuestions($connection, $testId);

require("index_start.php");
renderTest($questions);
require("index_end.php");

?>
