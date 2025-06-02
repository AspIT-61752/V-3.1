<?php
session_start();

include_once "./handlers/helper-functions.php";

$usernameErr = $passwordErr = $passwordRepeatErr = $firstnameErr = $lastnameErr = $addressErr = $postcodeErr = $countryErr = $emailErr = $websiteErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newuser-submit'])) {

    $errors = [];

    if (empty($_POST['newuser-username'])) {
        $usernameErr = "Brugernavn er påkrævet.";
        $errors[] = $usernameErr;
    }
    else {
        $username = CleanText($_POST['newuser-username']);
    }

    if (empty($_POST['newuser-password'])) {
        $passwordErr = "Adgangskode er påkrævet.";
        $errors[] = $passwordErr;
    } else {
        $password = CleanText($_POST['newuser-password']);
    }

    if (empty($_POST['newuser-passwordrepeat'])) {
        $passwordRepeatErr = "Gentag adgangskode er påkrævet. ";
        $errors[] = $passwordRepeatErr;
    }
    if ($password !== $passwordRepeat) {
        $passwordRepeatErr += "Adgangskoderne matcher ikke.";
        $errors[] = $passwordRepeatErr;
    } 
    else {
        $passwordRepeat = CleanText($_POST['newuser-passwordrepeat']);
    }

    if (empty($_POST['newuser-firstname'])) {
        $firstnameErr = "Fornavn er påkrævet.";
        $errors[] = $firstnameErr;
    } else {
        $firstname = CleanText($_POST['newuser-firstname']);
    }

    if (empty($_POST['newuser-lastname'])) {
        $lastnameErr = "Efternavn er påkrævet.";
        $errors[] = $lastnameErr;
    } else {
        $lastname = CleanText($_POST['newuser-lastname']);
    }

    if (empty($_POST['newuser-address'])) {
        $addressErr = "Adresse er påkrævet.";
        $errors[] = $addressErr;
    } else {
        $address = CleanText($_POST['newuser-address']);
    }

    if (empty($_POST['newuser-postcode'])) {
        $postcodeErr = "Postnummer er påkrævet.";
        $errors[] = $postcodeErr;
    } else {
        $postcode = CleanText($_POST['newuser-postcode']);
    }

    if (empty($_POST['newuser-country'])) {
        $countryErr = "Land er påkrævet.";
        $errors[] = $countryErr;
    } else {
        $country = CleanText(strtolower($_POST['newuser-country'])); // convert to lowercase to match 'danmark' or 'denmark'
    }

    if (empty($_POST['newuser-email'])) {
        $emailErr = "E-mail adresse er påkrævet.";
        $errors[] = $emailErr;
    } else {
        $email = CleanText($_POST['newuser-email']);
    }

    $website = CleanText($_POST['newuser-website']);

    // If all fields are filled, proceed with further validation
    if (empty($usernameErr) && empty($passwordErr) && empty($passwordRepeatErr) && 
        empty($firstnameErr) && empty($lastnameErr) && empty($addressErr) && 
        empty($postcodeErr) && empty($countryErr) && empty($emailErr) && 
        empty($websiteErr)) {
        
        // Here you can add further validation, e.g., checking if the username already exists
        // or if the email is valid, etc.
        
        // For now, let's assume everything is valid and proceed to create the user
        $_SESSION['loggedin_user'] = [
            'username' => $username,
            'password' => $password,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'address' => $address,
            'postcode' => $postcode,
            'country' => $country,
            'email' => $email,
            'website' => $website
        ];
        
        // Redirect or show success message
        header("Location: welcome.php");
        exit();
    }
    
    $username = CleanText($_POST['newuser-username']);
    $password = CleanText($_POST['newuser-password']);
    $passwordRepeat = CleanText($_POST['newuser-passwordrepeat']);
    $firstname = CleanText($_POST['newuser-firstname']);
    $lastname = CleanText($_POST['newuser-lastname']);
    $address = CleanText($_POST['newuser-address']);
    $postcode = CleanText($_POST['newuser-postcode']);
    $country = CleanText(strtolower($_POST['newuser-country'])); // convert to lowercase to match 'danmark' or 'denmark'
    $email = CleanText($_POST['newuser-email']);
    $website = CleanText($_POST['newuser-website']);

    // Check if country is Denmark and postcode is not 4 digits
    if ($country === "danmark" || $country === "denmark") {
        if (!preg_match('/^\d{4}$/', $postcode)) {
            $errors[] = "Danske brugere skal have et fire-cifret postnummer.";
        }
    }

    // Example: check passwords match
    if ($password !== $passwordRepeat) {
        // $errors[] = "Adgangskoderne matcher ikke.";
    }

    // Show errors or proceed
    if (!empty($errors)) {
        // foreach ($errors as $error) {
        //     echo "<p style='color:red;'>$error</p>";
        // }
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
            <!-- <?php if (!empty($errors)): ?>
                <div style="color:red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo CleanText($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php elseif (!empty($successMessage)): ?>
                <div style="color:green;">
                    <p><?php echo CleanText($successMessage); ?></p>
                </div>
            <?php endif; ?> -->
        <form method="post">
            <p>
                <label for="newuser-username">Brugernavn: </label>
                <input type="text" name="newuser-username" placeholder="Brugernavn" class="logininput">
                <?php if (!empty($usernameErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($usernameErr); ?></span>
                <?php endif; ?>
            </p>
            
            <p>
                <label for="newuser-password">Adgangskode: </label>
                <input type="text" name="newuser-password" placeholder="Adgangskode" class="logininput">
                <?php if (!empty($passwordErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($passwordErr); ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="newuser-passwordrepeat">Gentag adgangskode: </label>
                <input type="text" name="newuser-passwordrepeat" placeholder="Gentag adgangskode" class="logininput">
                <?php if (!empty($passwordRepeatErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($passwordRepeatErr); ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="newuser-firstname">Fornavn: </label>
                <input type="text" name="newuser-firstname" placeholder="Fornavn" class="logininput">
                <?php if (!empty($firstnameErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($firstnameErr); ?></span>
                <?php endif; ?>
            </p>
            
            <p>
                <label for="newuser-lastname">Efternavn: </label>
                <input type="text" name="newuser-lastname" placeholder="Efternavn" class="logininput">
                <?php if (!empty($lastnameErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($lastnameErr); ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="newuser-address">Adresse: </label>
                <input type="text" name="newuser-address" placeholder="Gade og nr." class="logininput">
                <?php if (!empty($addressErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($addressErr); ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="newuser-postcode">Postnummer: </label>
                <input type="text" name="newuser-postcode" placeholder="Postnummer" class="logininput">
                <?php if (!empty($postcodeErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($postcodeErr); ?></span>
                <?php endif; ?>
            </p>
            
            <p>
                <label for="newuser-city">By: </label>
                <input type="text" name="newuser-city" placeholder="By" disabled class="logininput">
                
                <!-- This is not on the site so ¯\_(ツ)_/¯ -->
            </p>

            <p>
                <label for="newuser-country">Land: </label>
                <input type="text" name="newuser-country" placeholder="Land" class="logininput">
                <?php if (!empty($countryErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($countryErr); ?></span>
                <?php endif; ?>
            </p>
            
            <p>
                <label for="newuser-email">E-mail: </label>
                <input type="text" name="newuser-email" placeholder="E-mail adresse" class="logininput">
                <?php if (!empty($emailErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($emailErr); ?></span>
                <?php endif; ?>
            </p>
            
            <p>
                <label for="newuser-website">Website: </label>
                <input type="text" name="newuser-website" placeholder="Indtast URL på din hjemmeside" class="logininput">
                <?php if (!empty($websiteErr)): ?>
                    <span style="color:red; font-size: small;"><?php echo CleanText($websiteErr); ?></span>
                <?php endif; ?>
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