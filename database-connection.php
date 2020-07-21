<?php

function openCon()
{
    $configs = include_once("configs.php");

    $conn = null;
    try {
        $conn = new PDO("mysql:host=$configs->dbhost;dbname=$configs->dbname", $configs->dbuser, $configs->dbpass);
    } catch (PDOException $ex) {
        echo ("Unsuccessful connection to the database.");
        exit();
    }

    return $conn;
}

?>
