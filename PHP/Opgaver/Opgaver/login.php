<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "./handlers/helper-functions.php";
include_once "./handlers/DB-handler.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login-submit'])) {
    $username = CleanText($_POST['login-username']);
    $password = CleanText($_POST['login-password']);

    if (DBLogin($username, $password)) {
        $_SESSION['loggedin_user'] = $username;
        header("Location: welcome.php");
        exit();
    }
    else {
        $error = "Forkert brugernavn eller adgangskode.";
    }
    
    // Check if user exists and password matches
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['loggedin_user'] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        $error = "Forkert brugernavn eller adgangskode.";
    }
}

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
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo CleanText($error); ?></p>
        <?php endif; ?>
        <form method="post">
            <p>
                <label for="login-username" class="loginform">Brugernavn: </label>
                <input type="text" name="login-username" placeholder="Brugernavn" class="logininput">
            </p>
            
            <p>
                <label for="login-password" class="loginform">Adgangskode: </label>
                <input type="text" name="login-password" placeholder="Adgangskode" class="logininput">
            </p>
            
            <p>
                <input type="submit" name="login-submit" value="Login" class="submitbtn loginbtn">
            </p>
        </form>
        </main>

        <?php include "includes/footer.php"; ?>
    </div>
        
</body>
</html>