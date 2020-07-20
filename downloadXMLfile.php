<?php
if (!isset($_GET['id'])) {
    echo "File id not specified.<br>";
    echo "<a href=\"dashboard.php\"> Select the test you want to download. </a>";
    exit();
}

$testId = $_GET['id'];
$fileName = "./XMLFiles/file" . $testId . ".xml";

if (!file_exists($fileName)) {
    die('File not found');
} else {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileName));
    readfile($fileName);
}
?>