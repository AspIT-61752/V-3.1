<?php
session_start();

include_once "./handlers/helper-functions.php";

// Redirect if not logged in
if (!isset($_SESSION['loggedin_user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['loggedin_user'];
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Velkommen</title>
</head>
<body class="light">
    <?php 
        include "includes/topmenu.php";
        include "includes/sidemenu.php";
    ?>

    <div class="content">
        <main>
            <h1>Logget ind som: <?php echo CleanText($username); ?></h1>
        </main>
    </div>
</body>
</html>