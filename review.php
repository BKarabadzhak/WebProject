<?php
include_once("classes/Question.php");
include_once("classes/TestAnswer.php");
include_once("classes/Comment.php");
require_once "database-connection.php";
include_once("./tests/tests-helper.php");
include_once("./tests/testsReview-helper.php");

if (!isset($_GET['id'])) {
    echo "First select the test you want to take.<br>";
    echo "<a href=\"dashboard.php\"> Take a test </a>";
    exit();
}

$testId = $_GET['id'];
$connection = openCon();
$GLOBALS['connection'] = $connection;

$questions = getQuestions($connection, $testId);

require("index_start.php");
renderTestReview($questions, $testId, $connection);
require("index_end.php");

?>
