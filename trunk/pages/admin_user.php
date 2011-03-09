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
	echo '
				<div class="style1">
					<h3>Utilisateur</h3>
					<div class="style1_contenu"></div>
						<br />';
					try
					{
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
						$reponse = $bdd->query('SELECT * FROM utilisateur');
						while ($donnees = $reponse->fetch())
						{
							echo '<table border="1">
							<tr>
								<td><strong>ID</strong></td>
								<td><strong>Nom</strong></td>
								<td><strong>Email</strong></td>
								<td><strong>Status</strong></td>
								<td><strong>Date d\'Inscription</strong></td>
								<td><strong>Niveau d\'Accés</strong></td>
							</tr>
							<tr>
							<td>' . $donnees['ID_UTILISATEUR']. '</td>
							<td>' . $donnees['NOM']. ' ' . $donnees['PRENOM'] .'</td>
							<td>' . $donnees['EMAIL']. '</td>
							<td>';	
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$reponse2 = $bdd->prepare('SELECT NOM FROM status WHERE ID_STATUS=:id');
							$reponse2->execute(array(
							'id' => $donnees['STATUS']
							));
							while ($donnees2 = $reponse2->fetch())
							{
								echo $donnees2['NOM'];
							}
							$reponse2->closeCursor();
							echo '<td>' . date("d/m/Y H:i:s", $donnees['DATEINSCRIPT']) . '</td>';
							if($donnees['NIVEAU']==100)
							{
								$niveau = "Admin";
							}
							//-----Rajouter des niveaux
							else
							{
								$niveau = "Client";
							}
							echo '<td>' . $niveau . '</td>';
							echo '</tr>';
							if($donnees['ENTREPRISE']==1)
							{
								echo'<tr>
										<td colspan="2"><strong>Entreprise</strong></td>
										<td colspan="2"><strong>Contact</strong></td>
										<td><strong>Tel</strong></td>
										<td><strong>Mail</strong></td>
									</tr>';
								echo'<tr>
										<td colspan="2">' . $donnees['NOM_ENTREPRISE'] . '</td>
										<td colspan="2">' . $donnees['CONTACT_ENTREPRISE'] . '</td>
										<td>' . $donnees['TEL_CONTACT_ENT'] . '</td>
										<td>' . $donnees['MAIL_CONTACT_ENT'] . '</td>
									</tr>';
							}
							echo'</table><br/>';
						}
						$reponse->closeCursor();
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->getMessage());
					}
		echo '				
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
}