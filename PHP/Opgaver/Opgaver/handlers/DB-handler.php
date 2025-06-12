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
    foreach ($res as $row) {
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
        'Postcode' => CleanDBText($userarr[0]['Postcode']),
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
    $prepStatement->bind_param($types, array_values($userParams));
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

// Delete this later
function TestDB($conn) {
    $sql = "SELECT * FROM `users`;";

    $res = $conn->query($sql);
    foreach ($res as $x => $row) {
        echo "<br>Row $x: " . $row['ID'] . " - " . $row['Username'] . " - " . $row['Password'] . "<br>";
    }
}

?>