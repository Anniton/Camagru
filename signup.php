<?php
session_start();
include_once("navigation.php");
?>

$bdd = new PDO('mysql:')

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Index</title>
  <link rel="stylesheet" href="style.css">	
  <!-- <script src="script.js"></script> -->
</head>


<body>
 <div class="container">
            <div class="header">CAMAGRU</div>
            <div class="menu"></div>
            <div class="content">
			<div class="title">CAMAGRU</div><br>
    		<div class="text">Sign up to see photos and videos from your friends.</div>
				   
    		<form action="index.php" method="post">
    			 <div>
				    	 <input type="text" id="fullname" name="name" placeholder="Full Name">
				 </div>
				    <div>
				       <!--  <label for="name">Nom :</label> -->
				        <input type="text" id="username" name="username" placeholder="Username">
				    </div>
				    <div>
				      <!--   <label for="mail">Mail :</label> -->
				        <input type="email" id="mail" name="usermail" placeholder="Email">
				    </div>
				    <div>
							<!-- <label for="pass">Password :</label> -->
				        <input type="password" id="passwd" name="password"
		           minlength="8" required placeholder="Password">
				    </div>
					<div>
				 	  <input type="submit" value="Submit">
					</div>
		</form>	
		<div class="txt">By signing up, you agree to our Terms . Learn how we collect, use and share your data in our Data Policy and how we use cookies and similar technology in our Cookies Policy .</div>
</div>
<div class="article" class="text">Have an account ? <b>  <a href="login.php">&nbsp;Log in</a></b></div>

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>