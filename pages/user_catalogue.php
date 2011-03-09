<?php
include('includes/user.inc.php');
if(isset($_GET['action']))
{
	$action = htmlspecialchars($_GET['action']);
}
else
{
	$action="";
}

if(session_id()=="" || ($_SESSION['userlevel']>100 || $_SESSION['userlevel']<1))
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
	if(!isset($_POST['formation']))
	{
		echo '
					<div class="style1">
						<h3>Catalogue de formations</h3>
						<div class="style1_contenu"></div><br />
							Veuillez selectionner la formation pour obtenir plus d\'information : <br /><br />
							<form action="'.$ROOT.'index.php?page=user_catalogue" method="post">
							<table border="0">
								<tr>
									<td>Formation</td>
									<td>';
									try
									{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
										$reponse = $bdd->query('SELECT * FROM formation ORDER BY THEME');
										echo '<select name="formation">';
										while ($donnees = $reponse->fetch())
										{
											try
											{
												$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
												$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
												$reponse2 = $bdd->prepare('SELECT NOM FROM theme WHERE ID_THEME=:id');
												$reponse2->execute(array(
												'id' => $donnees['ID_FORMATION']
												));
												while ($donnees2 = $reponse2->fetch())
												{
													echo '<option value="'. $donnees['ID_FORMATION'] . '">' . $donnees['NOM'] . ' - Theme : <strong> '  . $donnees2['NOM'] . '</strong> - Durée : ' . $donnees['DUREE'] . '</option>';
												}
												$reponse->closeCursor();
											}
											catch(Exception $e)
											{
												die('Erreur : '.$e->getMessage());
											}
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
							<input type="submit" value="Valider" />
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
					</div>';
	}
	else
	{
		$user=User::getInstance();
		$resultat=$user->exist_formation($_POST['formation']);
		if($resultat!="noerror")
		{
			echo '
			<div class="style1">
					<h3>Catalogue de formations</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de l\'affichage des details de la formation : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
				$reponse = $bdd->prepare('SELECT * FROM formation WHERE ID_FORMATION=:id');
				$reponse->execute(array(
				'id' => $_POST['formation']
				));
				while ($donnees = $reponse->fetch())
				{
					echo '<div class="style1">
							<h3>' . strtoupper($donnees['NOM']) . ' </h3>
							<div class="style1_contenu"></div>
							</div> <!-- fin .style1_contenu -->
						</div> <!-- fin .style1 -->	
						<div class="style2">
							<h3>Objectif</h3>
							<div class="style2_contenu">'.$donnees['OBJECTIF'].'
							</div>
						</div>
						<div class="style2">
							<h3>Programme</h3>
							<div class="style2_contenu">'.$donnees['PROGRAMME'].'
							</div>
						</div>
						<div class="style2">
							<h3>Intervenant</h3>
							<div class="style2_contenu">';
							try
							{
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
								$reponse2 = $bdd->prepare('SELECT * FROM intervenant WHERE ID_INTERVENANT=:id');
								$reponse2->execute(array(
								'id' => $donnees['INTERVENANT']
								));
								while ($donnees2 = $reponse2->fetch())
								{
									echo $donnees2['NOM'] . ' ' . $donnees2['PRENOM'] . ' - '  . $donnees2['METIER'] . ' - ' . $donnees2['ETABLISSEMENT'];
								}
								$reponse->closeCursor();
							}
							catch(Exception $e)
							{
								die('Erreur : '.$e->getMessage());
							}
							echo'</div>
						</div>
						<div class="style2">
							<h3>Prérequis</h3>
							<div class="style2_contenu">'.$donnees['PREREQUIS'].'
							</div>
						</div>
						<div class="style2">
							<h3>Niveau de Competence</h3>
							<div class="style2_contenu">';
							try
							{
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
								$reponse3 = $bdd->prepare('SELECT * FROM nivcomp WHERE ID_NIVCOMP=:id');
								$reponse3->execute(array(
								'id' => $donnees['NIVCOMP']
								));
								while ($donnees3 = $reponse3->fetch())
								{
									echo $donnees3['NOM'];
								}
								$reponse->closeCursor();
							}
							catch(Exception $e)
							{
								die('Erreur : '.$e->getMessage());
							}
							echo '</div>
						</div>
						<div class="style2">
							<h3>Thème</h3>
							<div class="style2_contenu">';
							try
							{
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
								$reponse4 = $bdd->prepare('SELECT * FROM theme WHERE ID_THEME=:id');
								$reponse4->execute(array(
								'id' => $donnees['THEME']
								));
								while ($donnees4 = $reponse4->fetch())
								{
									echo $donnees4['NOM'] . ' : <br />' . $donnees4['DESCRIPTION'];
								}
								$reponse->closeCursor();
							}
							catch(Exception $e)
							{
								die('Erreur : '.$e->getMessage());
							}
							echo '</div>
						</div>
						<div class="style2">
							<h3>Durée</h3>
							<div class="style2_contenu">'.$donnees['DUREE'].'
							</div>
						</div>
						<div class="style2">
							<h3>Lieu</h3>
							<div class="style2_contenu">'.$donnees['LIEU'].'
							</div>
						</div>
				</div>';
			}
				$reponse->closeCursor();
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
			
		}
	}
}
?>