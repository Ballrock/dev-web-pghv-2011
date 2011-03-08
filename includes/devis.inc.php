<?php
class Devis
{
	private $bdd;
	private $session = null;
	private $cout;
	private $user = null;
	
	private function __construct($id_user)
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
		$session = array();
		$user = $id_user;
		$cout = 0;
	}
	
	private function __destruct()
	{
		unset($session);
	}
	
	public function ajout_session($stage)
	{
		$session[0][] = $stage;
		$session[1][] = 1;
		return true;
	}
	
	public function suppr_session($id)
	{
		unset($session[0][$id]);
		unset($session[1][$id]);
		$session = array_values($array);
		return true;
	}
	
	public function inc_participant($id)
	{
		$session[1][$id]++;
		return true;
	}
	
	public function dec_participant($id)
	{
		if($session[1][$id] == 1)
		{
			self::suppr_session($id);
		}
		else
		{
			$session[1][$id]--;
		}
		return true;
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
?>