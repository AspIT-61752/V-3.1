<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-newsletter'])) {
    $firstname = htmlspecialchars(trim($_POST['newsletter-firstname']));
    $email = htmlspecialchars(trim($_POST['newsletter-email']));

    $_SESSION['newsletter_firstname'] = $firstname;
    $_SESSION['newsletter_email'] = $email;

    header("Location: newsletter-landing.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}