<?php
class Admin
{
	private $bdd;
	private static $unique=NULL;
	
	private function __construct()
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
	
	public static function getInstance()
	{
		if(is_null(self::$unique)) {
		self::$unique = new Admin();  
		}
 
		return self::$unique;
	}
	
	public function nouvelle_formation($nom, $obj, $prog, $intervenant, $prerequis, $duree, $lieu, $nivcomp, $theme)
	{
		$error="noerror";
		if($nom=="" || $obj=="" || $prog=="" || $intervenant=="" || $prerequis=="" || $duree=="" || $lieu=="" || $nivcomp=="" || $theme=="")
		{
			$error="Un des champs est vide";
		}
		else
		{
			if(!is_numeric($intervenant) || !is_numeric($nivcomp) || !is_numeric($theme))
			{
				$error="Problème avec l'intervenant, le niveau de competence ou le theme";
			}
			else
			{
				$nom = htmlentities($nom);
				$obj = htmlentities($obj);
				$prog = htmlentities($prog);
				$intervenant = htmlentities($intervenant);
				$prerequis = htmlentities($prerequis);
				$duree = htmlentities($duree);
				$lieu = htmlentities($lieu);
				$nivcomp = htmlentities($nivcomp);
				$theme = htmlentities($theme);
				
				if (get_magic_quotes_gpc()) 
				{
					$nom = stripslashes($nom);
					$obj = stripslashes($obj);
					$prog = stripslashes($prog);
					$intervenant = stripslashes($intervenant);
					$prerequis = stripslashes($prerequis);
					$duree = stripslashes($duree);
					$lieu = stripslashes($lieu);
					$nivcomp = stripslashes($nivcomp);
					$theme = stripslashes($theme);
				}
				try
				{
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$req = $this->bdd->prepare('INSERT INTO formation(ID_FORMATION, NOM, OBJECTIF, PROGRAMME, INTERVENANT, PREREQUIS, DUREE, LIEU, NIVCOMP, THEME) VALUES (:id, :nom, :obj, :prog, :intervenant, :prerequis, :duree, :lieu, :nivcomp, :theme)', $pdo_options);
					$req->execute(array(
						'id' => '',
						'nom' => $nom,
						'obj' => $obj,
						'prog' => $prog,
						'intervenant' => $intervenant,
						'prerequis' => $prerequis,
						'duree' => $duree,
						'lieu' => $lieu,
						'nivcomp' => $nivcomp,
						'theme' => $theme
						));
				}
				catch (Exception $e)
				{
						return $e->getMessage();
				}
			}
		}
		return $error;
	}
	
