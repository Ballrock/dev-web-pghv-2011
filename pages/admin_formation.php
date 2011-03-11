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
			<h3>Formation</h3>
			<div class="style1_contenu"></div>
				Niveau d\'utilisateur insuffisant, <a href='.$ROOT.'>Retour</a>
			</div> <!-- fin .style1_contenu -->
		</div> <!-- fin .style1 -->	
		</div>';
}
else
{
	//----------------------------------------------------------- MODIFICATION DE FORMATION -------------------------------------------------------------------------
	if($action=="edit" && isset($_GET['id']) && is_numeric($_GET['id']))
	{
		if(!isset($_POST['nom']) && !isset($_POST['objectif']) && !isset($_POST['programme']) && !isset($_POST['intervenant']) && !isset($_POST['prerequis']) && !isset($_POST['duree']) && !isset($_POST['lieu']) && !isset($_POST['nivcomp']) && !isset($_POST['theme']))
		{
			echo '<div class="style1">
				<h3>Modifier une Formation</h3>
				<div class="style1_contenu"></div>
				<form action="'.$ROOT.'index.php?page=admin_forma&action=edit&id='. $_GET['id'] .'" method="post">
				<table cellspacing="0" border="0">
					<tr>
						<td>Nom</td>
						<td><input type="text" name="nom" id="nom" value="';
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
						$reponse = $bdd->prepare('SELECT NOM FROM formation WHERE ID_FORMATION=:id');
						$reponse->execute(array(
						'id' => $_GET['id']
						));
						while ($donnees = $reponse->fetch())
						{
							echo $donnees['NOM'];
						}
						$reponse->closeCursor();
						echo '"/></td>
					</tr>
					<tr>
						<td>Objectif</td>
						<td>
						<textarea name="objectif" rows=4 cols=40>';
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$reponse = $bdd->prepare('SELECT OBJECTIF FROM formation WHERE ID_FORMATION=:id');
						$reponse->execute(array(
						'id' => $_GET['id']
						));
						while ($donnees = $reponse->fetch())
						{
							echo $donnees['OBJECTIF'];
						}
						$reponse->closeCursor();
						echo '</textarea>
						</td>
					</tr>
					<tr>
						<td>Programme</td>
						<td>
						<textarea name="programme" rows=4 cols=40>';
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$reponse = $bdd->prepare('SELECT PROGRAMME FROM formation WHERE ID_FORMATION=:id');
						$reponse->execute(array(
						'id' => $_GET['id']
						));
						while ($donnees = $reponse->fetch())
						{
							echo $donnees['PROGRAMME'];
						}
						$reponse->closeCursor();
						echo '</textarea>
						</td>
					</tr>
					<tr>
						<td>Intervenant</td>
						<td>';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$reponse = $bdd->query('SELECT * FROM intervenant');
							echo '<select name="intervenant">';
							while ($donnees = $reponse->fetch())
							{
								echo '<option value="'. $donnees['ID_INTERVENANT'] . '">' . $donnees['NOM'] . ' ' .  $donnees['PRENOM'] . '</option>';
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
					<tr>
						<td>Prérequis</td>
						<td>
						<textarea name="prerequis" rows=4 cols=40>';
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$reponse = $bdd->prepare('SELECT PREREQUIS FROM formation WHERE ID_FORMATION=:id');
						$reponse->execute(array(
						'id' => $_GET['id']
						));
						while ($donnees = $reponse->fetch())
						{
							echo $donnees['PREREQUIS'];
						}
						$reponse->closeCursor();
						echo '</textarea>
						</td>
					</tr>
					<tr>
						<td>Durée</td>
						<td>
						<input type="text" name="duree" id="duree" value="';
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$reponse = $bdd->prepare('SELECT DUREE FROM formation WHERE ID_FORMATION=:id');
						$reponse->execute(array(
						'id' => $_GET['id']
						));
						while ($donnees = $reponse->fetch())
						{
							echo $donnees['DUREE'];
						}
						$reponse->closeCursor();
						echo '"/>
						</td>
					</tr>
					<tr>
						<td>Lieu</td>
						<td>
						<input type="text" name="lieu" id="lieu" value="';
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$reponse = $bdd->prepare('SELECT LIEU FROM formation WHERE ID_FORMATION=:id');
						$reponse->execute(array(
						'id' => $_GET['id']
						));
						while ($donnees = $reponse->fetch())
						{
							echo $donnees['LIEU'];
						}
						$reponse->closeCursor();
						echo '"/>
						</td>
					</tr>
					<tr>
						<td>Niveau de Competence</td>
						<td>';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$reponse = $bdd->query('SELECT * FROM nivcomp');
							echo '<select name="nivcomp">';
							while ($donnees = $reponse->fetch())
							{
								echo '<option value="'. $donnees['ID_NIVCOMP'] . '">' . $donnees['NOM'] . '</option>';
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
					<tr>
						<td>Theme</td>
						<td>';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$reponse = $bdd->query('SELECT * FROM theme');
							echo '<select name="theme">';
							while ($donnees = $reponse->fetch())
							{
								echo '<option value="'. $donnees['ID_THEME'] . '">' . $donnees['NOM'] . '</option>';
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
				</div></div>
			</div>';
		}
		else
		{
			$admin=Admin::getInstance();
			$resultat=$admin->modif_formation($_GET['id'], $_POST['nom'], $_POST['objectif'], $_POST['programme'], $_POST['intervenant'], $_POST['prerequis'], $_POST['duree'], $_POST['lieu'], $_POST['nivcomp'], $_POST['theme']);
			if($resultat!="noerror")
			{
				echo '
				<div class="style1">
						<h3>Modifier une Formation</h3>
						<div class="style1_contenu"></div>
							Une erreur est survenue lors de la modification de la formation : <br /> <h4>' . $resultat . '</h4> <br/><a href='.$ROOT.'?page=admin_forma>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
					</div>';
			}
			else
			{
				echo '<div class="style1">
							<h3>Modifier une Formation</h3>
							<div class="style1_contenu"></div>
								<h4>La formation à été correctement modifié</h4><br/><a href='.$ROOT.'?page=admin_forma>Retour</a>
							</div> <!-- fin .style1_contenu -->
						</div> <!-- fin .style1 -->	
				</div>';
			}
		}
	}
	//----------------------------------------------------------- SUPPRESSION DE FORMATION --------------------------------------------------------------------------
	elseif($action=="delete" && isset($_GET['id']))
	{
		$admin=Admin::getInstance();
		$resultat=$admin->suppress_formation($_GET['id']);
		if($resultat!="noerror")
		{
			echo '
			<div class="style1">
					<h3>Supprimer une Formation</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de la suppression de la formation : <br /> <h4>' . $resultat . '</h4> <br/><a href='.$ROOT.'?page=admin_forma>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
		}
		else
		{
			echo '<div class="style1">
						<h3>Supprimer une Formation</h3>
						<div class="style1_contenu"></div>
							<h4>La formation a été correctement supprimé</h4><br/><a href='.$ROOT.'?page=admin_forma>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
			</div>';
		}
		
	}
	//----------------------------------------------------------- AJOUT DE FORMATION --------------------------------------------------------------------------------
	elseif($action=="new")
	{
		if(!isset($_POST['nom']) && !isset($_POST['objectif']) && !isset($_POST['programme']) && !isset($_POST['intervenant']) && !isset($_POST['prerequis']) && !isset($_POST['duree']) && !isset($_POST['lieu']) && !isset($_POST['nivcomp']) && !isset($_POST['theme']))
		{
			echo '<div class="style1">
				<h3>Ajouter une Formation</h3>
				<div class="style1_contenu"></div>
				<form action="'.$ROOT.'index.php?page=admin_forma&action=new" method="post">
				<table cellspacing="0" border="0">
					<tr>
						<td>Nom</td>
						<td><input type="text" name="nom" id="nom"/></td>
					</tr>
					<tr>
						<td>Objectif</td>
						<td>
						<textarea name="objectif" rows=4 cols=40></textarea>
						</td>
					</tr>
					<tr>
						<td>Programme</td>
						<td>
						<textarea name="programme" rows=4 cols=40></textarea>
						</td>
					</tr>
					<tr>
						<td>Intervenant</td>
						<td>';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse = $bdd->query('SELECT * FROM intervenant');
							echo '<select name="intervenant">';
							while ($donnees = $reponse->fetch())
							{
								echo '<option value="'. $donnees['ID_INTERVENANT'] . '">' . $donnees['NOM'] . ' ' .  $donnees['PRENOM'] . '</option>';
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
					<tr>
						<td>Prérequis</td>
						<td>
						<textarea name="prerequis" rows=4 cols=40></textarea>
						</td>
					</tr>
					<tr>
						<td>Durée</td>
						<td>
						<input type="text" name="duree" id="duree"/>
						</td>
					</tr>
					<tr>
						<td>Lieu</td>
						<td>
						<input type="text" name="lieu" id="lieu"/>
						</td>
					</tr>
					<tr>
						<td>Niveau de Compétence</td>
						<td>';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse = $bdd->query('SELECT * FROM nivcomp');
							echo '<select name="nivcomp">';
							while ($donnees = $reponse->fetch())
							{
								echo '<option value="'. $donnees['ID_NIVCOMP'] . '">' . $donnees['NOM'] . '</option>';
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
					<tr>
						<td>Theme</td>
						<td>';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse = $bdd->query('SELECT * FROM theme');
							echo '<select name="theme">';
							while ($donnees = $reponse->fetch())
							{
								echo '<option value="'. $donnees['ID_THEME'] . '">' . $donnees['NOM'] . '</option>';
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
				</div></div>
			</div>';
		}
		else
		{
			$admin=Admin::getInstance();
			$resultat=$admin->nouvelle_formation($_POST['nom'], $_POST['objectif'], $_POST['programme'], $_POST['intervenant'], $_POST['prerequis'], $_POST['duree'], $_POST['lieu'], $_POST['nivcomp'], $_POST['theme']);
			if($resultat!="noerror")
			{
				echo '
				<div class="style1">
					<h3>Ajouter une Formation</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de l\'ajout de la formation : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
			}
			else
			{
			echo '
				<div class="style1">
					<h3>Ajouter une Formation</h3>
					<div class="style1_contenu"></div>
						<h4>L\'ajout de la formation c\'est bien déroulée</h4><br/><a href='.$ROOT.'?page=admin_forma>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
			}
		}
	}
	//----------------------------------------------------------- AJOUTER UN THEME ------------------------------------------------------------------------------
	elseif($action=="ajout_theme")
	{
		if(!isset($_POST['nom']) && !isset($_POST['desc']))
		{
			echo '<div class="style1">
					<h3>Ajouter un Theme</h3>
					<div class="style1_contenu"></div>
					<form action="'.$ROOT.'index.php?page=admin_forma&action=ajout_theme" method="post">
					<table cellspacing="0" border="0">
						<tr>
							<td>Nom</td>
							<td><input type="text" name="nom" id="nom"/></td>
						</tr>
						<tr>
							<td>Description</td>
							<td>
							<textarea name="description" rows=4 cols=40></textarea>
							</td>
						</tr>
					</table>
					<br />
					<input type="submit" value="Valider" />
					</form>
				</div></div>
			</div>';
		}
		else
		{
			$admin=Admin::getInstance();
			$resultat=$admin->ajout_theme($_POST['nom'], $_POST['description']);
			if($resultat!="noerror")
			{
				echo '
				<div class="style1">
					<h3>Ajouter un Thème</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de l\'ajout du thème : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
			}
			else
			{
			echo '
				<div class="style1">
					<h3>Ajouter un Thème</h3>
					<div class="style1_contenu"></div>
						<h4>L\'ajout du thème c\'est bien déroulée</h4><br/><a href='.$ROOT.'?page=admin_forma>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
			}
		}
	}
	//----------------------------------------------------------- LISTE DES FORMATIONS ------------------------------------------------------------------------------
	else
	{
		echo '
				<div class="style1">
					<h3>Formation</h3>
					<div class="style1_contenu"></div>
						<br /><table cellspacing="0" border="1">
						<tr>
							<td><strong>ID</strong></td>
							<td><strong>Formation</strong></td>
							<td><strong>Intervenant</strong></td>
							<td><strong>Durée</strong></td>
							<td><strong>Lieu</strong></td>
							<td><strong>Niveau</strong></td>
							<td><strong>Theme</strong></td>
							<td colspan=2>&nbsp;</td>
							
						</tr>';
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
							$reponse = $bdd->query('SELECT * FROM formation');
							while ($donnees = $reponse->fetch())
							{
								echo '<tr>
								<td>' . $donnees['ID_FORMATION']. '</td>
								<td>' . $donnees['NOM']. '</td>
								<td>';	
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$reponse2 = $bdd->prepare('SELECT NOM,PRENOM FROM intervenant WHERE ID_INTERVENANT=:id');
								$reponse2->execute(array(
								'id' => $donnees['INTERVENANT']
								));
								while ($donnees2 = $reponse2->fetch())
								{
									echo $donnees2['NOM'] . " " . $donnees2['PRENOM'];
								}
								$reponse2->closeCursor();
									echo '</td>
									<td>' . $donnees['DUREE']. '</td>
									<td>' . $donnees['LIEU']. '</td>
									<td>';
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$reponse3 = $bdd->prepare('SELECT NOM FROM nivcomp WHERE ID_NIVCOMP=:id');
								$reponse3->execute(array(
								'id' => $donnees['NIVCOMP']
								));
								while ($donnees3 = $reponse3->fetch())
								{
									echo $donnees3['NOM'];
								}
								$reponse3->closeCursor();
									echo '</td>
									<td>';
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$reponse4 = $bdd->prepare('SELECT NOM FROM theme WHERE ID_THEME=:id');
								$reponse4->execute(array(
								'id' => $donnees['THEME']
								));
								while ($donnees4 = $reponse4->fetch())
								{
									echo $donnees4['NOM'];
								}
								$reponse4->closeCursor();
									echo '</td>
								<td><a href="'.$ROOT.'index.php?page=admin_forma&action=edit&id='.$donnees['ID_FORMATION'].'">Modifier</a></td>
								<td><a onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette formation?\'))" href="'.$ROOT.'index.php?page=admin_forma&action=delete&id='.$donnees['ID_FORMATION'].'">Supprimer</a></td>
							<tr>';
							}
							$reponse->closeCursor();
						}
						catch(Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
		echo '				</table><br/>
					<a href="'.$ROOT.'index.php?page=admin_forma&action=new">Ajouter Formation</a><br />
					<a href="'.$ROOT.'index.php?page=admin_forma&action=ajout_theme">Ajouter Thème</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
	}

}
?>