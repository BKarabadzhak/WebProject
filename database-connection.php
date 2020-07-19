<?php

function openCon()
{
    $conn = null;
    try {
        $dbhost = "localhost:3306";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "web-project";

        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $ex) {
        echo ("Unsuccessful connection to the database.");
        exit();
    }

    return $conn;
}

?>