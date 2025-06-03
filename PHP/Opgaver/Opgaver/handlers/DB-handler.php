<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// https://www.php.net/manual/en/class.mysqli.php





function DBConnect() {
    // Get data from a .env file in the root directory (/Opgaver/)
    // Get the data from the file
    $env = parse_ini_file(__DIR__ . '/../.env', false, INI_SCANNER_RAW);
    
    $hostname = trim($env['DB_HOST'] ?? '');
    $username = trim($env['DB_USER'] ?? '');
    $password = trim($env['DB_PASS'] ?? '');
    $database = trim($env['DB_NAME'] ??'');

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

function TestDB($conn) {
    $sql = "SELECT * FROM `users`;";

    $res = $conn->query($sql);
    foreach ($res as $x => $row) {
        echo "<br>Row $x: " . $row['ID'] . " - " . $row['Username'] . " - " . $row['Password'] . "<br>";
    }
}

?>