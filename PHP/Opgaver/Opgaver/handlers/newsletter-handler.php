<?php
session_start();

include_once "./helper-functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-newsletter'])) {
    $firstname = CleanText($_POST['newsletter-firstname']);
    $email = CleanText($_POST['newsletter-email']);

    $_SESSION['newsletter_firstname'] = $firstname;
    $_SESSION['newsletter_email'] = $email;

    header("Location: newsletter-landing.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}