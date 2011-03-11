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
	echo '
					<div class="style1">
						<h3>Devis</h3>
						<div class="style1_contenu"></div>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->

					<div class="style2">
						<h3>Devis En Attente(s)</h3>
						<div class="style2_contenu">
						<br />';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse = $bdd->prepare('SELECT * FROM devis WHERE VALIDEE=0 AND ID_UTILISATEUR=:id');
							$reponse->execute(array(
								'id' => $_SESSION['userid']
								));
							while ($donnees = $reponse->fetch())
							{
								echo '<table cellspacing="0"  border="1">
							<tr>
								<td colspan="2"><strong>ID</strong></td>
								<td colspan="2"><strong>Date d\'émission</strong></td>
							</tr>
								<tr>
								<td colspan="2">' . $donnees['ID_DEVIS']. '</td>
								<td colspan="2">' . date("d/m/Y H:i:s", $donnees['DATE_DEVIS']) . '</td>						
							</tr>
							<tr>
								<td><strong>Formation</strong></td>
								<td><strong>Durée</strong></td>
								<td colspan="2"><strong>Niveau Competence</strong></td>
							</tr>';
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
								$reponse4 = $bdd->prepare('SELECT * FROM contenu_devis WHERE ID_DEVIS=:id');
								$reponse4->execute(array(
								'id' => $donnees['ID_DEVIS']
								));
								while ($donnees4 = $reponse4->fetch())
								{
									echo '<tr>';
											$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
											$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
											$reponse5 = $bdd->prepare('SELECT * FROM formation WHERE ID_FORMATION=:id');
											$reponse5->execute(array(
											'id' => $donnees4['ID_FORMATION']
											));
											while ($donnees5 = $reponse5->fetch())
											{
												echo '<td>' . $donnees5['NOM'] . '</td>';
												echo '<td>' . $donnees5['DUREE'] . '</td>';
												$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
												$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
												$reponse6 = $bdd->prepare('SELECT * FROM nivcomp WHERE ID_NIVCOMP=:id');
												$reponse6->execute(array(
												'id' => $donnees5['NIVCOMP']
												));
												while ($donnees6 = $reponse6->fetch())
												{
													echo '<td colspan="2">' . $donnees6['NOM'] . '</td>';
												}
											}
											echo '</tr>';
								}
								echo '</table><br/>';
							}
							$reponse->closeCursor();
						}
						catch(Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
			echo '				
						</div><!-- fin .style2_contenu -->
					</div> <!-- fin .style2 -->
					
					<div class="style2">
						<h3>Devis Traité(s)</h3>
						<div class="style2_contenu">
						<br />';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse = $bdd->prepare('SELECT * FROM devis WHERE VALIDEE=1 AND ID_UTILISATEUR=:id');
							$reponse->execute(array(
								'id' => $_SESSION['userid']
								));
							while ($donnees = $reponse->fetch())
							{
								echo '<table cellspacing="0"  border="1">
							<tr>
								<td colspan="2"><strong>ID</strong></td>
								<td colspan="2"><strong>Date d\'émission</strong></td>
								<td><strong>Prix (en  €)</strong></td>
							</tr>
								<tr>
								<td colspan="2">' . $donnees['ID_DEVIS']. '</td>
								<td colspan="2">' . date("d/m/Y H:i:s", $donnees['DATE_DEVIS']) . '</td>						
								<td>' . $donnees['PRIX'] . '</td>
							</tr>
							<tr>
								<td><strong>Formation</strong></td>
								<td><strong>Durée</strong></td>
								<td colspan="3"><strong>Niveau Competence</strong></td>
							</tr>';
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
								$reponse4 = $bdd->prepare('SELECT * FROM contenu_devis WHERE ID_DEVIS=:id');
								$reponse4->execute(array(
								'id' => $donnees['ID_DEVIS']
								));
								while ($donnees4 = $reponse4->fetch())
								{
									echo '<tr>';
											$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
											$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
											$reponse5 = $bdd->prepare('SELECT * FROM formation WHERE ID_FORMATION=:id');
											$reponse5->execute(array(
											'id' => $donnees4['ID_FORMATION']
											));
											while ($donnees5 = $reponse5->fetch())
											{
												echo '<td>' . $donnees5['NOM'] . '</td>';
												echo '<td>' . $donnees5['DUREE'] . '</td>';
												$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
												$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
												$reponse6 = $bdd->prepare('SELECT * FROM nivcomp WHERE ID_NIVCOMP=:id');
												$reponse6->execute(array(
												'id' => $donnees5['NIVCOMP']
												));
												while ($donnees6 = $reponse6->fetch())
												{
													echo '<td colspan="3">' . $donnees6['NOM'] . '</td>';
												}
											}
											echo '</tr>';
								}
								echo '<tr><td colspan="5"><strong>Commentaire : </strong>' . $donnees['COMMENTAIRE'] . '</td></tr></table><br/>';
							}
							$reponse->closeCursor();
						}
						catch(Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
			echo '				
						</div></div><!-- fin .style2_contenu -->
					</div> <!-- fin .style2 -->';
}