<?php
session_start();
include_once("user_functions.php");
require 'config/setup.php';

$pages = 0;
$nb_per_pages = 5;
$offest = $pages * $nb_per_pages;
if ($_SESSION['auth']){
  if(!empty($_POST['comment'])){
		$user_id = $_SESSION['auth']->id;
		$pic_id = (int)htmlspecialchars($_POST['pic_id']);
		$comments = htmlspecialchars($_POST['comment']);
		$bdd->prepare('INSERT INTO comments SET comment = ?, uid = ?, photo_id = ?')->execute([$comments, $user_id, $pic_id]);

		$res_uid = $bdd->prepare('SELECT author_id FROM photos WHERE id=?');
		$res_uid->execute([$pic_id]);
		$uid = $res_uid->fetchAll(PDO::FETCH_COLUMN, 'author_id')[0];

		$res_mail = $bdd->prepare('SELECT mail, mail_active FROM membres WHERE id=?');
		$res_mail->execute([$uid]);
		$email = $res_mail->fetchAll()[0];

		if ((int)$email->mail_active === 1){
			$msg = $_SESSION['auth']->username." vient de commenter ta photo. Reviens vite lui répondre!";
			mail($email->mail, "Quelqu'un a commenté ta photo sur CamagrAnne!", $msg);
		}
	}
	if (!empty($_POST['pic_like_id'])) {
		$id = (int)$_POST['pic_like_id'];
		$res_uid = $bdd->prepare('SELECT author_id FROM photos WHERE id=?');
		$res_uid->execute([$id]);
		$uid = $res_uid->fetchAll(PDO::FETCH_COLUMN, 'author_id')[0];

		$res_mail = $bdd->prepare('SELECT mail, mail_active FROM membres WHERE id=?');
		$res_mail->execute([$uid]);
		$email = $res_mail->fetchAll()[0];

		$res = $bdd->prepare('SELECT nb_like FROM photos WHERE id=?');
		$res->execute([$id]);
		$tab = $res->fetchAll(PDO::FETCH_COLUMN, 'nb_like');

		$nb_like = (int)$tab[0] + 1;
		if ((int)$email->mail_active === 1){
			$msg = $_SESSION['auth']->username." vient de liker ta photo. Reviens vite sur CamagrAnne!";
			mail($email->mail, "Quelqu'un a liké ta photo sur CamagrAnne!", $msg);
		}

		$req = $bdd->prepare('UPDATE photos SET nb_like=? WHERE id=?')->execute([$nb_like, $id]);
		$data['nb_like'] = $nb_like;
		echo json_encode($data);
		exit();
	}
}

include_once("navigation.php");
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>GALLERY</title>
  <link rel="stylesheet" href="css/gallery.css">
  <script src="js/script.js"></script>
</head>

<body>
	<div class="container">
		<!-- <div class="header"></div> -->
		<div class="menu"></div>
		<div id="pictures" class="content">
		<?php
			/**
			 *	Foreach photo in the "photos" table in the db,
			 *	We create a block html for each image and these comments
			 */
			$sql = "SELECT photo, id, nb_like, author_id FROM photos ORDER BY create_date DESC LIMIT $offest, $nb_per_pages";
			$rep = $bdd->query($sql);
			$pic = $rep->fetchAll();

			foreach($pic as $data) {
				$reponse = $bdd->prepare('SELECT comment FROM comments INNER JOIN photos ON comments.photo_id = photos.id WHERE photos.id = ? ORDER BY comments.date DESC');
				$reponse->execute([$data->id]);
				$donnees = $reponse->fetchAll(PDO::FETCH_COLUMN, 'comments');

				echo "<div id='$data->id' class='gallery'>";
				echo "<img class='test_img' src='data:image/jpg;base64, $data->photo' width=500 height=400;/>";
				echo "<div class='comments'>";
                if (!($_SESSION['auth'])) {
					echo "<div class='nop'><a href='login.php'>Log in to like or comment</a></div>";
					echo "<div class='like'>";
					echo "<span class='heartg' alt='Heart''></span>";
					echo "</div>";
				} else {
					// echo "<form action='' method='post'>";
					echo "<input name='pic_id' value='$data->id' type='hidden'>";
					echo "<input id='comment_$data->id' name='comment' type='text' placeholder= 'Add a comment...' onkeydown='comment_key($data->id)'><input onclick='submit_comment($data->id)' type=submit Value='Done'>";
					// echo "</form>";
					echo "<div class='like'>";
					echo "<button name='like' type='hidden' onclick='addLike($data->id);'><span class='heart' alt='Heart' style='fill:red;'></span></button>";
					if ($_SESSION['auth']->id === $data->author_id){
						echo "<button class='delete_preview' onclick='delete_image_in_db($data->id)'><img src='logo_gal/trash.svg' alt='delete' max-width=100% height=45;></button>";
					} else {
						echo "<span class='delte' alt='delete' style='display: none'</span>";
					}
					echo "</div>";
				}
				echo "<p id='like_$data->id' style='color:black;font-weight:bold;'> $data->nb_like Likes</p>";
				echo "<div id='comments_$data->id' class='text'>";
				foreach($donnees as $commentaire) {
					echo "<p class='comment'>$commentaire</p>";

				}
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
			?>
		</div>
		<input type="hidden" id="pages" value="1">
		<div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div></div>
	</div>
</body>
</html>
<script src="js/like_comment.js"></script>