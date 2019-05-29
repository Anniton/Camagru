<?php
session_start();
/**
 *	Foreach photo in the "photos" table in the db,
	*	We create a block html for each image and these comments
	*/
include_once("db.php");
if (!empty($_POST['pages'])) {
	$pages = (int)$_POST['pages'];
	$nb_per_pages = 5;
	$offest = ($pages - 1) * $nb_per_pages;
}
$sql = "SELECT photo, id, nb_like FROM photos ORDER BY create_date DESC LIMIT $offest, $nb_per_pages";
$rep = $bdd->query($sql);
$pic = $rep->fetchAll();

foreach($pic as $data) {
	$reponse = $bdd->prepare('SELECT comment FROM comments INNER JOIN photos ON comments.photo_id = photos.id WHERE photos.id = ? ORDER BY comments.date DESC');
	$reponse->execute([$data->id]);
	$donnees = $reponse->fetchAll(PDO::FETCH_COLUMN, 'comments');

	echo "<form action='' method='post'>";
	echo "<div id='$data->id' class='gallery'>";
	echo "<img src='data:image/jpg;base64, $data->photo' width=500 height=400;/>";
	echo "<div class='comments'>";
	if (!($_SESSION['auth'])) {
		echo "<div class='nop'><a href='login.php'>Log in to like or comment</a></div>";
		echo "<div class='like'>";
		echo "<span class='heartg' alt='Heart''></span>";
		echo "</div>";
	} else {
		echo "<input name='pic_id' value='$data->id' type='hidden'>";
		echo "<input name='comment' type='text' placeholder= 'Add a comment...'><input type=submit Value='Done'>";
		echo "<div class='like'>";
		echo "<button name='like' type='hidden' onclick='addLike($data->id);'><span class='heart' alt='Heart' style='fill:red;'></span></button>";
		echo "</div>";
	}
	echo "<p style='color:black;font-weight:bold;'> $data->nb_like Likes</p>";
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