<?php
require("index_start.php");
?>

<form
    method="POST"
    name="form"
    action="./controller.php"
    enctype="multipart/form-data"
>
    <label for="file">File</label>
    <input
        type="file"
        id="file"
        name="file"
        accept=".csv"
    />
    <br />
    <label for="testName">Set name of the test:</label>
    <input
        type="text"
        id="testName"
        name="testName"
    />
    <br />
    <input type="submit" value="Read file" />
</form>
<a href="dashboard.php"> Take a test </a>

<?php
require("index_end.php");
?>
