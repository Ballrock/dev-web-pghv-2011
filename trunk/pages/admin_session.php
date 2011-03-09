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
	if($action=="edit" && isset($_GET['id']) && is_numeric($_GET['id']))
	{
		if(!isset($_POST['formation']) && !isset($_POST['datedebut']) && !isset($_POST['datefin']))
		{
			echo '<div class="style1">
				<h3>Modifier une Session</h3>
				<div class="style1_contenu"></div>
				<form action="'.$ROOT.'index.php?page=admin_session&action=edit&id='. $_GET['id'] .'" method="post">
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
					<tr>
						<td>Date de Debut</td>
						<td>
						<input type="text" name="datedebut" id="datedebut" value="';
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$reponse = $bdd->prepare('SELECT DATE_DEBUT FROM session WHERE ID_SESSION=:id');
						$reponse->execute(array(
						'id' => $_GET['id']
						));
						while ($donnees = $reponse->fetch())
						{
							echo $donnees['DATE_DEBUT'];
						}
						$reponse->closeCursor();
						echo'"/>
						</td>
					</tr>
					<tr>
						<td>Date de Fin</td>
						<td>
						<input type="text" name="datefin" id="datefin" value="';
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$reponse = $bdd->prepare('SELECT DATE_FIN FROM session WHERE ID_SESSION=:id');
						$reponse->execute(array(
						'id' => $_GET['id']
						));
						while ($donnees = $reponse->fetch())
						{
							echo $donnees['DATE_FIN'];
						}
						$reponse->closeCursor();
						echo'"/>
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
			$resultat=$admin->modif_session($_GET['id'], $_POST['datedebut'], $_POST['datefin'], $_POST['formation']);
			if($resultat!="noerror")
			{
				echo '
				<div class="style1">
						<h3>Modifier une Session</h3>
						<div class="style1_contenu"></div>
							Une erreur est survenue lors de la modification de la session : <br /> <h4>' . $resultat . '</h4> <br/><a href='.$ROOT.'?page=admin_session>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
					</div>';
			}
			else
			{
				echo '<div class="style1">
							<h3>Modifier une Session</h3>
							<div class="style1_contenu"></div>
								<h4>La session à été correctement modifié</h4><br/><a href='.$ROOT.'?page=admin_session>Retour</a>
							</div> <!-- fin .style1_contenu -->
						</div> <!-- fin .style1 -->	
				</div>';
			}
		}
	}
	//----------------------------------------------------------- AJOUT DE SESSION --------------------------------------------------------------------------------
	elseif($action=="new")
	{
		if(!isset($_POST['formation']) && !isset($_POST['datedebut']) && !isset($_POST['datefin']))
		{
			echo '<div class="style1">
				<h3>Créer une Session</h3>
				<div class="style1_contenu"></div>
				<form action="'.$ROOT.'index.php?page=admin_session&action=new" method="post">
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
					<tr>
						<td>Date de Debut</td>
						<td>
						<input type="text" name="datedebut" id="datedebut"/>
						</td>
					</tr>
					<tr>
						<td>Date de Fin</td>
						<td>
						<input type="text" name="datefin" id="datefin"/>
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
			$resultat=$admin->nouvelle_session($_POST['datedebut'], $_POST['datefin'], $_POST['formation']);
			if($resultat!="noerror")
			{
				echo '
				<div class="style1">
					<h3>Créer une Session</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de l\'ajout de la session : <br /> <h4>' . $resultat . '</h4> <br/><a href="javascript:history.back()">Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
			}
			else
			{
			echo '
				<div class="style1">
					<h3>Créer une Session</h3>
					<div class="style1_contenu"></div>
						<h4>L\'ajout de la session c\'est bien déroulée</h4><br/><a href='.$ROOT.'?page=admin_session>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
			}
		}
	}
	//----------------------------------------------------------- SUPPRESSION DE SESSION --------------------------------------------------------------------------
	elseif($action=="delete" && isset($_GET['id']))
	{
		$admin=Admin::getInstance();
		$resultat=$admin->suppress_session($_GET['id']);
		if($resultat!="noerror")
		{
			echo '
			<div class="style1">
					<h3>Supprimer une Session</h3>
					<div class="style1_contenu"></div>
						Une erreur est survenue lors de l\'annulation de la session : <br /> <h4>' . $resultat . '</h4> <br/><a href='.$ROOT.'?page=admin_session>Retour</a>
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
		}
		else
		{
			echo '<div class="style1">
						<h3>Supprimer une Session</h3>
						<div class="style1_contenu"></div>
							<h4>La session a été correctement annulé</h4><br/><a href='.$ROOT.'?page=admin_session>Retour</a>
						</div> <!-- fin .style1_contenu -->
					</div> <!-- fin .style1 -->	
			</div>';
		}
		
	}
	//----------------------------------------------------------- LISTE DES SESSIONS ------------------------------------------------------------------------------
	else
	{
		echo '
				<div class="style1">
					<h3>Session</h3>
					<div class="style1_contenu"></div>
						<br /><table border="1">
						<tr>
							<td><strong>ID</strong></td>
							<td><strong>Date de Debut</strong></td>
							<td><strong>Date de Fin</strong></td>
							<td><strong>Formation</strong></td>
							<td colspan=2>&nbsp;</td>
							
						</tr>';
					try
					{
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
						$reponse = $bdd->query('SELECT * FROM session');
						while ($donnees = $reponse->fetch())
						{
							echo '<tr>
							<td>' . $donnees['ID_SESSION']. '</td>
							<td>' . $donnees['DATE_DEBUT']. '</td>
							<td>' . $donnees['DATE_FIN']. '</td>
							<td>';	
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$reponse2 = $bdd->prepare('SELECT NOM FROM formation WHERE ID_FORMATION=:id');
							$reponse2->execute(array(
							'id' => $donnees['FORMATION']
							));
							while ($donnees2 = $reponse2->fetch())
							{
								echo $donnees2['NOM'];
							}
							$reponse2->closeCursor();
								echo '</td>
							<td><a href="'.$ROOT.'index.php?page=admin_session&action=edit&id='.$donnees['ID_SESSION'].'">Modifier</a></td>
							<td><a onclick="return(confirm(\'Etes-vous sûr de vouloir annuler cette session?\'))" href="'.$ROOT.'index.php?page=admin_session&action=delete&id='.$donnees['ID_SESSION'].'">Annuler</a></td>
						<tr>';
						}
						$reponse->closeCursor();
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->getMessage());
					}
		echo '				</table><br/>
					<a href="'.$ROOT.'index.php?page=admin_session&action=new">Créer un Session</a><br />
					</div> <!-- fin .style1_contenu -->
				</div> <!-- fin .style1 -->	
				</div>';
	}
}