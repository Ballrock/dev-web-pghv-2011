<?php
include('includes/inscription.inc.php');
if(!isset($_POST['nom']) && !isset($_POST['prenom']) && !isset($_POST['status']) && !isset($_POST['email']) && !isset($_POST['mdp']))
{

echo '<div class="style1">
	<h3>Incription</h3>
	<div class="style1_contenu"></div>
	</div> <!-- fin .style1_contenu -->
</div> <!-- fin .style1 -->

<div class="style2">
	<h3>Informations</h3>
	<div class="style2_contenu">
	<form action="'.$ROOT.'index.php?page=inscrip" method="post">
	<table border="0">
		<tr>
			<td>Nom</td>
			<td><input type="text" name="nom" id="nom"/></td>
		</tr>
		<tr>
			<td>Prénom</td>
			<td><input type="text" name="prenom" id="prenom" /></td>
		</tr>
		<tr>
			<td>Status</td>
			<td>';
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
				$reponse = $bdd->query('SELECT * FROM status');
				echo '<select name="status">';
				while ($donnees = $reponse->fetch())
				{
					echo '<OPTION VALUE="'. $donnees['ID_STATUS'] . '">' . $donnees['NOM'] . '</OPTION>';
				}
				$reponse->closeCursor();
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
			echo'</select>
			</td>
		</tr>
	</table>
	<br />
	</div><!-- fin .style2_contenu -->
		<h3>Informations Entreprise</h3>
	<div class="style2_contenu">
	A laisser vide si vous êtes demandeur d\'emploi ou étudiant.<br />
	<table border="0">
		<tr>
			<td>Nom de l\'Entreprise</td>
			<td><input type="text" name="nom_ent" id="nom_ent"/></td>
		</tr>
		<tr>
			<td>Contact</td>
			<td><input type="text" name="contact_ent" id="contact_ent"/></td>
		</tr>
		<tr>
			<td>Téléphone Contact</td>
			<td><input type="text" name="tel_ent" id="tel_ent"/></td>
		</tr>	
		<tr>
			<td>Email Contact</td>
			<td><input type="text" name="email_ent" id="email_ent"/></td>
		</tr>		
	</table>
	<br />
	</div><!-- fin .style2_contenu -->
	<h3>Informations de connexion</h3>	
	<div class="style2_contenu">	
	<table>
		<tr>
			<td>Email de Login</td>
			<td><input type="text" name="email" id="email" /></td>
		</tr>
		<tr>
			<td>Mot de Passe</td>
			<td><input type="password" name="mdp" /></td>
		</tr>
		<tr>
	</table>
	<br />
		<input type="submit" value="Valider" />
	</div>
	</div><!-- fin .style2_contenu -->
</div> <!-- fin .style2 -->';
}
else
{
	$inscription = new Inscription();
	$resultat = $inscription->register_values($_POST['nom'],$_POST['prenom'],$_POST['status'],$_POST['email'],$_POST['mdp'],$_POST['nom_ent'],$_POST['contact_ent'],$_POST['tel_ent'],$_POST['email_ent']);
	if($resultat!="noerror")
	{
		echo '
		<div class="style1">
			<h3>Inscription</h3>
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
			<h3>Inscription</h3>
			<div class="style1_contenu"></div>
				<h4>L\'inscription c\'est bien déroulée vous pouvez maintenant vous connecter</h4><br/><a href='.$ROOT.'>Retour</a>
			</div> <!-- fin .style1_contenu -->
		</div> <!-- fin .style1 -->	
		</div>';
	}
}
?>