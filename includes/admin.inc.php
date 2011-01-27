<?php
include('.\config.inc.php');
class Admin
{
	private $bdd;
	private static $unique=NULL;
	
	private function __construct()
    {
    	try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$this->bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_DBNAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
    	self::$unique = $this;
    }
	
	private function __destruct()
    {
    }
	
	public static function getInstance()
	{
		if($unique!=NULL)
		{
			return Admin::unique;
		}
		else
		{
			self::__constuct();
			return Admin::unique;
		}
	}
	
	public function nouveau_stage($nom, $obj, $prog, $intervenant, $prerequis, $duree, $lieu, $nivcomp, $theme)
	{
		$nom = htmlentites($nom);
		$obj = htmlentites($obj);
		$prog = htmlentites($prog);
		$intervenant = htmlentites($intervenant);
		$prerequis = htmlentites($prerequis);
		$duree = htmlentites($duree);
		$lieu = htmlentites($lieu);
		$nivcomp = htmlentites($nivcomp);
		$theme = htmlentites($theme);
		
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
		$nom = mysql_real_escape_string($nom);
		$obj = mysql_real_escape_string($obj);
		$prog = mysql_real_escape_string($prog);
		$intervenant = mysql_real_escape_string($intervenant);
		$prerequis = mysql_real_escape_string($prerequis);
		$duree = mysql_real_escape_string($duree);
		$lieu = mysql_real_escape_string($lieu);
		$nivcomp = mysql_real_escape_string($nivcomp);
		$theme = mysql_real_escape_string($theme);
		
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
		return true;
	}
	
	public function modif_stage($id, $nom, $obj, $prog, $intervenant, $prerequis, $duree, $lieu, $nivcomp, $theme)
	{
		if(is_int($id)
		{
			$nom = htmlentites($nom);
			$obj = htmlentites($obj);
			$prog = htmlentites($prog);
			$intervenant = htmlentites($intervenant);
			$prerequis = htmlentites($prerequis);
			$duree = htmlentites($duree);
			$lieu = htmlentites($lieu);
			$nivcomp = htmlentites($nivcomp);
			$theme = htmlentites($theme);
		
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
			$id = mysql_real_escape_string($id);
			$nom = mysql_real_escape_string($nom);
			$obj = mysql_real_escape_string($obj);
			$prog = mysql_real_escape_string($prog);
			$intervenant = mysql_real_escape_string($intervenant);
			$prerequis = mysql_real_escape_string($prerequis);
			$duree = mysql_real_escape_string($duree);
			$lieu = mysql_real_escape_string($lieu);
			$nivcomp = mysql_real_escape_string($nivcomp);
			$theme = mysql_real_escape_string($theme);
		
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('UPDATE formation SET NOM=:nom, OBJECTIF=:obj, PROGRAMME=:prog, INTERVENANT=:intervenant, PREREQUIS=:prerequis, DUREE=:duree, LIEU=:lieu, NIVCOMP=:nivcomp, THEME=:theme WHERE ID=:id', $pdo_options);
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
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function suppress_stage($id)
	{
		if(is_int($id))
		{
				$req = $this->bdd->prepare('DELETE FROM formation WHERE ID_FORMATION=:id');
				$req->execute(array(
					'id' => $id
					));
				$req->closeCursor();
				return true;
		}
		else
		{
			return false;
		}
	}
	
	public function nouvelle_session($nom, $debut, $fin, $formation)
	{
		$nom = htmlentites($nom);
		$debut = htmlentites($debut);
		$fin = htmlentites($fin);
		$formation = htmlentites($formation);
		if(get_magic_quotes_gpc())
		{
			$nom = stripslashes($nom);
		}
		$nom = mysql_real_escape_string($nom);
		$debut = mysql_real_escape_string($debut);
		$fin = mysql_real_escape_string($fin);
		$formation = mysql_real_escape_string($formation);
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
		return true;
	}
	
	public function modif_session($id, $nom, $debut, $fin, $formation)
	{
		if(is_int($id))
		{
			$nom = htmlentites($nom);
			$debut = htmlentites($debut);
			$fin = htmlentites($fin);
			$formation = htmlentites($formation);
			if(get_magic_quotes_gpc())
			{
				$nom = stripslashes($nom);
			}
			$nom = mysql_real_escape_string($nom);
			$debut = mysql_real_escape_string($debut);
			$fin = mysql_real_escape_string($fin);
			$formation = mysql_real_escape_string($formation);
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
			return true;
			catch (Exception $e)
			{
				return $e->getMessage();
			}
		}
		else
		{
			return false;
		}
	}
	
	public function suppress_session($id)
	{
		if(is_int($id))
		{
			$req = $this->bdd->prepare('DELETE FROM session WHERE ID_SESSION=:id');
			$req->execute(array(
				'id' => $id
				));
			$req->closeCursor();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function nouveau_enseignant($nom, $prenom, $status, $etablissement)
	{
		$nom = htmlentites($nom);
		$prenom = htmlentites($prenom);
		$status = htmlentites($status);
		$etablissement = htmlentites($etablissement);
		if(get_magic_quotes_gpc())
		{
			$nom = stripslashes($nom);
		}
		$nom = mysql_real_escape_string($nom);
		$prenom = mysql_real_escape_string($prenom);
		$status = mysql_real_escape_string($status);
		$etablissement = mysql_real_escape_string($etablissement);
		try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$req = $this->bdd->prepare('INSERT INTO intervenant(ID_INTERVENANT, NOM, PRENOM, STATUS, ETABLISSEMENT) VALUES (:id, :nom, :prenom, :satus, :etablissement)', $pdo_options);
			$req->execute(array(
				'id' => '',
				'nom' => $nom,
				'prenom' => $prenom,
				'status' => $status,
				'etablissement' => $etablissement
				));
		}
		catch (Exception $e)
		{
				return $e->getMessage();
		}
		return true;
	}
	
	public function suppress_enseignant($id)
	{
		if(is_int($id))
		{
			$req = $this->bdd->prepare('DELETE FROM intervenant WHERE ID_INTERVENANT=:id');
			$req->execute(array(
				'id' => $id
				));
			$req->closeCursor();
			return true;
		}
		else
		{
			return false;
		}
	}
}
