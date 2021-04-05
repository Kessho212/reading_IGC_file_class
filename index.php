<form action="./index.php" method="post">
Link to the .igc file <input type="text" id="link" name = "link">
<button type="submit">submit</button>
</form>
<?php
include "igc.class.php";

if(!empty($_POST)){
    $link = $_POST["link"];
    $test = new IGC_file("$link");
    $test->header();
    echo "<br><br>";
    $test->firstPoint();
    $test->lastPoint();
    echo "<br><br>";
    $test->gpsfix();
}
