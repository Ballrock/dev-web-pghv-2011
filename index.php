<?php

$page="";

include('includes/templates/header.php');
//-------------Contenu Page-------------
if ($page=='admin'){}
elseif ($page=='liste'){}
else
{
	include('pages/accueil.php');
}
//-------------FIN --- Contenu Page-------------
include('includes/templates/footer.php');
?>