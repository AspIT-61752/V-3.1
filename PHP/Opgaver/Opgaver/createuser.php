<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newuser-submit'])) {
    $username = trim($_POST['newuser-username']);
    $password = trim($_POST['newuser-password']);
    $passwordRepeat = trim($_POST['newuser-passwordrepeat']);
    $firstname = trim($_POST['newuser-firstname']);
    $lastname = trim($_POST['newuser-lastname']);
    $address = trim($_POST['newuser-address']);
    $postcode = trim($_POST['newuser-postcode']);
    $country = trim(strtolower($_POST['newuser-country'])); // convert to lowercase to match 'danmark' or 'denmark'
    $email = trim($_POST['newuser-email']);
    $website = trim($_POST['newuser-website']);

    $errors = [];

    // Check if country is Denmark and postcode is not 4 digits
    if ($country === "danmark" || $country === "denmark") {
        if (!preg_match('/^\d{4}$/', $postcode)) {
            $errors[] = "Danske brugere skal have et fire-cifret postnummer.";
        }
    }

    // Example: check passwords match
    if ($password !== $passwordRepeat) {
        $errors[] = "Adgangskoderne matcher ikke.";
    }

    // Show errors or proceed
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        // Success – you can save to DB or session here
        echo "<p style='color:green;'>Bruger oprettet!</p>";
        // Save logic goes here
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Newsletter</title>
</head>
<body class="light">

    <?php 
        include "includes/topmenu.php";

        include "includes/sidemenu.php";
    ?>

    <div class="content">
        <main>
            <h1>Opret bruger</h1>
            <?php if (!empty($errors)): ?>
                <div style="color:red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php elseif (!empty($successMessage)): ?>
                <div style="color:green;">
                    <p><?php echo htmlspecialchars($successMessage); ?></p>
                </div>
            <?php endif; ?>
        <form method="post">
            <p>
                <label for="newuser-username">Brugernavn: </label>
                <input type="text" name="newuser-username" placeholder="Brugernavn" class="logininput">
            </p>
            
            <p>
                <label for="newuser-password">Adgangskode: </label>
                <input type="text" name="newuser-password" placeholder="Adgangskode" class="logininput">
            </p>

            <p>
                <label for="newuser-passwordrepeat">Gentag adgangskode: </label>
                <input type="text" name="newuser-passwordrepeat" placeholder="Gentag adgangskode" class="logininput">
            </p>

            <p>
                <label for="newuser-firstname">Fornavn: </label>
                <input type="text" name="newuser-firstname" placeholder="Fornavn" class="logininput">
            </p>
            
            <p>
                <label for="newuser-lastname">Efternavn: </label>
                <input type="text" name="newuser-lastname" placeholder="Efternavn" class="logininput">
            </p>

            <p>
                <label for="newuser-address">Adresse: </label>
                <input type="text" name="newuser-address" placeholder="Gade og nr." class="logininput">
            </p>

            <p>
                <label for="newuser-postcode">Postnummer: </label>
                <input type="text" name="newuser-postcode" placeholder="Postnummer" class="logininput">
            </p>
            
            <p>
                <label for="newuser-city">By: </label>
                <input type="text" name="newuser-city" placeholder="By" disabled class="logininput">
            </p>

            <p>
                <label for="newuser-country">Land: </label>
                <input type="text" name="newuser-country" placeholder="Land" class="logininput">
            </p>
            
            <p>
                <label for="newuser-email">E-mail: </label>
                <input type="text" name="newuser-email" placeholder="E-mail adresse" class="logininput">
            </p>
            
            <p>
                <label for="newuser-website">Website: </label>
                <input type="text" name="newuser-website" placeholder="Indtast URL på din hjemmeside" class="logininput">
            </p>
            
            <p>
                <input type="submit" name="newuser-submit" value="Opret" class="submitbtn">
            </p>
        </form>

        </main>

        <?php include "includes/footer.php"; ?>
    </div>
        
</body>
</html>