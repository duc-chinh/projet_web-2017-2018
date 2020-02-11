<?php
require("auth/loader.php");

$title = "iBento - La boîte à savoir";
require("includes/header.php");
?>

<div class="container">
	<h2>Bienvenue <strong><?= htmlspecialchars($idm->getIdentity()) ?></strong> !</h2>
	<div id="Carousel" class="carousel slide" data-ride="carousel">

		<ol class="carousel-indicators">
			<li data-target="#Carousel" data-slide-to="0" class="active"></li>
			<li data-target="#Carousel" data-slide-to="1"></li>
			<li data-target="#Carousel" data-slide-to="2"></li>
		</ol>

		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="images/jumbotron1.png" alt="iBento - La boîte à savoir">
				<div class="carousel-caption">
					<h3>La boîte à savoir</h3>
					<p>Découvrez les événements proposés par notre équipe</p>
				</div> <!-- carousel-caption -->
			</div> <!-- item active -->

			<div class="item">
				<img src="images/jumbotron2.png" alt="Programmation Web">
				<div class="carousel-caption">
					<h3>Programmation Web</h3>
					<p>Maîtrisez les langages HTML, PHP et JavaScript pour développer votre propre site web</p>
				</div> <!-- carousel-caption -->
			</div> <!-- item -->

			<div class="item">
				<img src="images/jumbotron3.png" alt="Analyse">
				<div class="carousel-caption">
					<h3>Analyse</h3>
					<p>Nouveauté: améliorez vos connaissances en analyse mathématique</p>
				</div> <!-- carousel-caption -->
			</div> <!-- item -->
		</div> <!-- carousel-inner -->

		<a class="left carousel-control" href="#Carousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#Carousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div> <!-- id carousel -->
	<br>
   
	<h3 style="text-align: center">Catégories</h3>
	<div class="row">
		<div class="col-sm-4">
			<a href="modules/events/events_list.php?cid=2">
				<img src="images/cours.png" class="img-responsive" style="width:100%" alt="Cours">
				<p style="text-align: center">Cours</p>
			</a>
		</div> <!-- col-sm-4 -->

		<div class="col-sm-4"> 
			<a href="modules/events/events_list.php?cid=3">
				<img src="images/tps.png" class="img-responsive" style="width:100%" alt="TPs">
				<p style="text-align: center">Travaux pratiques</p>
			</a>
		</div> <!-- col-sm-4 -->

		<div class="col-sm-4">
			<a href="modules/events/events_list.php?cid=1">
				<img src="images/examens.png" class="img-responsive" style="width:100%" alt="Examens">
				<p style="text-align: center">Examens</p>
			</a>
		</div> <!-- col-sm-4 -->
	</div> <!-- row -->
</div> <!-- container -->

<?php
require("includes/footer.php");