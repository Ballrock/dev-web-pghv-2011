<?php
include('includes/connexion.inc.php');
if(!isset($_POST['email']) && !isset($_POST['password']))
{
echo '<div class="style1">
	<h3>Connexion</h3>
	<div class="style1_contenu"></div>
	<form action="'.$ROOT.'index.php?page=connect" method="post">
	<table border="0">
		<tr>
			<td>Email</td>
			<td><input type="text" name="email" id="email"/></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password" id="password" /></td>
		</tr>
	</table>
	<br />
	<input type="submit" value="Valider" />
	</div></div>
</div>';
}
else
{
	$connexion = new Connexion();
	$resultat = $connexion->connect_user($_POST['email'],$_POST['password']);
	if($resultat!="noerror")
	{
		echo '
		<div class="style1">
			<h3>Connexion</h3>
			<div class="style1_contenu"></div>
				Une erreur est survenue lors de votre inscription : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
			</div> <!-- fin .style1_contenu -->
		</div> <!-- fin .style1 -->	
		</div>';
	}
	else
	{
	echo '
		<div class="style1">
			<h3>Connexion</h3>
			<div class="style1_contenu"></div>
				<h4>Vous êtes correctement connecté</h4><br/><a href="'.$ROOT.'">Retour</a> 
			</div> <!-- fin .style1_contenu -->
		</div> <!-- fin .style1 -->	
		</div>';
	}
}
?>