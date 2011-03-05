<?php
class Connexion
{
	private $bdd;
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
	
	public function connect_user($email,$mdp)
	{
		$error="noerror";
		if($email=="" || $mdp=="")
		{
			$error="Un des champs de la connexion est vide";
		}
		else
		{
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{ 
					$error="Mauvais format pour l'émail";
			}
			else
			{
				$email = htmlentities($email);
				$mdp = htmlentities($mdp);
				if (get_magic_quotes_gpc()) 
				{
					$email = stripslashes($email);
					$mdp = stripslashes($mdp);
				}
				$email = mysql_real_escape_string($email);
				$mdp = mysql_real_escape_string($mdp);
				try
				{
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$req = $this->bdd->prepare('SELECT * FROM utilisateur WHERE EMAIL=:email', $pdo_options);
					$req->execute(array(
						'email' => $email,
						));
					while ($donnees = $req->fetch())
					{
						$id_sql = $donnees['ID_UTILISATEUR'];
						$niveau_sql = $donnees['NIVEAU'];
						$mdp_sql = $donnees['MOTDEPASSE'];
					}		
				}
				catch (Exception $e)
				{
					return $e->getMessage();
				}
				if(!isset($mdp_sql) || sha1($mdp) != $mdp_sql)
				{
					$error="Mot de passe ou Email incorrect";
				}
				else
				{
					$_SESSION['userlevel']=$niveau_sql;
					$_SESSION['user']=$email;
					$_SESSION['userid']=$id_sql;
					$_SESSION['user_password']=$mdp_sql;
				}
			}
		}
		return $error;
	}
}	