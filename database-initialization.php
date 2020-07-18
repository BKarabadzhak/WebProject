<?php

$conn = openCon();
$GLOBALS['conn'] = $conn;
$rand = uniqid();

$sql = $conn->prepare("create table Question{$rand} (question varchar(255), correct_answer varchar(255), answer_1 varchar(255), answer_2 varchar(255), answer_3 varchar(255), answer_4 varchar(255))");

if (!$sql->execute($data)) {
    echo 'Failed sql request';
} else {
    echo 'Successful sql request';
}
