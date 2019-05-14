<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>
<link rel="stylesheet" href="navigation.css">
<div class="navigation">
        <a href="signup.php">Home</a>
        <?php if (!$_SESSION['auth']) { ?>
        <a href="login.php">Login</a><?php } ?>
        <?php if (!$_SESSION['auth']) { ?>
        <a href="signup.php">Sign Up</a><?php } ?>
        <?php if ($_SESSION['auth']) { ?>
        <a href="montage.php">Take a Picture</a><?php } ?>
        <?php if ($_SESSION['auth']) { ?>
        <a href="account.php" >My Account</a><?php } ?>
        <?php if ($_SESSION['auth']) { ?>
        <a href="logout.php">Logout</a><?php } ?>
    </div>
<?php if(isset($_SESSION['flash'])): ?>
<?php foreach($_SESSION['flash'] as $type => $message): ?>
<div class="alert alert-><?= $type; ?>">
        <?= $message; ?>
</div>
<?php endforeach; ?>
<?php unset($_SESSION['flash']); ?>

<?php endif; ?>