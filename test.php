<html>
	<head>
		<title>JS affichage image</title>
	</head>
	
	<body>
		
		
		<br/>
		<?php
		$tableau=array("stickers/1.png","stickers/2.png","stickers/3.png","stickers/4.png");
		for($i=0;$i<count($tableau);$i++)
		{
			?>
			<span id="bouton<?php echo $i; ?>"  
			onclick="javascript:setImage('bouton<?php echo $i; ?>','image<?php echo $i; ?>','<?php echo $tableau[$i]; ?>','<?php echo $tableau[$i]; ?>');"> 
			Afficher <?php echo $tableau[$i]; ?></span>
			<div id="canvas-wrap">
				<canvas width="800" height="600"></canvas>
			<div id="image<?php echo $i; ?>"></div>
			</div>
			
			<!-- <canvas><div id="image<?php echo $i; ?>"></div></canvas> -->
			<!-- <div id="image<?php echo $i; ?>"></div> -->
			
			<?php
		}
		?>
		
		<br />
	
	</body>

		<script type="text/javascript"> 
			//bouton est l'id du bouton, id l'id de l'emplacement de l'image, titre le titre de l'image,image le lien
			function setImage(bouton,id,titre,image) { 
					var afficher=document.getElementById(id).innerHTML == "";
					var contenuImage=afficher ? "<img src="+image+" width='50' height='50' border='0' />" : "";
					var contenuBouton= "Afficher "+titre ; 
					
					document.getElementById(bouton).innerHTML= contenuBouton;
					document.getElementById(id).innerHTML= contenuImage;
			} 
		</script>	
</html>