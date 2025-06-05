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

include_once "./handlers/DB-handler.php";
include_once "./handlers/helper-functions.php";

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

?>

<?php
$conn = DBConnect();
TestDB($conn);
DBClose($conn);
?>


<form action="" method="post">
    <p>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
    </p>
    <p>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </p>
    <p>
        <input type="submit" value="Login">
    </p>
</form>

<?php
echo "<h2>Login Info</h2><br>";
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Get and sanitize the username and password from the form
    $username = CleanText($_POST['username']);
    $password = CleanText($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Username and password cannot be empty.<br><br>";
    } else {
        // Validate the credentials by comparing the provided username and password with the database
        echo "Username: $username<br>";
        echo "Password: $password<br><br>";

        // Connect to the database
        $userdata = DBSelect($username, 'Username');
        if ($userdata && count($userdata) > 0) {
            // Will display everything in case of multiple users with the same username, don't know if upper and lower case matters, so just in case
            foreach ($userdata as $row) {
                echo sprintf("<br>DATA IN DB:<br>ID: %s, Username: %s, Password: %s<br><br>", $row['ID'], $row['Username'], $row['Password']);
            }
        } else {
            echo "No user data found.<br>";
        }

        $loginSuccess = DBLogin($username, $password);
        if ($loginSuccess) {
            echo "Login successful!";
            $_SESSION['loggedin_user'] = $username; // Store username in session
        } else {
            echo "<br>Login failed. Invalid username or password.";
        }
    }
}
?>