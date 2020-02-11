<nav class="navbar navbar-inverse navbar-fixed-left">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-left" href="<?= $pathFor['root'] ?>">
				<img src="<?= $pathFor['logo-menu'] ?>" class="logo-menu" alt="iBento">
			</a>
		</div> <!-- navbar-header -->

		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav" style="margin-top: 10px">
				<li>
					<form class="search" method="post" action="<?= $pathFor['search'] ?>">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Rechercher..." name="search">
					    	<div class="input-group-btn">
					      		<button class="btn btn-default" type="submit">
					        		<i class="glyphicon glyphicon-search"></i>
					      		</button>
					    	</div> <!-- input-group-btn -->
					  	</div> <!-- input-group -->
					</form> <!-- search -->
				</li>
				<li>
					<a href="<?= $pathFor['root'] ?>" title="Accueil"><span class="glyphicon glyphicon-home"></span> Accueil</a>
				</li>
<?php
if($idm->getIdentity())
{
	if($idm->getRole() == "admin") // Menu pour l'administrateur
	{
?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-cog"></span> Gestionnaire <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?= $pathFor['events_list'] ?>" title="Gestion des événéments"><span class="glyphicon glyphicon-briefcase"></span> Gestion des événéments</a>
						</li>
						<li>
							<a href="<?= $pathFor['users_list'] ?>" title="Gestion des utilisateurs"><span class="glyphicon glyphicon-user"></span> Gestion des utilisateurs</a>
						</li>
						<li>
							<a href="<?= $pathFor['participants_list'] ?>" title="Gestion des participants"><span class="glyphicon glyphicon-education"></span> Gestion des personnes</a>
						</li>
						<li>
							<a href="<?= $pathFor['itypes_list'] ?>" title="Gestion des types d'identification"><span class="glyphicon glyphicon-tags"></span> Gestion des types d'identification</a>
						</li>
					</ul>
				</li> <!-- dropdown -->
				<li>
					<a href="<?= $pathFor['dashboard'] ?>" title="Tableau de bord"><span class="glyphicon glyphicon-tasks"></span> Tableau de bord</a>
				</li>
<?php
	}
	else if($idm->getRole() == "user") // Menu pour l'utilisateur
	{
?>
				<li>
					<a href="<?= $pathFor['events_list'] ?>" title="Liste des événements"><span class="glyphicon glyphicon-briefcase"></span> Liste des événements</a>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-check"></span> Participations <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= $pathFor['badging__add'] ?>?nb=1">1</a></li>
						<li><a href="<?= $pathFor['badging__add'] ?>?nb=2">2</a></li>
						<li><a href="<?= $pathFor['badging__add'] ?>?nb=3">3</a></li>
						<li><a href="<?= $pathFor['badging__add'] ?>?nb=4">4</a></li>
						<li><a href="<?= $pathFor['badging__add'] ?>?nb=5">5</a></li>
					</ul>
				</li> <!-- dropdown -->
<?php
	}
?>
				<li>
					<a href="<?= $pathFor['logout'] ?>" title="Déconnexion"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a>
				</li>
<?php
}
else
{
?>
				<li>
					<a href="<?= $pathFor['adduser'] ?>" title="S'enregistrer"><span class="glyphicon glyphicon-user"></span> S'enregistrer</a>
				</li>
				<li>
					<a href="<?= $pathFor['login'] ?>" title="Connexion"><span class="glyphicon glyphicon-log-in"></span> Connexion</a>
				</li>
<?php
}
?>
			</ul> <!-- nav navbar-nav -->
		</div> <!-- collapse navbar-collapse -->
	</div> <!-- container-fluid -->
</nav> <!-- navbar navbar-inverse navbar-fixed-left -->
