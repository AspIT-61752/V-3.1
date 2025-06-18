<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// https://www.php.net/manual/en/class.mysqli.php

function DBConnect() {
    // Get data from a .env file in the root directory (/Opgaver/)
    // Get the data from the file
    $env = parse_ini_file(__DIR__ . '/../.env', false, INI_SCANNER_RAW);
    
    // Prepare the connection parameters
    $hostname = trim($env['DB_HOST'] ?? '');
    $username = trim($env['DB_USER'] ?? '');
    $password = trim($env['DB_PASS'] ?? '');
    $database = trim($env['DB_NAME'] ??'');

    // Check if any of the parameters are empty
    if (empty($hostname) || empty($username) || empty($password) || empty($database)) {
        echo "Database connection parameters are not set correctly.";
        return null;
    }
    
    // Make the connection
    $conn = new mysqli($hostname, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        return null;
    }
    else {
        echo "Connected successfully";
        return $conn;
    }
}

function DBClose($conn) {
    if ($conn) {
        mysqli_close($conn);
        echo "Connection closed successfully";
    } else {
        echo "No connection to close";
    }
}

function CleanDBText($text) {
    // Basic cleaning: trim and escape HTML special characters
    return trim(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
}

function DBSelect($Search, $ColName) {
    // Whitelist allowed columns
    $allowedColumns = ['ID', 'Username', 'Email']; // Names of the columns in the users table, could probably make a more generic solution for this. 

    // Check if the provided column name is in the allowed list
    if (!in_array($ColName, $allowedColumns)) {
        return null; // Invalid column name
    }

    // Connect to the database
    $conn = DBConnect();
    if (!$conn) {
        return null;
    }

    // Prepare the statement
    $cleanSearch = CleanDBText($Search);
    $sql = "SELECT * FROM `users` WHERE `$ColName` = ?;";
    $prepStatement = $conn->prepare($sql);
    if (!$prepStatement) {
        echo "Prepare failed: " . $conn->error;
        DBClose($conn);
        return null;
    }

    // Bind the parameter and execute the statement
    $prepStatement->bind_param("s", $cleanSearch); // Should always be a string
    $prepStatement->execute();
    $res = $prepStatement->get_result();
    $data = [];
    // In case of multiple users with the same username, this will return all of them
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    // Close the statement and connection
    $prepStatement->close();
    DBClose($conn);
    return $data;
}

function DBAdvSearch($variable, $ColName, $table)
{
    $conn = DBConnect();
    if (!$conn) {
        return false;
    }

    // Sanitize inputs
    $allowedTables = ['user', 'users'];
    $cleanVariable = CleanDBText($variable);
    $cleanColName = CleanDBText($ColName);
    $cleanTable = CleanDBText($table);

    if (!in_array($cleanTable, $allowedTables)) {
        return null; // Invalid table name
    }

    // Prepare the SQL query
    $sql = "SELECT * FROM `$cleanTable` WHERE `$cleanColName` = ?;";
    $prepStatement = $conn->prepare($sql);
    if (!$prepStatement) {
        echo "Prepare failed: " . $conn->error;
        DBClose($conn);
        return false;
    }
    $prepStatement->bind_param("s", $cleanVariable);
    $prepStatement->execute();

    // Get data from the result
    $res = $prepStatement->get_result();
    $data = [];
    foreach ($res as $row) {
        $data[] = $row;
    }

    // Clean up
    $prepStatement->close();
    DBClose($conn);
    return $data;
}

function DBDoesExistInDB($var, $colname, $table) {
    $conn = DBConnect();
    if (!$conn) {
        return false;
    }

    // Get the data from the DB
    $res = DBAdvSearch($var, $colname, $table);
    if ($res === false) {
        echo "Error: " . $conn->error;
        DBClose($conn);
        return false;
    }
    
    // check if the result is empty
    if (empty($res)) {
        DBClose($conn);
        return false; // Does not exist
    } else {
        DBClose($conn);
        return true; // Exists
    }

}

function GetUserID($Username) {
    $conn = DBConnect();
    if (!$conn) {
        return false;
    }

    // Get the user ID
    $sql = "SELECT `ID` FROM `user` WHERE `Username` = ?;";

    // Prepare the statement
    $prepStatement = $conn->prepare($sql);
    $cleanUsername = CleanDBText($Username);
    $prepStatement->bind_param("s", $cleanUsername);

    // Execute the statement
    $prepStatement->execute();
    $res = $prepStatement->get_result();

    // Handle the result
    $userID = null;
    if ($row = $res->fetch_assoc()) {
        $userID = $row['ID'];
    }

    // Clean up and return data
    $prepStatement->close();
    DBClose($conn);

    return $userID;
}

function DeleteUser($Username) {
    $conn = DBConnect();
    if (!$conn) {
        return false;
    }

    // Get the user ID
    $userID = GetUserID($Username);
    if ($userID === false || $userID === null) {
        echo "User not found or error retrieving user ID.";
        DBClose($conn);
        return false;
    }

    // Prepare the statement
    $sql = "DELETE FROM `users` WHERE `ID` = ?;";

    // Prepare
    $prepStatement = $conn->prepare($sql);
    $prepStatement->bind_param("i", $userID);
    $prepStatement->execute();

    // Get data
    $res = $prepStatement->get_result();

    // Check if the user was deleted
    if ($prepStatement->affected_rows > 0) {
        echo "User deleted successfully.";
        $prepStatement->close();
        DBClose($conn);
        return true;
    } else {
        echo "Error deleting user: " . $conn->error . "<br>" . "Affected rows: " . $prepStatement->affected_rows . "<br>" . "PrepError: " . $prepStatement->error; 
        $prepStatement->close();
        DBClose($conn);
        return false;
    }
}

function CreateUser($userarr) {
    // Fix it later
    $conn = DBConnect();
    if (!$conn) {
        return false;
    }

    echo "<br>Creating user with the following data:<br>";
    foreach ($userarr[0] as $key => $value) {
        echo "[$key] => $value<br>";
    }
    // Count
    echo "Count: " . count($userarr[0]) . "<br>";
    
    // User array in the correct order
    if (!is_array($userarr[0]) && count($userarr[0]) == 9) {
        echo "Invalid user data provided.";
        // Show the is array and count
        echo  "<br><br>" . "Is array: " . (is_array($userarr[0]) ? 'true' : 'false') . "<br>";
        // show the entire array
        echo "Array: <pre>" . print_r($userarr[0], true) . "</pre>";
        DBClose($conn);
        return false;
    }
    
    $userParams = [
        'Username' => CleanDBText($userarr[0]['Username']),
        'Password' => CleanDBText($userarr[0]['Password']),
        'Firstname' => CleanDBText($userarr[0]['Firstname']),
        'Lastname' => CleanDBText($userarr[0]['Lastname']),
        'Address' => CleanDBText($userarr[0]['Address']),
        'Postcode' => (int)CleanDBText($userarr[0]['Postcode']), // ensure integer
        'Country' => CleanDBText($userarr[0]['Country']),
        'Email' => CleanDBText($userarr[0]['Email']),
        'Website' => CleanDBText($userarr[0]['Website'])
    ];
    
    $sql = "INSERT INTO `user` (`ID`, `Username`, `Password`, `Firstname`, `Lastname`, `Address`, `Postcode`, `Country`, `Email`, `Website`) VALUES (NULL, ?, PASSWORD(?), ?, ?, ?, ?, ?, ?, ?);";
    $prepStatement = $conn->prepare($sql);
    if (!$prepStatement) {
        echo "Prepare failed: " . $conn->error;
        DBClose($conn);
        return false;
    }

    $types = "sssssisss";
    $params = array_values($userParams); // Unpack the associative array 🤢 into a numeric array 😁 (The trouble this has cause me)
    $prepStatement->bind_param(
        $types,
        $params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6], $params[7], $params[8]
    );
    $prepStatement->execute();

    if ($prepStatement->affected_rows > 0) {
        echo "User created successfully.";
        $prepStatement->close();
        DBClose($conn);
        return true;
    } else {
        echo "Error creating user: " . $conn->error . "<br>" . "Affected rows: " . $prepStatement->affected_rows . "<br>" . "PrepError: " . $prepStatement->error; 
        $prepStatement->close();
        DBClose($conn);
        return false;
    }
}

