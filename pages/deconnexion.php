<?php
if(session_id()!="")
{
	session_destroy();
	echo '
		<div class="style1">
			<h3>D�connexion</h3>
			<div class="style1_contenu"></div>
				<h4>Vous �tes correctement d�connect�</h4><br/><a href="'.$ROOT.'">Retour</a> 
			</div> <!-- fin .style1_contenu -->
		</div> <!-- fin .style1 -->	
		</div>';
}
else
{
echo '
<div class="style1">
			<h3>D�connexion</h3>
			<div class="style1_contenu"></div>
				<h4>Vous n\'�tes pas d�connect�</h4><br/><a href="'.$ROOT.'">Retour</a> 
			</div> <!-- fin .style1_contenu -->
		</div> <!-- fin .style1 -->	
		</div>';
}
?>