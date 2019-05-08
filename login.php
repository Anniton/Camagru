<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>login</title>
  <link rel="stylesheet" href="style.css">	
  <script src="script.js"></script>
</head>


<body>
 <div class="container">
            <div class="header">CAMAGRU</div>
            <div class="menu"></div>
            <div class="content">
			<div class="title">CAMAGRU</div><br>

    		<form action="login.php" method="post">
				    <div>
				       <!--  <label for="name">Nom :</label> -->
				        <input type="text" id="username" name="username" placeholder="Username">
				    </div>
				    <div>
				        <input type="password" id="pass" name="password"
		           minlength="8" required placeholder="Password">
				    </div>
					<div>
				 	  <input type="submit" value="Log In">
					</div>
		</form>	
		<br>
		<br>
		<div class="txt"><a href="forgot_passwd.php">Forgot password?</a></div>
</div>
<div class="article" class="text">Don't have an account?<b>  <a href="signup.php">&nbsp;Sign up</a></b></div>

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>
