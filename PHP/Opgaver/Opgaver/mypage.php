<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User page - <?php echo $_SESSION['loggedin_user']; ?></title>
</head>
<body>
    Welcome <?php echo $_SESSION['loggedin_user']; ?>
    <?php

    echo "<p>Du er nu logget ind!</p>";
    echo "<p>Du kan nu se din profil og redigere dine oplysninger.</p>";
    echo "" . $_SESSION['loggedin_user'];
    echo "<p><a href='logout.php'>Log ud</a></p>";
    ?>

    <?php 
    include "includes/footer.php";
    ?>
</body>
</html>