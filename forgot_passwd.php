<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css">	
  <script src="script.js"></script>
</head>


<body>
 <div class="container">
            <div class="header">CAMAGRU</div>
            <div class="menu"></div>
            <div class="content">
			<div class="title">Trouble Logging In?</div><br>
    		<div class="text">Enter your email and we'll send you a link to get back into your account.</div>
				   
    		<form action="signup.php" method="post">
				    <div>
				        <input type="email" id="mail" name="usermail" placeholder="Email">
				    </div>
					<div>
				 	  <input type="submit" value="Send Login Link">
					</div>
		</form>	
		<br>
		<br>
		<div class="txt"><a href ="signup.php">Create New Account</a></div>
</div>
<div class="article" class="text"><b><a href="login.php">Back To Login</a></b></div>

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>
