<?php
include_once "./handlers/DB-handler.php";
include_once "./handlers/helper-functions.php";

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$conn = DBConnect();
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
        <label for="firstname">firstname</label>
        <input type="text" name="firstname" id="firstname">
    </p>
    <p>
        <label for="lastname">lastname</label>
        <input type="text" name="lastname" id="lastname">
    </p>
    <p>
        <label for="address">address</label>
        <input type="text" name="address" id="address">
    </p>
    <p>
        <label for="postcode">Postcode</label>
        <input type="text" name="postcode" id="postcode">
    </p>
    <p>
        <label for="country">Country</label>
        <input type="text" name="country" id="country">
    </p>
    <p>
        <label for="email">email</label>
        <input type="email" name="email" id="email">
    </p>
    <p>
        <label for="website">Website</label>
        <input type="url" name="website" id="website">
    </p>
    <p>
        <input type="submit" value="Create User">
    </p>
</form>

<?php
echo "<h2>user Info</h2><br>";
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

        $does_userExist = DBDoesExistInDB($username, "Username", "user");
        if ($does_userExist) {
            echo "User already exists. Please choose a different username.<br>";
        } else {
            // Create the user in the database
            // start by getting the other fields, sanitize them and put them in an array

            $userInfoArr[] = [
                'Username' => $username,
                'Password' => $password,
                'Firstname' => isset($_POST['firstname']) ? CleanText($_POST['firstname']) : '',
                'Lastname' => isset($_POST['lastname']) ? CleanText($_POST['lastname']) : '',
                'Address' => isset($_POST['address']) ? CleanText($_POST['address']) : '',
                'Postcode' => isset($_POST['postcode']) ? CleanText($_POST['postcode']) : '',
                'Country' => isset($_POST['country']) ? CleanText($_POST['country']) : '',
                'Email' => isset($_POST['email']) ? CleanText($_POST['email']) : '',
                'Website' => isset($_POST['website']) ? CleanText($_POST['website']) : ''
            ];

            $createSuccess = CreateUser($userInfoArr);
            if ($createSuccess) {
                echo "User created successfully!";
            } else {
                echo "Failed to create user.";
            }
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