// TODO: Make this more secure, use prepared statements
// TODO: Add comments
function DBLogin($Username, $password) {
    $conn = DBConnect();
    if (!$conn) {
        return false;
    }

    $sql = "SELECT * FROM `user` WHERE `Username` = '$Username' AND `Password` = PASSWORD('$password');";
    echo "<br><br>SQL Query: $sql<br><br>";
    $res = $conn->query($sql);
    
    if ($res === false) {
        echo "Error: " . $conn->error;
        DBClose($conn);
        return false;
    }

    if ($res->num_rows > 0) {
        DBClose($conn);
        return true; // Login successful
    } else {
        DBClose($conn);
        return false; // Login failed
    }
}

function GetListOfNewProducts(bool $IsAscendingOrder = false, int $amount = 3) {
    $conn = DBConnect();
    if (!$conn) {
        return [];
    }

    // A quick if statement to set the order direction
    $order = $IsAscendingOrder ? 'ASC' : 'DESC';

    // Adjust table and column names as needed
    $sql = "SELECT * FROM `products` ORDER BY `PID` $order LIMIT $amount;";

    $res = $conn->query($sql);
    if ($res === false) {
        echo "Error executing query: " . $conn->error;
        DBClose($conn);
        return [];
    }
    
    // This should return an associative array of products of the specified amount
    $data = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
    }

    DBClose($conn);
    return $data;
}

