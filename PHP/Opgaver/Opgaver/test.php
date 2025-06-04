<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
echo "<h2>Login Info</H2><br>";
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = CleanText($_POST['username']);
    $password = CleanText($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Username and password cannot be empty.<br><br>";
    } else {
        // Here you would typically check the credentials against a database
        echo "Username: $username<br>";
        echo "Password: $password<br><br>";

        $userdata = DBSelect($username, 'username');
        if ($userdata) {
            echo "User data found:<br>";
            foreach ($userdata as $user) {
                echo "<br>DATA IN DB:<BR>ID: " . $user['ID'] . ", Username: " . $user['Username'] . ", Password" . $user['Password'] .  "<br><br>";
            }

            $loginSuccess = DBLogin($username, $password);
            if ($loginSuccess) {
                echo "Login successful!";
                $_SESSION['loggedin_user'] = $username; // Store username in session
            } else {
                echo "<br>Login failed. Please check your credentials.";
            }
            
        } else {
            echo "No user found with the username '$username'.";
        }
    }
}