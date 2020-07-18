<?php

function openCon()
{
    try {
        $dbhost = "localhost:3306";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "web_project";

        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $ex) {
        echo ("Unsuccessful connection to the database.");
        exit();
    }

    return $conn;
}

?>