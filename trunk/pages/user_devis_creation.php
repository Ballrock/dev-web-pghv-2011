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
if($action=="new")
{
	$user=User::getInstance();
	$resultat=$user->nouveau_devis($_SESSION['userid']);
	echo '
				<div class="style1">
					<h3>Nouveau Devis</h3>
					<div class="style1_contenu"></div>
						<h4>Le nouveau Devis a été créé vous pouvez maintenant rajouter des formations à celui-ci</h4><br/><a href='.$ROOT.'?page=user_devis_creation>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
}
elseif($action=="add" && isset($_GET['id']))
{
	if(!isset($_POST['formation']))
	{
		echo '
					<div class="style1">
						<h3>Ajouter une formation au devis</h3>
						<div class="style1_contenu"></div><br />
							Veuillez selectionner la formation à rajouter dans le devis : <br />
							<form action="'.$ROOT.'index.php?page=user_devis_creation&action=add&id=' . $_GET['id'] . '" method="post">
							<table border="0">
								<tr>
									<td>Formation</td>
									<td>';
									try
									{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
										$reponse = $bdd->query('SELECT * FROM formation');
										echo '<select name="formation">';
										while ($donnees = $reponse->fetch())
										{
											echo '<option value="'. $donnees['ID_FORMATION'] . '">' . $donnees['NOM'] . ' - Durée : ' . $donnees['DUREE'] . '</option>';
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
		$resultat=$user->add_forma_devis($_SESSION['userid'],$_GET['id'],$_POST['formation']);
		if($resultat!="noerror")
		{
			echo '
			<div class="style1">
					<h3>Ajouter une Formation au Devis</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de l\'ajout : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
		}
		else
		{
			echo '<div class="style1">
						<h3>Ajouter une Formation au Devis</h3>
						<div class="style1_contenu"></div>
							<h4>L\'ajout a été correctement effectué</h4><br/><a href='.$ROOT.'?page=user_devis_creation>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
			</div>';
		}
	}
}
elseif($action=="remove" && isset($_GET['id']))
{
	if(!isset($_POST['formation']))
	{
		echo '
					<div class="style1">
						<h3>Supprimer une formation du devis</h3>
						<div class="style1_contenu"></div><br />
							Veuillez selectionner la formation à supprimer devis : <br />
							<form action="'.$ROOT.'index.php?page=user_devis_creation&action=remove&id=' . $_GET['id'] . '" method="post">
							<table border="0">
								<tr>
									<td>Formation</td>
									<td>';
									try
									{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
										$reponse = $bdd->prepare('SELECT * FROM formation WHERE ID_FORMATION=(SELECT ID_FORMATION FROM contenu_devis WHERE ID_DEVIS=:id)');
										$reponse->execute(array(
										'id' => $_GET['id']
										));
										echo '<select name="formation">';
										while ($donnees = $reponse->fetch())
										{
											echo '<option value="'. $donnees['ID_FORMATION'] . '">' . $donnees['NOM'] . ' - Durée : ' . $donnees['DUREE'] . '</option>';
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
		$resultat=$user->remove_forma_devis($_SESSION['userid'],$_GET['id'],$_POST['formation']);
		if($resultat!="noerror")
		{
			echo '
			<div class="style1">
					<h3>Supprimer une formation du devis</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de la suppression : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
		}
		else
		{
			echo '<div class="style1">
						<h3>Supprimer une formation du devis</h3>
						<div class="style1_contenu"></div>
							<h4>La suppression a été correctement effectué</h4><br/><a href='.$ROOT.'?page=user_devis_creation>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
			</div>';
		}
	}
}

elseif($action=="delete" && isset($_GET['id']))
{
	$user=User::getInstance();
	$resultat=$user->supress_devis($_SESSION['userid'], $_GET['id']);
	if($resultat!="noerror")
	{
		echo '
		<div class="style1">
				<h3>Supprimer le "pré-devis"</h3>
				<div class="style1_contenu"></div>
					Une erreur est survenue lors de la suppression : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
				</div> <!-- fin .style1_contenu -->
			</div> <!-- fin .style1 -->	
			</div>';
	}
	else
	{
		echo '<div class="style1">
					<h3>Supprimer le "pré-devis"</h3>
					<div class="style1_contenu"></div>
						<h4>La suppression a été correctement effectué</h4><br/><a href='.$ROOT.'?page=user_devis_creation>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
		</div>';
	}
}

elseif($action=="send" && isset($_GET['id']))
{
	$user=User::getInstance();
	$resultat=$user->send_devis($_SESSION['userid'], $_GET['id']);
	if($resultat!="noerror")
	{
		echo '
		<div class="style1">
				<h3>Envoyer le devis</h3>
				<div class="style1_contenu"></div>
					Une erreur est survenue lors de l\'envoie : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
				</div> <!-- fin .style1_contenu -->
			</div> <!-- fin .style1 -->	
			</div>';
	}
	else
	{
		echo '<div class="style1">
					<h3>Envoyer le devis</h3>
					<div class="style1_contenu"></div>
						<h4>L\'envoie a été correctement effectué</h4><br/><a href='.$ROOT.'?page=user_devis_creation>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
		</div>';
	}
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
				<h3>Devis En Création(s)</h3>
				<div class="style2_contenu">
				<br />';
				try
				{
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
					$reponse = $bdd->prepare('SELECT * FROM devis WHERE VALIDEE=2 AND ID_UTILISATEUR=:id');
					$reponse->execute(array(
						'id' => $_SESSION['userid']
						));
					while ($donnees = $reponse->fetch())
					{
						echo '<table border="1">
					<tr>
						<td colspan="2"><strong>ID</strong></td>
						<td colspan="2"><strong>Date de Création</strong></td>
						<td><strong>Actions</strong></td>
					</tr>
						<tr>
						<td colspan="2">' . $donnees['ID_DEVIS']. '</td>
						<td colspan="2">' . date("d/m/Y H:i:s", $donnees['DATE_DEVIS']) . '</td>
						<td><a href="'.$ROOT.'index.php?page=user_devis_creation&action=add&id='.$donnees['ID_DEVIS'].'">Rajouter une Formation au Devis</a></td>
						</tr>
						<tr><td rowspan="3" colspan="4"></td><td><a href="'.$ROOT.'index.php?page=user_devis_creation&action=remove&id='.$donnees['ID_DEVIS'].'">Enlever une Formation du Devis</a></td></tr>
						<tr><td><a onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce devis?\'))" href="'.$ROOT.'index.php?page=user_devis_creation&action=delete&id='.$donnees['ID_DEVIS'].'">SUPPRIMER LE DEVIS</a></td></tr>
						<tr><td><a onclick="return(confirm(\'Etes-vous sûr de vouloir envoyer ce devis?\'))" href="'.$ROOT.'index.php?page=user_devis_creation&action=send&id='.$donnees['ID_DEVIS'].'">ENVOYER LE DEVIS</a></td></tr>					
					<tr>
						<td><strong>Formation</strong></td>
						<td><strong>Durée</strong></td>
						<td colspan="4"><strong>Niveau Competence</strong></td>
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
											echo '<td colspan="4">' . $donnees6['NOM'] . '</td>';
										}
									}
									echo '
							</tr>';
						}
						echo '</table><br/>';
					}
					$reponse->closeCursor();
				}
				catch(Exception $e)
				{
					die('Erreur : '.$e->getMessage());
				}
	echo '		<a href="'.$ROOT.'index.php?page=user_devis_creation&action=new">Nouveau Devis</a><br />		
				</div></div><!-- fin .style2_contenu -->
			</div> <!-- fin .style2 -->';
	}
}