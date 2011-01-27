//-------------------------------------------------------------------------
// Fonction d'affichage d'une adresse email
// param: partie droite, partie gauche de l'adresse email a reconstituer
//-------------------------------------------------------------------------
function afficheMail(droite,gauche,contenu) {
	if(!isDefined(contenu)) {
		document.write("<a href=\"" + "mail" + "to:" + gauche + "@" + droite +"\">" + gauche + "@" + droite + "</a><img src=\"/images/protection-14x14.png\" title=\"Cette adresse est prot&eacute;g&eacute;e contre le spam\">");
	} else {
		document.write("<a href=\"" + "mail" + "to:" + gauche + "@" + droite +"\">" + contenu + "</a><img src=\"/images/protection-14x14.png\" title=\"Cette adresse est prot&eacute;g&eacute;e contre le spam\">");	
	}
}

function isDefined(variable) {
    return (!(!( variable||false )))
}

function portlet_showhide(id) {
        if(document.getElementById(id).style.display == 'none') {
                document.getElementById(id).style.display = 'block';
                document.getElementById("label_"+id).innerHTML = 'cacher';
        } else {
                document.getElementById(id).style.display = 'none';
                document.getElementById("label_"+id).innerHTML = 'ajouter &agrave; votre site';
        }
}
