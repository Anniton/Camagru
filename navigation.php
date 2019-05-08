<link rel="stylesheet" href="navigation.css">
<div class="navigation">
        <a href="index.php">Home</a>
        <?php if (!$_SESSION['loggued_on_user']) { ?>
        <a href="login.php">Sign In</a><?php } ?>
        <?php if (!$_SESSION['loggued_on_user']) { ?>
        <a href="signup.php">Sign Up</a><?php } ?>
        <?php if ($_SESSION['loggued_on_user']) { ?>
        <a href="montage.php">Take a Picture</a><?php } ?>
        <?php if ($_SESSION['loggued_on_user']) { ?>
        <a href="account.php" >My Account</a><?php } ?>
        <?php if ($_SESSION['loggued_on_user']) { ?>
        <a href="logout.php">Logout</a><?php } ?>

    </div>
