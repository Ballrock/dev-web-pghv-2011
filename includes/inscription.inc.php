<?php
class Inscription
{
	private $bdd;
	private $nom;
	private $prenom;
	private $status;
	private $email;
	private $mdp;
	
	public function __construct()
	{
		if(!isset($DB_DBNAME))
		{
			include('includes\config.inc.php');
		}
		try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$this->bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
	}
	
	public function __destruct()
	{
	}
	
	public function register_values($nom,$prenom,$status,$email,$mdp,$nom_ent,$contact_ent,$tel_ent,$email_ent)
	{
		$error="noerror";
		if($nom=="" || $prenom=="" || $status=="" || $email=="" || $mdp=="" || (($status != 3 && $status != 4) && ( $nom_ent=="" || $contact_ent=="" || $tel_ent=="" || $email_ent==""))) //Demandeur d'emploi et Etudiant
		{
			$error="Un des champs de l'inscription est vide";
		}
		else
		{
			if(!is_numeric($status))
			{
				$error="Probleme avec le status ";
			}
			else
			{
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
					$error="Mauvais format pour l'émail";
				}
				else
				{
					$email = htmlentities($email);
					if (get_magic_quotes_gpc()) 
					{
						$email = stripslashes($email);
					}
					try
					{
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$req = $this->bdd->prepare('SELECT ID_UTILISATEUR FROM utilisateur WHERE EMAIL=:email', $pdo_options);
						$req->execute(array(
							'email' => $email,
							));
						while ($donnees = $req->fetch())
						{
							$test = $donnees['ID_UTILISATEUR'];
						}		
					}
					catch (Exception $e)
					{
						return $e->getMessage();
					}
					if (isset($test))
					{
						$error="Email déjà éxistant";
					}
					else
					{
						$nom = htmlentities($nom);
						$prenom = htmlentities($prenom);
						$mdp = htmlentities($mdp);
						$nom_ent = htmlentities($nom_ent);
						$contact_ent = htmlentities($contact_ent);
						$tel_ent = htmlentities($tel_ent);
						$email_ent = htmlentities($email_ent);
						if (get_magic_quotes_gpc()) 
						{
							$nom = stripslashes($nom);
							$prenom = stripslashes($prenom);
							$mdp = stripslashes($mdp);
							$nom_ent = stripslashes($nom_ent);
							$contact_ent = stripslashes($contact_ent);
							$tel_ent = stripslashes($tel_ent);
							$email_ent = stripslashes($email_ent);
						}
						if($status == 3 || $status == 4)
						{
							try
							{
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$req = $this->bdd->prepare('INSERT INTO utilisateur(ID_UTILISATEUR, NOM, PRENOM, EMAIL, MOTDEPASSE, STATUS, ENTREPRISE, DATEINSCRIPT, NIVEAU) VALUES ("", :nom, :prenom, :email, :motdepasse, :status,0 ,:date, 1)', $pdo_options);
								$req->execute(array(
									'nom' => $nom,
									'prenom' => $prenom,
									'email' => $email,
									'motdepasse' => sha1($mdp),
									'status' => $status,
									'date' => time(),
									));
							}
							catch (Exception $e)
							{
									return $e->getMessage();
							}
						}
						else
						{
							try
							{
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$req = $this->bdd->prepare('INSERT INTO utilisateur(ID_UTILISATEUR, NOM, PRENOM, EMAIL, MOTDEPASSE, STATUS, ENTREPRISE, NOM_ENTREPRISE, CONTACT_ENTREPRISE, TEL_CONTACT_ENT, MAIL_CONTACT_ENT, DATEINSCRIPT, NIVEAU) VALUES ("", :nom, :prenom, :email, :motdepasse, :status, :entreprise, :nom_ent, :contact_ent, :tel_ent, :email_ent, :date, 1)', $pdo_options);
								$req->execute(array(
									'nom' => $nom,
									'prenom' => $prenom,
									'email' => $email,
									'motdepasse' => sha1($mdp),
									'status' => $status,
									'entreprise' => 1,
									'nom_ent' => $nom_ent,
									'contact_ent' => $contact_ent,
									'tel_ent' => $tel_ent,
									'email_ent' => $email_ent,
									'date' => time(),
									));
							}
							catch (Exception $e)
							{
									return $e->getMessage();
							}
						}
							
					}
				}
			}
		}
		return $error;
	}
}