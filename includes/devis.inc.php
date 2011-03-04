<?php
include('.\config.inc.php');
class Devis
{
	private $bdd;
	private $session = null;
	private $cout = 0;
	
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
		$session = array();
	}
	
	private function __destruct()
	{
		unset($session);
	}
	
	public function ajout_session($stage)
	{
		$session[] = $stage;
		return true;
	}
	
	public function suppr_session($id)
	{
		unset($session($id));
		$session = array_values($array);
	}
	
	public function cout()
	{
		foreach($session as $i => $value)
		{
			//TODO requete SQL de récupération du prix
		}
	}
	
	public function get_cout()
	{
		return $cout;
	}

}