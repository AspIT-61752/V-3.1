<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SERVER['ENV'] = 'development'; // Set the environment variable to 'development' for testing purposes. Figure out how to set this in the .env file later.
if ($_SERVER['ENV'] === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include Testing handlers/libraries here
}
?>

<!-- <?php
include "./components/login-form.php";
?> -->

<?php
include "./components/createuser.php";
?>