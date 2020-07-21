<?php
require("index_start.php");
?>
<div class="form-container">
    <form
        method="POST"
        name="form"
        action="./controller.php"
        enctype="multipart/form-data"
    >
        <label for="testName" class="col">Set a name for the test:</label>
        <input
            type="text"
            id="testName"
            name="testName"
            value=""
            class="col"
        />
        <label for="file" class="col">Choose CSV File:</label>
        <input
            type="file"
            id="file"
            name="file"
            accept=".csv"
            class="col"
        />
        <input type="submit" value="Read file" />
    </form>
    <div class="back-link">
        <a href="index.php"> <- Back</a>
    </div>
</div>

<?php
require("index_end.php");
?>