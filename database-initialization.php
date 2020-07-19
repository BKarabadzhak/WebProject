<?php
include "database-connection.php";

function createTable()
{
    $connection = openCon();
    $GLOBALS['connection'] = $connection;
    $rand = uniqid();
    $GLOBALS['currentTable'] = "question{$rand}";

    $sql = $connection->prepare("create table question{$rand} (question varchar(255), correct_answer varchar(255), answer_1 varchar(255), answer_2 varchar(255), answer_3 varchar(255), answer_4 varchar(255))");

    if (!$sql->execute()) {
        echo 'Failed sql request<br>';
    } else {
        echo 'Successful sql request<br>';
    }
}
