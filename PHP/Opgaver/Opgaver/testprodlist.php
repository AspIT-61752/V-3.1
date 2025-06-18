<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "./handlers/DB-handler.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <?php
    $prods = GetListOfNewProducts();

    // print_r($prods); // Debugging output to see the structure of $prods
    
    for ($i=0; $i < count($prods); $i++) {
        echo "<article>";
        echo "<h3>" . $prods[$i]['PName'] . "</h3>";
        echo "<p>" . $prods[$i]['PDesc'] . "</p>";
        echo "<p>" . $prods[$i]['PStars'] . "</p>";
        echo "<p>" . $prods[$i]['PPrice'] . "</p>";
        if(empty($prods[$i]['PPic'])){
            echo '<p>'. "imagecomingsoon.png" . '</p>';
        }
        else if(strpos($prods[$i]['PPic'], ' ')) {
            $prodImg = explode(' ', $prods[$i]['PPic']);
            foreach ($prodImg as $img) {
                echo '<p><img src="' . substr($img, strlen($img), -3) . '" alt="' . $img . '"></p>';
            }
        }
        echo "<p>" . $prods[$i]['PStock'] . "</p>";
        echo "</article>";
    }
    ?>
</body>
</html>