<?php
session_start();
include_once("navigation.php");
include_once("user_functions.php");
include_once("db.php");

// logged_only();
if ($_SESSION['auth']){
  if(!empty($_POST['comment'])){
		$user_id = $_SESSION['auth']->id;
		$pic_id = (int)htmlspecialchars($_POST['pic_id']);
		$comments = htmlspecialchars($_POST['comment']);

		$bdd->prepare('INSERT INTO comments SET comment = ?, uid = ?, photo_id = ?')->execute([$comments, $user_id, $pic_id]);
		header('Location: gallery.php');
	// 	$_SESSION['flash']['success'] = "comments add";
	}
	if (!empty($_GET['pic_id'])) {
		$id = (int)$_GET['pic_id'];
		$res = $bdd->prepare('SELECT nb_like FROM photos WHERE id=?');
		$res->execute([$id]);
		$tab = $res->fetchAll(PDO::FETCH_COLUMN, 'nb_like');
		$nb_like = (int)$tab[0] + 1;
		$req = $bdd->prepare('UPDATE photos SET nb_like=? WHERE id=?')->execute([$nb_like, $id]);
		header('Location: gallery.php');
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
		<?php
			$rep = $bdd->query('SELECT photo, id, nb_like FROM photos');
			$pic = $rep->fetchAll();

			foreach($pic as $data) {
				$reponse = $bdd->prepare('SELECT comment FROM comments INNER JOIN photos ON comments.photo_id = photos.id WHERE photos.id = ?');
				$reponse->execute([$data->id]);
				$donnees = $reponse->fetchAll(PDO::FETCH_COLUMN, 'comments');

				echo "<form action='' method='post'>";
				echo "<div id='$data->id' class='gallery'>";
				echo "<img src='data:image/jpg;base64, $data->photo' width=500 height=400;/>";

				echo "<div class='comments'>";
                if (!($_SESSION['auth'])) {
                	echo "<div class='nop'><a href='login.php'>Log in to like or comment</a></div>";
				} else {
					echo "<input name='pic_id' value='$data->id' type='hidden'>";
                    echo "<input name='comment' type='text' placeholder= 'Add a comment...'><input type=submit Value='Done'>";
				}
				if (!($_SESSION['auth'])) {
					echo "<div class='like'>";
					echo "<a href='login.php'><img src='logo_hdr/heart.png'  alt='Heart' width=20 height=20/></a>";
					echo "<a href='login.php'><img src='logo_hdr/bulle_comment.png'  alt='Comment' width=25 height=25/></a>";
					echo "</div>";
				} else {
					echo "<div class='like'>";
					echo "<button name='like' type='hidden' onclick='addLike($data->id);'><img src='logo_hdr/heart.png'  alt='Heart' width=20 height=20/></button>";
					echo "</div>";
				}
				echo "<p> $data->nb_like Likes</p>";
				echo "<div class='text'>";
				foreach($donnees as $commentaire) {
                      echo "<p class='comment'>$commentaire</p>";
				}
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</form>";

			}
		?>
		</div>

		<div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
        </div>
</body>
</html>
<script>
function addLike(id) {
	req = new XMLHttpRequest();
	req.open("POST", "gallery.php?pic_id="+id, true);
	req.send();
}
</script>