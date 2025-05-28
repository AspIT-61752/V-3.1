<?php
session_start();

include_once "./handlers/helper-functions.php";

$firstname = CleanText($_SESSION['newsletter_firstname']) ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Login</title>
</head>
<body class="light">

    <?php 
        include "includes/topmenu.php";

        include "includes/sidemenu.php";
    ?>

    <div class="content">
        <main>
        <h1>Kære <?php echo CleanText($firstname); ?></h1>
        <p>Du er nu tilmeldt vores nyhedsbrev. Vi glæder os til hver måned at bringe dig spændende nyheder fra kunstskøjteløbets verden. Husk, at du altid kan afmelde dig nyhedsbrevet igen ved at følge linket i bunden af nyhedsbrevet. </p>
        <p>Med venlig hilsen dit Edea team</p>
        </main>

        <?php include "includes/footer.php"; ?>
    </div>
        
</body>
</html>