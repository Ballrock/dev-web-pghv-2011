<?php
include('includes/admin.inc.php');
if(isset($_GET['action']))
{
	$action = htmlspecialchars($_GET['action']);
}
else
{
	$action="";
}

if(session_id()=="" || $_SESSION['userlevel']!=100)
{
	if(!isset($ROOT))
	{
		$ROOT="javascript:history.back()";
	}
	
	echo '
		<div class="style1">
			<h3>Session</h3>
			<div class="style1_contenu"></div>
				Niveau d\'utilisateur insuffisant, <a href='.$ROOT.'>Retour</a>
			</div> <!-- fin .style1_contenu -->
		</div> <!-- fin .style1 -->	
		</div>';
}
else
{
	if($action=="new")
	{
		if(!isset($_POST['nom']) && !isset($_POST['prenom']) && !isset($_POST['email']) && !isset($_POST['metier']) && !isset($_POST['etablissement']))
		{
			echo '<div class="style1">
				<h3>Inscrire un Intervenant</h3>
				<div class="style1_contenu"></div>
				<form action="'.$ROOT.'index.php?page=admin_intervenant&action=new" method="post">
				<table border="0">
					<tr>
						<td>Nom</td>
						<td>
						<input type="text" name="nom" id="nom"/>
						</td>
					</tr>
					<tr>
						<td>Prenom</td>
						<td>
						<input type="text" name="prenom" id="prenom"/>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>
						<input type="text" name="email" id="email"/>
						</td>
					</tr>
					<tr>
						<td>Metier</td>
						<td>
						<input type="text" name="metier" id="metier"/>
						</td>
					</tr>
					<tr>
						<td>Etablissement</td>
						<td>
						<input type="text" name="etablissement" id="etablissement"/>
						</td>
					</tr>
				</table>
				<br />
				<input type="submit" value="Valider" />
				</div></div>
			</div>';
		}
		else
		{
			$admin=Admin::getInstance();
			$resultat=$admin->nouveau_enseignant($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['metier'], $_POST['etablissement']);
			if($resultat!="noerror")
			{
				echo '
				<div class="style1">
					<h3>Inscrire un Intervenann</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de l\'ajout de l\'intervenant : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
			}
			else
			{
			echo '
				<div class="style1">
					<h3>Inscrire un Intervenant</h3>
					<div class="style1_contenu"></div>
						<h4>L\'ajout de l\intervenant c\'est bien déroulée</h4><br/><a href='.$ROOT.'?page=admin_intervenant>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
			}
		}
	}
	elseif($action=="delete" && isset($_GET['id']))
	{
		$admin=Admin::getInstance();
		$resultat=$admin->suppress_enseignant($_GET['id']);
		if($resultat!="noerror")
		{
			echo '
			<div class="style1">
					<h3>Supprimer un Intervenant</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de la suppression de l\'intervenant : <br /> <h4>' . $resultat . '</h4> <br/><a href='.$ROOT.'?page=admin_intervevant>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
		}
		else
		{
			echo '<div class="style1">
						<h3>Supprimer un Intervenant</h3>
						<div class="style1_contenu"></div>
							<h4>L\'intervenant a été correctement supprimé</h4><br/><a href='.$ROOT.'?page=admin_intervenant>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
			</div>';
		}
	}
	else
	{
		echo '
					<div class="style1">
						<h3>Intervenant</h3>
						<div class="style1_contenu"></div>
							<br /><table border="1">
							<tr>
								<td><strong>ID</strong></td>
								<td><strong>Nom</strong></td>
								<td><strong>Email</strong></td>
								<td><strong>Metier</strong></td>
								<td><strong>Etablissement</strong></td>
								<td colspan="2"></td>
							</tr>';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse = $bdd->query('SELECT * FROM intervenant');
							while ($donnees = $reponse->fetch())
							{
								echo '<tr>
								<td>' . $donnees['ID_INTERVENANT']. '</td>
								<td>' . $donnees['NOM']. ' ' . $donnees['PRENOM'] .'</td>
								<td>' . $donnees['EMAIL']. '</td>
								<td>' . $donnees['METIER']. '</td>
								<td>' . $donnees['ETABLISSEMENT']. '</td>
								<td><a onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cet intervenant ?\'))" href="'.$ROOT.'index.php?page=admin_intervenant&action=delete&id='.$donnees['ID_INTERVENANT'].'">Supprimer</a></td>
								</tr>';
							}
							$reponse->closeCursor();
						}
						catch(Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
			echo '				</table><br/>
						<a href="'.$ROOT.'index.php?page=admin_intervenant&action=new">Inscrire un Intervenant</a><br />
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
					</div>';
	}
}