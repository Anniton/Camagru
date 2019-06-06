<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>
<link rel="stylesheet" href="navigation.css">
<div class="navigation">
        <div><a href="gallery.php"><img src="logo_hdr/logo_camagru_color.png" alt="Home" max-width=100% height=45;></a>
        <?php if (!$_SESSION) { ?></div>

        <div style="position:absolute; right:20; top:25;"><a href="login.php"><img src="logo_hdr/login.png" alt="Sign In" max-width=100% height=30;></a><?php } ?>
        <?php if (!$_SESSION) { ?></div>

        <div><a href="index.php"><img src="logo_hdr/signup.png" alt="Sign Up" max-width=100% height=45;></a><?php } ?>
        <?php if ($_SESSION) { ?></div>

        <div><a href="montage.php"><img src="logo_hdr/montage.png" max-width=100% height=45; alt="Take a Picture"></a><?php } ?>
        <?php if ($_SESSION) { ?></div>

        <div style="position:absolute; left:170; top:25;"><a href="account.php"><img src="logo_hdr/login.png" alt="Sign In" max-width=100% height=35;></a><?php } ?>
        <?php if ($_SESSION) { ?></div>
        <div style="position:absolute; right:20;"><a href="logout.php"><img src="logo_hdr/logout.png" alt="Log Out" max-width=100% height=45;></a><?php } ?></div>
    </div>
<?php if(isset($_SESSION['flash'])): ?>
<?php foreach($_SESSION['flash'] as $type => $message): ?>
<div class="alert alert-><?= $type; ?>">
        <?= $message; ?>
</div>
<?php endforeach; ?>
<?php unset($_SESSION['flash']); ?>

<?php endif; ?>