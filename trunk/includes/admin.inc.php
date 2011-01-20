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
	
	public nouveau_stage($nom, $obj, $prog, $intervenant, $prerequis, $duree, $lieu, $nivcomp, $theme)
	{
		//Pas fini
		$this->bdd->exec('INSERT INTO formation(ID_FORMATION, NOM, OBJECTIF, PROGRAMME, INTERVENANT, PREREQUIS, DUREE, LIEU, NIVCOMP, THEME) VALUES ('',$nom, $obj, $prog, $intervenant, $prerequis, $duree, $lieu, $nivcomp, $theme)');
		return true;
	}
}
