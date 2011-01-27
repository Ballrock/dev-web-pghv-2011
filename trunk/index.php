<?php

$page="";

include('header.php');
//-------------Contenu Page-------------
if ($page=='admin'){}
elseif ($page=='liste'){}
else
{
	include('accueil.php');
}
//-------------FIN --- Contenu Page-------------
include('footer.php');
?>