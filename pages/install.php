<?php
if(!isset($_POST['host']) && !isset($_POST['db_name']) && !isset($_POST['db_username']) && !isset($_POST['db_password']))
{
	echo '<div class="style1">
		<h3>Installation</h3>
		<div class="style1_contenu"></div>
		<form action="'.$ROOT.'index.php?page=install" method="post">
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
		</table>
		<br />
		<input type="submit" value="Valider" />
		</div></div>
	</div>';
}
else
{
	echo 'Tout est déjà installé';
}
?>