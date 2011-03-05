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
	
	public function register_values($nom,$prenom,$status,$email,$mdp)
	{
		$error="noerror";
		if($nom=="" || $prenom=="" || $status=="" || $email=="" || $mdp=="")
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
					$email = mysql_real_escape_string($email);
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
						
							if (get_magic_quotes_gpc()) 
							{
								$nom = stripslashes($nom);
								$prenom = stripslashes($prenom);
								$mdp = stripslashes($mdp);
							}
							$nom = mysql_real_escape_string($nom);
							$prenom = mysql_real_escape_string($prenom);
							$mdp = mysql_real_escape_string($mdp);
							try
							{
								$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
								$req = $this->bdd->prepare('INSERT INTO utilisateur(ID_UTILISATEUR, NOM, PRENOM, EMAIL, MOTDEPASSE, STATUS, DATEINSCRIPT, NIVEAU) VALUES ("", :nom, :prenom, :email, :motdepasse, :status, :date, 1)', $pdo_options);
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
				}
			}
		}
		return $error;
	}
}