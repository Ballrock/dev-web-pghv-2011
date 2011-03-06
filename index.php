<?php
/*------- index.php ---------

Gestion de Catalogue de formation

Date :
Auteurs :

------------------------------------------*/

include('includes/templates/header.php');

//PROTECTION DU GET
if(isset($_GET['page']))
{
	$page = htmlspecialchars($_GET['page']);
}
else
{
	$page="";
}

//-------------Contenu Page-------------
if($page=="")
{
	if(isset($_SESSION['userlevel']))
	{
		if($_SESSION['userlevel']==100)
		{
			include('pages/admin_index.php');
		}
		elseif ($_SESSION['userlevel']>=1 && $_SESSION['userlevel']<100)
		{
			include('pages/user_index.php');
		}
		else
		{
			include('pages/accueil.php');
		}
	}
	else
	{
		include('pages/accueil.php');
	}
}
else
{
	if($page=="connect")
	{
		include('pages/connexion.php');
	}
	elseif($page=="inscrip")
	{
		include('pages/inscription.php');
	}
	elseif($page=="accueil")
	{
		include('pages/accueil.php');
	}
	elseif($page=="deco")
	{
		include('pages/deconnexion.php');
	}
	else
	{
		if(isset($_SESSION['userlevel']))
		{
			if($_SESSION['userlevel']==100)
			{
				if ($page=='admin_forma')
				{
					include('pages/admin_formation.php');
				}
				else
				{
					include('pages/admin_index.php');
				}
			}
			elseif ($_SESSION['userlevel']>=1 && $_SESSION['userlevel']<100)
			{
				if ($page=='consultation')
				{
				}
				else
				{
					include('pages/user_index.php');
				}
			}
			else
			{
				include('pages/accueil.php');
			}
		}
		else
		{
			include('pages/accueil.php');
		}
	}
}
//-------------FIN --- Contenu Page-------------
include('includes/templates/footer.php');
?>