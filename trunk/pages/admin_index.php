<?php
if(session_id()=="" || $_SESSION['userlevel']!=100)
{
	if(!isset($ROOT))
	{
		$ROOT="javascript:history.back()";
	}
	
	echo '<span align="center">Niveau d\'utilisateur insuffisant, <a href='.$ROOT.'>Retour</a>';
}
?>