// Associative array with the key(s) being the column names and the values being the new values
function UpdateUserInfo($AsoInfo) {
    $conn = DBConnect();
    if (!$conn) {
        return false;
    }

    $sql = "UPDATE `users` SET ";
    $params = [];
    $types = '';
    foreach ($AsoInfo as $key => $value) {

        // Check all the possible keys, add them to the SQL query and the parameters array
        if (in_array($key, ['Username', 'Password', 'Firstname', 'Lastname', 'Address', 'Postcode', 'Country', 'Email', 'Website'])) {
            
            // Check if the value is not null or empty
            if ($value !== null && $value !== '') {
                if ($key == 'Password') {
                    // Hash the pass
                    $sql .= "`$key` = PASSWORD(?), ";
                }
                else {
                    $sql .= "`$key` = ?, ";
                }
    
                $params[] = CleanDBText($value);
                
                if ($value == 'Postcode') {
                    $types .= 'i';
                }
                else {
                    $types .= 's';
                }
            }
        }
    }

    // Remove the last comma and space from the query to avoid syntax errors
    $sql = rtrim($sql, ', ') . " WHERE `ID` = ?;";
    
    // Get the user ID, probably have to check if the user is logged in by getting it from the session and then getting the ID from the DB 🤔 Do it later 
    
    if (!isset($_SESSION['loggedin_user'])) {
        echo "No user logged in.";
        DBClose($conn);
        return false;
    }
    
    $userID = GetUserID(Username: $_SESSION['loggedin_user']);
    if ($userID === false || $userID === null) {
        echo "User not found.";
        DBClose($conn);
        return false;
    }

    // Add it to the params
    $params[] = $userID;
    $types .= 'i'; // The User ID is an integer

    // Prepare and execute
    $prepStatement = $conn->prepare($sql);
    if (!$prepStatement) {
        echo "Prepare failed: " . $conn->error;
        DBClose($conn);
        return false;
    }

    $prepStatement->bind_param($types, ...$params);
    
    if ($prepStatement->execute()) {
        echo "User information updated";
        DBClose($conn);
        return true;
    } else {
        echo "Error updating user information: " . $prepStatement->error;
        DBClose($conn);
        return false;
    }
}

?>