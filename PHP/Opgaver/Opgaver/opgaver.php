<!-- https://tobi61752.aspitcloud.dk/V31/opgaver.php -->

<?php
// Opg 5
function NameInClass($find){
    $find = strtolower($find);
    $arr = array("thomas", "kenneth", "mads", "simon");
    for ($i=0; $i < count($arr); $i++) { 
        if ($arr[$i] == $find) {
            return $i;
        }
    }
    return -1;
}

function NameInClassArr($find) {
    $find = strtolower($find);
    $arr = array("thomas", "kenneth", "mads", "simon");
    $index = array_search($find, $arr);
    return $index !== false ? $index : -1;
}

function populateArrayWMonths() {
    $months = [];
    $dt = new DateTime();
    $dt->setDate(2025, 1, 1);

    for ($i = 0; $i < 12; $i++) {
        $monthName = $dt->format('F');
        $daysInMonth = $dt->format('t');
        $months[$monthName] = (int)$daysInMonth;
        $dt->modify('+1 month');
    }

    return $months;
}

?>

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

    <?php
    echo '<br>';
    $toFind = "kenneth";
    $index = NameInClass($toFind);
    $toFindCap = ucfirst(strtolower($toFind));
    if ($index != -1) {
        echo "$toFindCap is in the class at index $index";
    } else {
        echo "$toFindCap is not in the class";
    }
    ?>

    <?php
    echo '<br>';
    $toFind = "thomas";
    $index = NameInClassArr($toFind);
    $toFindCap = ucfirst(strtolower($toFind));
    if ($index != -1) {
        echo "$toFindCap is in the class at index $index";
    } else {
        echo "$toFindCap is not in the class";
    }
    ?>
    
    <?php
    // Get months and their days
    $months = populateArrayWMonths();

    $shortMonths = [];
    $longMonths = [];

    foreach ($months as $month => $days) {
        if ($days <= 30) {
            $shortMonths[$month] = $days;
        } elseif ($days == 31) {
            $longMonths[$month] = $days;
        }
    }
    ?>

    <h3>Short Months (30 days or less):</h3>
    <ul>
        <?php foreach ($shortMonths as $month => $days): ?>
            <li><?php echo htmlspecialchars($month); ?>: <?php echo $days; ?> days</li>
        <?php endforeach; ?>
    </ul>

    <h3>Long Months (31 days):</h3>
    <ul>
        <?php foreach ($longMonths as $month => $days): ?>
            <li><?php echo htmlspecialchars($month); ?>: <?php echo $days; ?> days</li>
        <?php endforeach; ?>
    </ul>
    
</body>
</html>
