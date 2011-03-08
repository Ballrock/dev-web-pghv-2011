<?php
if(!isset($_POST['host']) && !isset($_POST['db_name']) && !isset($_POST['db_username']) && !isset($_POST['db_password']) && !isset($_POST['root']))
{
	echo '<div class="style1">
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
				<td><input type="text" name="root" id="root"/></td>
			</tr>
		</table>
		<br />
		<input type="submit" value="Valider" />
		</div></div>
	</div>';
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
	$sqlFileToExecute = 'sql/catalogue_formation.sql';
	$con = mysql_connect($_POST['host'],$_POST['db_username'],$_POST['db_password']);
    if ($con !== false)
	{
	    // Load and explode the sql file
		$f = fopen($sqlFileToExecute,"r+");
        $sqlFile = fread($f,filesize($sqlFileToExecute));
        $sqlArray = explode(';',$sqlFile);
           
        //Process the sql file by statements
        foreach ($sqlArray as $stmt) 
	    if (strlen($stmt)>3)
		{
       	    $result = mysql_query($stmt);
      	    if (!$result)
			{
       	        $sqlErrorCode = mysql_errno();
       	        $sqlErrorText = mysql_error();
       	        $sqlStmt      = $stmt;
       	        break;
           	}
        }
    }
	
	echo '<div class="style1">
		<h3>L\'installation c\'est déroulé avec succés</h3>
		</div></div>
	</div>';
}
?>