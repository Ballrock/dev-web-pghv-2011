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
	if($action=="reply" && isset($_GET['id']) && is_numeric($_GET['id']))
	{
		if(!isset($_POST['prix']) || !isset($_POST['comment']))
		{
			echo '<div class="style1">
					<h3>Modifier une Session</h3>
					<div class="style1_contenu"></div>
					<form action="'.$ROOT.'index.php?page=admin_devis&action=reply&id='. $_GET['id'] .'" method="post">';
					try
					{
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
						$reponse = $bdd->prepare('SELECT * FROM devis WHERE ID_DEVIS=:id');
						$reponse->execute(array(
							'id' => $_GET['id']
							));
						while ($donnees = $reponse->fetch())
						{
							echo '<table border="1">
						<tr>
							<td><strong>ID</strong></td>
							<td><strong>Emmeteur</strong></td>
							<td><strong>Situation</strong></td>
							<td><strong>Date d\'émission</strong></td>
						</tr>
							<tr>
							<td>' . $donnees['ID_DEVIS']. '</td>
							<td>';	
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$reponse2 = $bdd->prepare('SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTILISATEUR=:id');
							$reponse2->execute(array(
							'id' => $donnees['ID_UTILISATEUR']
							));
							while ($donnees2 = $reponse2->fetch())
							{
								echo $donnees2['NOM'] . ' ' . $donnees2['PRENOM'];
							}
							$reponse2->closeCursor();
								echo '</td>
								<td>';	
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$reponse3 = $bdd->prepare('SELECT NOM FROM status WHERE ID_STATUS=(SELECT STATUS FROM utilisateur WHERE ID_UTILISATEUR=:id)');
							$reponse3->execute(array(
							'id' => $donnees['ID_UTILISATEUR']
							));
							while ($donnees3 = $reponse3->fetch())
							{
								echo $donnees3['NOM'];
							}
							$reponse2->closeCursor();
								echo '</td>
							<td>' . date("d/m/Y H:i:s", $donnees['DATE_DEVIS']) . '</td>						
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>Formation</strong></td>
							<td><strong>Durée</strong></td>
							<td><strong>Niveau Competence</strong></td>
						</tr>';
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse4 = $bdd->prepare('SELECT * FROM contenu_devis WHERE ID_DEVIS=:id');
							$reponse4->execute(array(
							'id' => $donnees['ID_DEVIS']
							));
							while ($donnees4 = $reponse4->fetch())
							{
								echo '<tr>
										<td>&nbsp;</td>';
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
												echo '<td>' . $donnees6['NOM'] . '</td>';
											}
										}
							}
							echo '</table><br/>';
						}
						$reponse->closeCursor();
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->getMessage());
					}
					echo '<table border="0">
					<tr>
						<td>Prix (en  €)</td>
						<td><input type="text" name="prix" id="prix"/></td>	
					</tr>
					<tr>
						<td>Commentaire</td>
						<td><textarea name="comment" rows=4 cols=40>
						</textarea></td>	
					</tr></table>
					<br />
					<input type="submit" value="Valider" />
						</div></div><!-- fin .style2_contenu -->
					</div> <!-- fin .style2 -->';
		}
		else
		{
			$admin=Admin::getInstance();
			$resultat=$admin->reponse_devis($_GET['id'], $_POST['prix'], $_POST['comment']);
			if($resultat!="noerror")
			{
				echo '
				<div class="style1">
						<h3>Repondre à un devis</h3>
						<div class="style1_contenu"></div>
							Une erreur est survenue lors de la reponse au devis : <br /> <h4>' . $resultat . '</h4> <br/><a href=javascript:history.back()>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
					</div>';
			}
			else
			{
				echo '<div class="style1">
							<h3>Repondre à un devis</h3>
							<div class="style1_contenu"></div>
								<h4>La reponse au devis à correctement été réalisé</h4><br/><a href='.$ROOT.'?page=admin_devis>Retour</a>
							</div> <!-- fin .style1_contenu -->
						</div> <!-- fin .style1 -->	
				</div>';
			}
		}
	}
	elseif($action=="delete" && isset($_GET['id']))
	{
		$admin=Admin::getInstance();
		$resultat=$admin->suppress_devis($_GET['id']);
		if($resultat!="noerror")
		{
			echo '
			<div class="style1">
					<h3>Supprimer un Devis</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de la suppression du devis : <br /> <h4>' . $resultat . '</h4> <br/><a href='.$ROOT.'?page=admin_devis>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
		}
		else
		{
			echo '<div class="style1">
						<h3>Supprimer un Devis</h3>
						<div class="style1_contenu"></div>
							<h4>Le debis a été correctement supprimé</h4><br/><a href='.$ROOT.'?page=admin_devis>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
			</div>';
		}
		
	}
			
	//----------------------------------------------------------- LISTE DES DEVIS ------------------------------------------------------------------------------
	else
	{
		echo '
					<div class="style1">
						<h3>Devis</h3>
						<div class="style1_contenu"></div>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->

					<div class="style2">
						<h3>Devis Non Traité(s)</h3>
						<div class="style2_contenu">
						<br />';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse = $bdd->query('SELECT * FROM devis WHERE VALIDEE=0');
							while ($donnees = $reponse->fetch())
							{
								echo '<table border="1">
							<tr>
								<td><strong>ID</strong></td>
								<td><strong>Emmeteur</strong></td>
								<td><strong>Situation</strong></td>
								<td><strong>Date d\'émission</strong></td>
								<td colspan="2"></td>
							</tr>
								<tr>
								<td>' . $donnees['ID_DEVIS']. '</td>
								<td>';	
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$reponse2 = $bdd->prepare('SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTILISATEUR=:id');
								$reponse2->execute(array(
								'id' => $donnees['ID_UTILISATEUR']
								));
								while ($donnees2 = $reponse2->fetch())
								{
									echo $donnees2['NOM'] . ' ' . $donnees2['PRENOM'];
								}
								$reponse2->closeCursor();
									echo '</td>
									<td>';	
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$reponse3 = $bdd->prepare('SELECT NOM FROM status WHERE ID_STATUS=(SELECT STATUS FROM utilisateur WHERE ID_UTILISATEUR=:id)');
								$reponse3->execute(array(
								'id' => $donnees['ID_UTILISATEUR']
								));
								while ($donnees3 = $reponse3->fetch())
								{
									echo $donnees3['NOM'];
								}
								$reponse2->closeCursor();
									echo '</td>
								<td>' . date("d/m/Y H:i:s", $donnees['DATE_DEVIS']) . '</td>						
								<td><a href="'.$ROOT.'index.php?page=admin_devis&action=reply&id='.$donnees['ID_DEVIS'].'">Repondre</a></td>
								<td><a onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce devis?\'))" href="'.$ROOT.'index.php?page=admin_devis&action=delete&id='.$donnees['ID_DEVIS'].'">Supprimer</a></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><strong>Formation</strong></td>
								<td><strong>Durée</strong></td>
								<td><strong>Niveau Competence</strong></td>
								<td colspan="2"></td>
							</tr>';
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
								$reponse4 = $bdd->prepare('SELECT * FROM contenu_devis WHERE ID_DEVIS=:id');
								$reponse4->execute(array(
								'id' => $donnees['ID_DEVIS']
								));
								while ($donnees4 = $reponse4->fetch())
								{
									echo '<tr>
											<td>&nbsp;</td>';
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
													echo '<td>' . $donnees6['NOM'] . '</td>';
												}
											}
											echo '<td colspan="2">&nbsp;</td></tr>';
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
							$reponse = $bdd->query('SELECT * FROM devis WHERE VALIDEE=1');
							while ($donnees = $reponse->fetch())
							{
								echo '<table border="1">
							<tr>
								<td><strong>ID</strong></td>
								<td><strong>Emmeteur</strong></td>
								<td><strong>Situation</strong></td>
								<td><strong>Date d\'émission</strong></td>
								<td><strong>Prix (en  €)</strong></td>
								<td></td>
							</tr>
								<tr>
								<td>' . $donnees['ID_DEVIS']. '</td>
								<td>';	
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$reponse2 = $bdd->prepare('SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTILISATEUR=:id');
								$reponse2->execute(array(
								'id' => $donnees['ID_UTILISATEUR']
								));
								while ($donnees2 = $reponse2->fetch())
								{
									echo $donnees2['NOM'] . ' ' . $donnees2['PRENOM'];
								}
								$reponse2->closeCursor();
									echo '</td>
									<td>';	
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$reponse3 = $bdd->prepare('SELECT NOM FROM status WHERE ID_STATUS=(SELECT STATUS FROM utilisateur WHERE ID_UTILISATEUR=:id)');
								$reponse3->execute(array(
								'id' => $donnees['ID_UTILISATEUR']
								));
								while ($donnees3 = $reponse3->fetch())
								{
									echo $donnees3['NOM'];
								}
								$reponse2->closeCursor();
									echo '</td>
								<td>' . date("d/m/Y H:i:s", $donnees['DATE_DEVIS']) . '</td>						
								<td>' . $donnees['PRIX'] . '</td>
								<td><a onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce devis?\'))" href="'.$ROOT.'index.php?page=admin_devis&action=delete&id='.$donnees['ID_DEVIS'].'">Supprimer</a></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><strong>Formation</strong></td>
								<td><strong>Durée</strong></td>
								<td><strong>Niveau Competence</strong></td>
								<td colspan="2"></td>
							</tr>';
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
								$reponse4 = $bdd->prepare('SELECT * FROM contenu_devis WHERE ID_DEVIS=:id');
								$reponse4->execute(array(
								'id' => $donnees['ID_DEVIS']
								));
								while ($donnees4 = $reponse4->fetch())
								{
									echo '<tr>
											<td>&nbsp;</td>';
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
													echo '<td>' . $donnees6['NOM'] . '</td>';
												}
											}
											echo '<td colspan="2">&nbsp;</td></tr>';
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
						</div></div><!-- fin .style2_contenu -->
					</div> <!-- fin .style2 -->';
				
	}
}