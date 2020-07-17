<?php

if ($_FILES["file"]["tmp_name"]) {

    $row = 1;
    if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            echo "<p> $num полей в строке $row: <br /></p>\n";
            $row++;
            for ($c = 0; $c < $num; $c++) {
                echo $data[$c] . "<br />\n";
            }
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
?>