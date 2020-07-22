<?php 
include_once "database-connection.php";

$jsonData = file_get_contents('php://input');
$dataClassObject = json_decode($jsonData);
$associativeArray = json_decode(json_encode($dataClassObject), TRUE);

if ($associativeArray) {
    $connection = openCon();
    
    $commentName = $associativeArray['commentName'];
    $comment = $associativeArray['comment'];
    $answerId = $associativeArray['answerId'];

    $sql = $connection->prepare("INSERT INTO answers_comments (comment_name, comment, answer_id) VALUES (?, ?, ?)");

    if (!$sql->execute(array($commentName, $comment, $answerId))) {
        throw "Error " . $sql->errorInfo();
    };

    echo $connection->lastInsertId();
}

?>