<?php
include_once "database-connection.php";

$jsonData = file_get_contents('php://input');
$dataClassObject = json_decode($jsonData);
$associativeArray = json_decode(json_encode($dataClassObject), TRUE);

if ($associativeArray) {
    $connection = openCon();

    $commentName = $associativeArray['commentName'];
    $comment = $associativeArray['comment'];
    $questionId = $associativeArray['questionId'];

    $sql = $connection->prepare("INSERT INTO questions_comments (comment_name, comment, question_id) VALUES (?, ?, ?)");

    if (!$sql->execute(array($commentName, $comment, $questionId))) {
        throw "Error " . $sql->errorInfo();
    };

    echo $connection->lastInsertId();
}

?>