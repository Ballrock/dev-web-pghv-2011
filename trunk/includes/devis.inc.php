<?php
include('.\config.inc.php');
class Devis
{
	private $bdd;
	
	
	private function __construct()
	{
		try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$this->bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USERNAME, $DB_PASSWORD, $pdo_options);
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
	}
	
	private function __destruct()
	{
	}
	
	//TODO
	public function nouveau_devis()
	{
	}
	
	public function 