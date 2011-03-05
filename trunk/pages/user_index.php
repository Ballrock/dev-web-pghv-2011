<?php
if(session_id()=="" || ($_SESSION['userlevel']>100 || $_SESSION['userlevel']<1))
{
	if(!isset($ROOT))
	{
		$ROOT="javascript:history.back()";
	}
	
	echo '
		<div class="style1">
			<h3>Connexion</h3>
			<div class="style1_contenu"></div>
				Niveau d\'utilisateur insuffisant, <a href='.$ROOT.'>Retour</a>
			</div> <!-- fin .style1_contenu -->
		</div> <!-- fin .style1 -->	
		</div>';
}
else
{
echo <<<EOF
<div class="style1">
	<h3>Utilisateur</h3>
	<div class="style1_contenu"></div>
		Lorem ipsum copiosae pertinax ad vel, ea mel prima integre. Ei nostrud nominati definitiones cum. Aliquam percipitur sea in. No hinc veritus sea. Eu sea falli ornatus fabellas, vitae alienum interpretaris an pro.
	</div> <!-- fin .style1_contenu -->
</div> <!-- fin .style1 -->

<div class="style2">
	<h3>Sous-Titre</h3>
	<div class="style2_contenu">
	Ei possit nemore efficiantur eam, ei vix natum malis utamur. Sed habeo clita disputationi an. Mollis virtute quo cu, qui molestiae scripserit ea. Tritani ceteros ea est, ne etiam quaeque recusabo eam. Puto feugiat ex mea,
	laudem putent argumentum has ex, mea an volutpat ocurreret. Solum invidunt referrentur his ei, ad simul voluptatibus nam.</div>
	</div><!-- fin .style2_contenu -->
</div> <!-- fin .style2 -->
EOF;
}
?>