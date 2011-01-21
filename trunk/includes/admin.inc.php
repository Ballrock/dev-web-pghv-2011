<?php
include('.\config.php');
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
    	Admin::unique = $this;
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
			Admin::__constuct();
			return Admin::unique;
		}
	}
	
	public function nouveau_stage($nom, $obj, $prog, $intervenant, $prerequis, $duree, $lieu, $nivcomp, $theme)
	{
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
		$nom = mysql_escape_string($nom);
		$obj = mysql_escape_string($obj);
		$prog = mysql_escape_string($prog);
		$intervenant = mysql_escape_string($intervenant);
		$prerequis = mysql_escape_string($prerequis);
		$duree = mysql_escape_string($duree);
		$lieu = mysql_escape_string($lieu);
		$nivcomp = mysql_escape_string($nivcomp);
		$theme = mysql_escape_string($theme);
		try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$req = $this->bdd->prepare('INSERT INTO formation(ID_FORMATION, NOM, OBJECTIF, PROGRAMME, INTERVENANT, PREREQUIS, DUREE, LIEU, NIVCOMP, THEME) VALUES (:id, :nom, :obj, :prog, :intervenant, :prerequis, :duree, :lieu, :nivcomp, :theme)', $pdo_options);
			$req->execute(array(
				'id' => ''
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
}
