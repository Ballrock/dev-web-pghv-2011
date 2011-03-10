<?php
error_reporting(0);
if(!isset($_POST['host']) && !isset($_POST['db_name']) && !isset($_POST['db_username']) && !isset($_POST['db_password']) && !isset($_POST['root']))
{
	$root="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	echo '<html>
	<head>
	<title> Installation </title>
	</head>
	<body>
	<div class="style1">
		<h3>Installation</h3>
		<div class="style1_contenu"></div>
		<form action="index.php?page=install" method="post">
		<table border="0">
			<tr>
				<td>Hote de la base de donnée</td>
				<td><input type="text" name="host" id="host"/></td>
			</tr>
			<tr>
				<td>Nom de la base de donnée</td>
				<td><input type="text" name="db_name" id="db_name"/></td>
			</tr>
			<tr>
				<td>Nom du l\'utilisateur de la base de donnée</td>
				<td><input type="text" name="db_username" id="db_username"/></td>
			</tr>
			<tr>
				<td>Mot de passe de la base de donné</td>
				<td><input type="password" name="db_password" id="db_password"/></td>
			</tr>
			<tr>
				<td>Racine du site</td>
				<td><input type="text" name="root" text="$root"/></td>
			</tr>
		</table>
		<br />
		<input type="submit" value="Valider" />
		</div></div>
	</div></body></html>';
}
else
{
	$Fnm = "includes/config.inc.php";
	$inF=fopen($Fnm,"w");
	fputs($inF, "<?php\n");
	fputs($inF,"\$DB_HOST='".$_POST['host']."';\n");
	fputs($inF,"\$DB_DBNAME='".$_POST['db_name']."';\n");
	fputs($inF,"\$DB_USERNAME='".$_POST['db_username']."';\n");
	fputs($inF,"\$DB_PASSWORD='".$_POST['db_password']."';\n");
	fputs($inF,"\$ROOT='".$_POST['root']."';\n");
	fputs($inF,"?>");
	fclose($inF);

/* Création de la base de donnée*/	
	$bdd = mysql_connect($_POST['host'],$_POST['db_username'],$_POST['db_password']);
mysql_select_db($_POST['db_name'],$bdd);
	$requetes="";
	 
	$sql=file("sql/catalogue_formation.sql"); // on charge le fichier SQL
	foreach($sql as $l){ // on le lit
		if (substr(trim($l),0,2)!="--"){ // suppression des commentaires
			$requetes .= $l;
		}
	}
	
	$reqs = explode(";\n",$requetes);// on sépare les requêtes
	foreach($reqs as $req){	// et on les éxécute
		if (!mysql_query($req,$bdd) && trim($req)!=""){
			die("ERROR : ".$req); // stop si erreur 
		}
	}
	echo '
	<html>
	<head>
	<title> Installation </title>
	<meta http-equiv="refresh" content="3;url=");/>
	</head>
	<body>
	<div class="style1">
		<h3>L\'installation s\'est déroulé avec succés</h3>
		</div></div>
	</div>
	</body>
	</html>';
}
?>