<?php
include "database-connection.php";

require("index_start.php");
$connection = openCon();
$GLOBALS['connection'] = $connection;

$tests = getTests();

echo "<div class='table-container'>";

if(count($tests) < 1) {
    echo "<p style='text-align: center;'>There no tests yet.</p>";
} else {
    echo "
    <table>";
    for ($i = 0; $i < count($tests); $i++) {
        renderTestDisplay($tests[$i]);   
    }
    echo "
    </table>
    ";
}
echo "
<div class='back-link'>
<a href=\"index.php\"> <- Back </a>
</div>
</div>
";
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

function renderTestDisplay($test) {
    $testId = $test['id'];
    $testName = $test['name'];

    echo "
    <tr>
        <td>
            $testName
        </td>
        <td>
            <button id='$testId' class=\"but\" onclick='redirectionToTest(this)'>Test</button>
        </td>
        <td>
            <button id='$testId' class=\"but\" onclick='redirectionToReview(this)'>Review</button>
        </td>
        <td>
            <button id='$testId' class=\"but\" onclick='generateXMLfile(this)'>Generate Moodle XML file</button>
        </td>
    </tr>
    ";
}
?>