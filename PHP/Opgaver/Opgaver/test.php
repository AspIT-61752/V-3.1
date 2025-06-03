<?php
include_once "./handlers/DB-handler.php";
?>

<?php
$conn = DBConnect();
TestDB($conn);
DBClose($conn);
?>