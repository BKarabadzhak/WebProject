<?php
include "database-initialization.php";

if ($_FILES["file"]["tmp_name"]) {

    createTable();
    $connection = $GLOBALS['connection'];
    $tableName = $GLOBALS['currentTable'];

    $row = 1;
    if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($row != 1) {
                $sql = $connection->prepare("INSERT INTO {$tableName} (question, correct_answer, answer_1, answer_2, answer_3, answer_4)
                VALUES (?, ?, ?, ?, ?, ?)");

                $sql->execute($data);
            }
            $row++;
        }

        fclose($handle);
    }
} else {
    showErrorMessageFileIsNotSet();
}

function showErrorMessageFileIsNotSet()
{
    echo "<p>File isn't set</p>";
}
