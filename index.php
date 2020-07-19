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
    <input type="submit" value="Read file" />
</form>
<a href="test.php"> Take a test </a>

<?php
require("index_end.php");
?>
