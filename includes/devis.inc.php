<?php
include('.\config.inc.php');
class Devis
{
	private $session = null;
	
	private function __construct()
	{
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