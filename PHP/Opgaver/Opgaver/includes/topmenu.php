<?php
session_start();

include_once "../handlers/helper-functions.php"
?>

<nav class="top">
    <ul>
        <li><a href="#"><img src="./img/facebook-brands.svg" alt="Facebook logo"></a></li>
        <li><a href="#"><img src="./img/InstagramIcon-bw.png" alt="Instagram logo"></a></li>
        <li><a href="#"><img src="./img/TwitterIcon-bw.png" alt="Twitter logo"></a></li>
        <li><a href="#"><img src="./img/YoutubeIcon-bw.png" alt="YouTube logo"></a></li>
        <li>
        <?php if (!isset($_SESSION['loggedin_user'])): ?>
            <a href="login.php">Login</a>
        <?php else: ?>
            <span>Hej, <?php echo CleanText($_SESSION['loggedin_user']); ?>!</span>
            <a href="logout.php">Log ud</a>
        <?php endif; ?>
        </li>     
        <li class="carticon"><a href="#"><img src="../img/shopping-cart-solid.svg" alt="shopping cart icon"></a></li>
        <li><a href="#">Min kurv</a></li>
    </ul>
</nav>