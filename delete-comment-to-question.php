<?php 
include_once "database-connection.php";

$jsonData = file_get_contents('php://input');
$dataClassObject = json_decode($jsonData);
$associativeArray = json_decode(json_encode($dataClassObject), TRUE);

$commentId = $associativeArray['commentId'];

$connection = openCon();

$sql = $connection->prepare("DELETE FROM questions_comments WHERE id = " . $commentId . ";");

if (!$sql->execute()) {
    throw "Error " . $sql->errorInfo();
};

?>