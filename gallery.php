<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
include_once("db.php");

// logged_only();
if ($_SESSION['auth']){

  if(!empty($_POST['comment'])){

    $user_id = $_SESSION['auth']->id;
    $comments = htmlspecialchars($_POST['comment']);

    $bdd->prepare('INSERT INTO comment SET comments = ?, uid = ?')->execute([$comments, $user_id]);

    $_SESSION['flash']['success'] = "comments add";
  }
  else{
    // header('Location: gallery.php');
  }
}

?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gallery</title>
  <link rel="stylesheet" href="gallery.css">	
  <script src="script.js"></script>
</head>


<body>
 <div class="container">
            <div class="header"></div>
            <div class="menu"></div>
            <div class="content">
            <form action="" method="post">
            <div class="gallery">
           
                <div class="comments"><input name="comment" type="text" placeholder= "Add a comment..."><input type=submit Value="Done">
                <p class="text">
                
                <?php
                // $user_id = $_SESSION['auth']->id;
                $reponse = $bdd->prepare('SELECT * FROM comment')->execute();
              
                
                ;
                while($row = mysql_fetch_object($reponse))
                {
                  echo $row['comments'];
                }
                ?>
                
                
                </p></div>
                        <img src="logo_hdr/chat-siamois.jpg"/>
          
            </div>
            </form>
                <div class="gallery"><div class="comments"><p class="text">Ce chat est merveilleux</p></div><img src="logo_hdr/chat1.jpg"/></div>
                <div class="gallery"><div class="comments"><p class="text">Ce chat est merveilleux</p></div><img src="logo_hdr/chat4.jpg"/></div>
                <div class="gallery"><div class="comments"><p class="text">Ce chat est merveilleux</p></div><img src="logo_hdr/chatRobinet.jpg"/></div>
               
               
    	



		
	

	
	
            </div>

            <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
  
</body>
</html>