	public function modif_formation($id, $nom, $obj, $prog, $intervenant, $prerequis, $duree, $lieu, $nivcomp, $theme)
	{
		$error="noerror";
		if(is_numeric($id))
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_FORMATION FROM formation WHERE ID_FORMATION=:id', $pdo_options);
				$req->execute(array(
					'id' => $id,
					));
				while ($donnees = $req->fetch())
				{
					$test = $donnees['ID_FORMATION'];
				}		
			}
			catch (Exception $e)
			{
				return $e->getMessage();
			}
			if (!isset($test))
			{
				$error="Cette formation n'existe pas";
			}
			else
			{
				if($nom=="" || $obj=="" || $prog=="" || $intervenant=="" || $prerequis=="" || $duree=="" || $lieu=="" || $nivcomp=="" || $theme=="")
				{
					$error="Un des champs est vide";
				}
				else
				{
					if(!is_numeric($intervenant) || !is_numeric($nivcomp) || !is_numeric($theme))
					{
						$error="Problème avec l'intervenant, le niveau de competence ou le theme";
					}
					else
					{
						
						$nom = htmlentities($nom);
						$obj = htmlentities($obj);
						$prog = htmlentities($prog);
						$intervenant = htmlentities($intervenant);
						$prerequis = htmlentities($prerequis);
						$duree = htmlentities($duree);
						$lieu = htmlentities($lieu);
						$nivcomp = htmlentities($nivcomp);
						$theme = htmlentities($theme);
					
						if (get_magic_quotes_gpc()) 
						{
							$id = stripslashes($id);
							$nom = stripslashes($nom);
							$obj = stripslashes($obj);
							$prog = stripslashes($prog);
							$intervenant = stripslashes($intervenant);
							$prerequis = stripslashes($prerequis);
							$duree = stripslashes($duree);
							$lieu = stripslashes($lieu);
							$nivcomp = stripslashes($nivcomp);
							$theme = stripslashes($theme);
						}
					
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$req = $this->bdd->prepare('UPDATE formation SET NOM=:nom, OBJECTIF=:obj, PROGRAMME=:prog, INTERVENANT=:intervenant, PREREQUIS=:prerequis, DUREE=:duree, LIEU=:lieu, NIVCOMP=:nivcomp, THEME=:theme WHERE ID_FORMATION=:id', $pdo_options);
							$req->execute(array(
								'id' => $id,
								'nom' => $nom,
								'obj' => $obj,
								'prog' => $prog,
								'intervenant' => $intervenant,
								'prerequis' => $prerequis,
								'duree' => $duree,
								'lieu' => $lieu,
								'nivcomp' => $nivcomp,
							'theme' => $theme
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
		else
		{
			$error="L'id n'est pas de type numérique";
		}
		return $error;
	}
	
	public function suppress_formation($id)
	{
		$error="noerror";
		if(!is_numeric($id))
		{
			$error="La variable GET n'est pas numérique";	
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_FORMATION FROM formation WHERE ID_FORMATION=:id', $pdo_options);
				$req->execute(array(
					'id' => $id,
					));
				while ($donnees = $req->fetch())
				{
					$test = $donnees['ID_FORMATION'];
				}		
			}
			catch (Exception $e)
			{
				return $e->getMessage();
			}
			if (!isset($test))
			{
				$error="Cet ID n'existe pas";
			}
			else
			{
				$req = $this->bdd->prepare('DELETE FROM formation WHERE ID_FORMATION=:id');
				$req->execute(array(
					'id' => $id
					));
				$req->closeCursor();
			}
		}
		return $error;
	}
	
	public function ajout_theme($nom, $desc)
	{
		$error="noerror";
		if($nom=="" || $desc=="")
		{
			$error="Un des champs est vide";
		}
		else
		{
			$nom = htmlentities($nom);
			$desc = htmlentities($desc);
			if(get_magic_quotes_gpc())
			{
				$nom = stripslashes($nom);
				$desc = stripslashes($desc);
			}
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('INSERT INTO theme(ID_THEME, NOM, DESCRIPTION) VALUES (:id, :nom, :desc)', $pdo_options);
				$req->execute(array(
					'id' => '',
					'nom' => $nom,
					'desc' => $desc
					));
			}
			catch (Exception $e)
			{
					return $e->getMessage();
			}
		}
		return $error;
	}
	
	public function nouvelle_session($debut, $fin, $formation)
	{
		$error="noerror";
		if($debut=="" || $fin=="")
		{
			$error="Un des champs est vide";
		}
		else
		{
			if(!is_numeric($formation))
			{
				$error="L'id de formation n'est pas de type numérique";
			}
			else
			{
				$debut = htmlentities($debut);
				$fin = htmlentities($fin);
				if(get_magic_quotes_gpc())
				{
					$debut = stripslashes($debut);
					$fin = stripslashes($fin);
				}
				try
				{
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$req = $this->bdd->prepare('INSERT INTO session(ID_SESSION, DATE_DEBUT, DATE_FIN, FORMATION) VALUES (:id, :debut, :fin, :formation)', $pdo_options);
					$req->execute(array(
						'id' => '',
						'debut' => $debut,
						'fin' => $fin,
						'formation' => $formation
						));
				}
				catch (Exception $e)
				{
						return $e->getMessage();
				}
			}
		}
		return $error;
	}
	
	public function modif_session($id, $debut, $fin, $formation)
	{
		$error="noerror";
		if(is_numeric($id))
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_SESSION FROM session WHERE ID_SESSION=:id', $pdo_options);
				$req->execute(array(
					'id' => $id,
					));
				while ($donnees = $req->fetch())
				{
					$test = $donnees['ID_SESSION'];
				}		
			}
			catch (Exception $e)
			{
				return $e->getMessage();
			}
			if (!isset($test))
			{
				$error="Cette formation n'existe pas";
			}
			else
			{
				if($debut=="" || $fin=="")
				{
					$error="Un des champs est vide";
				}
				else
				{
					if(!is_numeric($formation))
					{
						$error="L'id de formation n'est pas de type numérique";
					}
					else
					{
						$debut = htmlentities($debut);
						$fin = htmlentities($fin);
						if(get_magic_quotes_gpc())
						{
							$debut = stripslashes($debut);
							$fin = stripslashes($fin);
						}
						try
						{
							$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
							$req = $this->bdd->prepare('UPDATE session SET DATE_DEBUT=:debut, DATE_FIN=:fin, FORMATION=:formation WHERE ID_SESSION=:id', $pdo_options);
							$req->execute(array(
								'id' => $id,
								'debut' => $debut,
								'fin' => $fin,
								'formation' => $formation
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
		else
		{
			$error="L'id n'est pas de type numérique";
		}
		return $error;
	}
	
	public function suppress_session($id)
	{
		$error="noerror";
		if(!is_numeric($id))
		{
			$error="La variable GET n'est pas numérique";	
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_SESSION FROM session WHERE ID_SESSION=:id', $pdo_options);
				$req->execute(array(
					'id' => $id,
					));
				while ($donnees = $req->fetch())
				{
					$test = $donnees['ID_SESSION'];
				}		
			}
			catch (Exception $e)
			{
				return $e->getMessage();
			}
			if (!isset($test))
			{
				$error="Cet ID n'existe pas";
			}
			else
			{
				$req = $this->bdd->prepare('DELETE FROM session WHERE ID_SESSION=:id');
				$req->execute(array(
					'id' => $id
					));
				$req->closeCursor();
			}
		}
		return $error;
	}
	
	public function reponse_devis($id, $prix, $comment)
	{
		$error="noerror";
		if(is_numeric($id))
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_DEVIS FROM devis WHERE ID_DEVIS=:id', $pdo_options);
				$req->execute(array(
					'id' => $id,
					));
				while ($donnees = $req->fetch())
				{
					$test = $donnees['ID_DEVIS'];
				}		
			}
			catch (Exception $e)
			{
				return $e->getMessage();
			}
			if (!isset($test))
			{
				$error="Ce devis n'existe pas";
			}
			else
			{
				if($prix=="" || !is_numeric($prix))
				{
					$error="Le prix est invalide";
				}
				else
				{
					$comment = htmlentities($comment);
					if(get_magic_quotes_gpc())
					{
						$comment = stripslashes($comment);
					}
					try
					{
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$req = $this->bdd->prepare('UPDATE devis SET VALIDEE=1, PRIX=:prix, COMMENTAIRE=:comment WHERE ID_DEVIS=:id', $pdo_options);
						$req->execute(array(
							'id' => $id,
							'prix' => $prix,
							'comment' => $comment
							));
							
					}
					catch (Exception $e)
					{
						return $e->getMessage();
						}
				}
			}
		}
		else
		{
			$error="L'id n'est pas de type numérique";
		}
		return $error;
	}
	public function suppress_devis($id)
	{
		$error="noerror";
		if(!is_numeric($id))
		{
			$error="La variable GET n'est pas numérique";	
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_DEVIS FROM devis WHERE ID_DEVIS=:id', $pdo_options);
				$req->execute(array(
					'id' => $id,
					));
				while ($donnees = $req->fetch())
				{
					$test = $donnees['ID_DEVIS'];
				}		
			}
			catch (Exception $e)
			{
				return $e->getMessage();
			}
			if (!isset($test))
			{
				$error="Cet ID n'existe pas";
			}
			else
			{
				$req = $this->bdd->prepare('DELETE FROM devis WHERE ID_DEVIS=:id');
				$req->execute(array(
					'id' => $id
					));
				$req->closeCursor();
				$req = $this->bdd->prepare('DELETE FROM contenu_devis WHERE ID_DEVIS=:id');
				$req->execute(array(
					'id' => $id
					));
				$req->closeCursor();
			}
		}
		return $error;
	}
	
	public function nouveau_enseignant($nom, $prenom, $email, $metier, $etablissement)
	{
		$error="noerror";
		if($nom=="" || $prenom=="" ||  $email=="" || $metier=="" || $etablissement=="")
		{
			$error="Un des champs de l'inscription est vide";
		}
		else
		{
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
				$error="Mauvais format pour l'émail";
			}
			else
			{
				$nom = htmlentities($nom);
				$prenom = htmlentities($prenom);
				$email = htmlentities($email);
				$metier = htmlentities($metier);
				$etablissement = htmlentities($etablissement);
				if(get_magic_quotes_gpc())
				{
					$nom = stripslashes($nom);
					$prenom = stripslashes($prenom);
					$email = stripslashes($email);
					$metier = stripslashes($metier);
					$etablissement = stripslashes($etablissement);
				}
				try
				{
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$req = $this->bdd->prepare('INSERT INTO intervenant(ID_INTERVENANT, NOM, PRENOM, EMAIL, METIER, ETABLISSEMENT) VALUES (:id, :nom, :prenom, :email, :metier, :etablissement)', $pdo_options);
					$req->execute(array(
						'id' => '',
						'nom' => $nom,
						'prenom' => $prenom,
						'email' => $email,
						'metier' => $metier,
						'etablissement' => $etablissement
						));
				}
				catch (Exception $e)
				{
						return $e->getMessage();
				}
			}
		}
		return $error;
	}
	
	public function suppress_enseignant($id)
	{
		$error="noerror";
		if(!is_numeric($id))
		{
			$error="La variable GET n'est pas numérique";	
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_INTERVENANT FROM intervenant WHERE ID_INTERVENANT=:id', $pdo_options);
				$req->execute(array(
					'id' => $id,
					));
				while ($donnees = $req->fetch())
				{
					$test = $donnees['ID_INTERVENANT'];
				}		
			}
			catch (Exception $e)
			{
				return $e->getMessage();
			}
			if (!isset($test))
			{
				$error="Cet ID n'existe pas";
			}
			else
			{
				$req = $this->bdd->prepare('DELETE FROM intervenant WHERE ID_INTERVENANT=:id');
				$req->execute(array(
					'id' => $id
					));
				$req->closeCursor();
			}
		}
		return $error;
	}
}
