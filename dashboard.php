<?php
include "database-connection.php";

require("index_start.php");

$connection = openCon();
$GLOBALS['connection'] = $connection;

$tests = getTests();

for ($i = 0; $i < count($tests); $i++) {
    renderTest($tests[$i]);
}


require("index_end.php");

function getTests()
{
    $tests = array();

    $connection = $GLOBALS['connection'];
    $sql = $connection->prepare("SELECT * FROM tests;");
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        array_push($tests, $row);
    }

    return $tests;
}

function renderTest($test) {
    $testId = $test['id'];
    $testName = $test['name'];

    echo "<p>$testName";
    echo "<button id='$testId' class=\"but\" onclick='redirectionToTest(this)'>Test</button>";
    echo "<button id='$testId' class=\"but\" onclick='redirectionToReview(this)'>Review</button>";
    echo "</p>";
}
?>