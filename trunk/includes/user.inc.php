<?php
class User
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
		self::$unique = new user();  
		}
 
		return self::$unique;
	}
	
	public function nouveau_devis($id_user)
	{
		$error="noerror";
		try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$req = $this->bdd->prepare('INSERT INTO devis(ID_DEVIS, ID_UTILISATEUR, DATE_DEVIS, VALIDEE, PRIX, COMMENTAIRE) VALUES (:id, :id_user, :date, 2, 0, NULL)', $pdo_options);
			$req->execute(array(
				'id' => '',
				'id_user' => $id_user,
				'date' => time()
				));
		}
		catch (Exception $e)
		{
				return $e->getMessage();
		}
		return $error;
	}
	
	public function add_forma_devis($userid, $id, $formation)
	{
		$error="noerror";
		if(!is_numeric($userid) || !is_numeric($id) || !is_numeric($formation))
		{
			$error="Problème avec la formation et/ou l'id";
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_DEVIS FROM DEVIS WHERE ID_DEVIS=:id_devis AND ID_UTILISATEUR=:user_id', $pdo_options);
				$req->execute(array(
					'id_devis' => $id,
					'user_id' => $userid
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
				$error="Ce devis ne vous appartient pas";
			}
			else
			{
				try
				{
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$req = $this->bdd->prepare('SELECT ID_FORMATION FROM formation WHERE ID_FORMATION=:id', $pdo_options);
					$req->execute(array(
						'id' => $formation,
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
					$error="noerror";
					try
					{
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$req = $this->bdd->prepare('INSERT INTO contenu_devis(ID_CONTENU_DEVIS, ID_DEVIS, ID_FORMATION, NOMBRE_PARTICIPANT) VALUES (:id, :id_devis, :id_formation, 1)', $pdo_options);
						$req->execute(array(
							'id' => '',
							'id_devis' => $id,
							'id_formation' => $formation
							));
					}
					catch (Exception $e)
					{
							return $e->getMessage();
					}
					
				}
			}
		}
		return $error;
	}
	public function remove_forma_devis($userid, $id, $formation)
	{
		$error="noerror";
		if(!is_numeric($userid) || !is_numeric($id) || !is_numeric($formation))
		{
			$error="Problème avec la formation et/ou l'id";
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_DEVIS FROM DEVIS WHERE ID_DEVIS=:id_devis AND ID_UTILISATEUR=:user_id', $pdo_options);
				$req->execute(array(
					'id_devis' => $id,
					'user_id' => $userid
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
				$error="Ce devis ne vous appartient pas";
			}
			else
			{
				try
				{
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$req = $this->bdd->prepare('SELECT ID_FORMATION FROM contenu_devis WHERE ID_FORMATION=:id AND ID_DEVIS=:id_devis', $pdo_options);
					$req->execute(array(
						'id' => $formation,
						'id_devis' => $id
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
					$error="Cette entrée dans le devis n'existe pas";
				}
				else
				{
					$req = $this->bdd->prepare('DELETE FROM contenu_devis WHERE ID_FORMATION=:id AND ID_DEVIS=:id_devis');
					$req->execute(array(
						'id' => $formation,
						'id_devis' => $id
						));
					$req->closeCursor();
				}
			}
		}
		return $error;
	}
	
	public function supress_devis($userid, $id)
	{
		$error="noerror";
		if(!is_numeric($userid) || !is_numeric($id))
		{
			$error="Problème avec l'id";
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_DEVIS FROM DEVIS WHERE ID_DEVIS=:id_devis AND ID_UTILISATEUR=:user_id', $pdo_options);
				$req->execute(array(
					'id_devis' => $id,
					'user_id' => $userid
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
				$error="Ce devis ne vous appartient pas";
			}
			else
			{
				$req = $this->bdd->prepare('DELETE FROM devis WHERE ID_DEVIS=:id_devis');
				$req->execute(array(
					'id_devis' => $id
					));
				$req->closeCursor();
				
				$req = $this->bdd->prepare('DELETE FROM contenu_devis WHERE ID_DEVIS=:id_devis');
				$req->execute(array(
					'id_devis' => $id
					));
				$req->closeCursor();
			}
		}
		return $error;
	}
	
	public function send_devis($userid, $id)
	{
		$error="noerror";
		if(!is_numeric($userid) || !is_numeric($id))
		{
			$error="Problème avec l'id";
		}
		else
		{
			try
			{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$req = $this->bdd->prepare('SELECT ID_DEVIS FROM DEVIS WHERE ID_DEVIS=:id_devis AND ID_UTILISATEUR=:user_id', $pdo_options);
				$req->execute(array(
					'id_devis' => $id,
					'user_id' => $userid
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
				$error="Ce devis ne vous appartient pas";
			}
			else
			{
				try
				{
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$req = $this->bdd->prepare('SELECT ID_DEVIS FROM contenu_devis WHERE ID_DEVIS=:id_devis', $pdo_options);
					$req->execute(array(
						'id_devis' => $id
						));
					while ($donnees = $req->fetch())
					{
						$test2 = $donnees['ID_DEVIS'];
					}		
				}
				catch (Exception $e)
				{
					return $e->getMessage();
				}
				if (!isset($test2))
				{
					$error="Ce devis ne comporte pas de formation";
				}
				else
				{
					try
					{
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$req = $this->bdd->prepare('UPDATE devis SET VALIDEE=0, DATE_DEVIS=:date WHERE ID_DEVIS=:id_devis', $pdo_options);
						$req->execute(array(
							'id_devis' => $id,
							'date' => time()
							));
							
					}
					catch (Exception $e)
					{
						return $e->getMessage();
					}
				}
			}
		}
		return $error;
	}
	public function exist_formation($id)
	{
		$error="noerror";
		if(!is_numeric($id))
		{
			$error="Problème avec l'id";
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
				$error="Cette formation n'existe pas";
			}
		}
		return $error;
	}
	
}