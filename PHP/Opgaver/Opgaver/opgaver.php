<!-- https://tobi61752.aspitcloud.dk/V31/opgaver.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>opgaver</title>
</head>
<body>
    <?php
    $string = "the quick brown fox jumped over the lazy dog";
    echo '<h2>'.$string.'</h2>'
    ?>

    <?php
    $string = "The quick brown fox jumps over the lazy dog.";
    $word = "fox";

    if (strpos($string, $word) !== false) {
        echo "The word '$word' exists in the string \"$string\".";
    } else {
        echo "The word '$word' does not exist in the string \"$string\".";
    }
    ?>

    

    <?php
    $email = "halu@aspit.dk";
    $username = strstr($email, '@', true);

    echo '<br>';
    echo "The username is: $username";
    ?>

    <?php
    function genPassword($len, $charlist) {
        $res = '';
        $lenLetters = strlen($charlist);

        for ($i=0; $i < $len; $i++) { 
            $ran = rand(0, $lenLetters - 1);
            $res .= $charlist[$ran];
        }

        return $res;
    }

    $charlist = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = genPassword(10, $charlist);

    echo '<br>';
    echo "The generated password is: $password";
    
    ?>

    <?php
    function IsPalindrome($word) {
        $word = strtolower($word);
        // $word = preg_replace('/[^a-z0-9]/', '', $word);
        $reversedWord = strrev($word);

        if ($word === $reversedWord) {
            return true;
        } else {
            return false;
        }
    }

    $word = "racecar";
    $word = "Kenneth";
    $awnser = IsPalindrome($word) ? "Yes" : "No";
    
    echo '<br>';
    echo "Is $word a palindrome: $awnser";
    ?>
    
    
</body>
</html>
