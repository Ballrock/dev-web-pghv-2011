/* 
	ED - 12.07.2006
	Fonction AddEvent de John Resig 
	http://ejohn.org/projects/flexible-javascript-events/
*/
 function addEvent( obj, type, fn ) {
   if ( obj.attachEvent ) {
     obj['e'+type+fn] = fn;
     obj[type+fn] = function(){obj['e'+type+fn]( window.event );}
     obj.attachEvent( 'on'+type, obj[type+fn] );
   } else
     obj.addEventListener( type, fn, false );
 }
 
 function removeEvent( obj, type, fn ) {
  if ( obj.detachEvent ) {
    obj.detachEvent( 'on'+type, obj[type+fn] );
    obj[type+fn] = null;
  } else
    obj.removeEventListener( type, fn, false );
}





var nomForm = "";

/* Affichage d'une image type plan d'accès */
function ouvrirFenetrePlan(url, nom) {
   window.open(url, nom, "width=520,height=500,scrollbars=yes, status=yes");
}

function showMessageField(typeAide, f1, f2) {
	showMessageField2(typeAide, f1, f2, '');
}

/* Demande d'affichage d'une fenetre par un champ */
function showMessageField2(typeAide, f1, f2, form) {
	numToolbox = '';
	nomForm = form;
	field1 = f1;
	field2 = f2;
	fieldRequete = '';
	texte = '';
	nomApplet = '';
	// Type d'insertion (liste)
	typeInsertion = '';

	//AM 200309 : L'arbre des structures doit prendre en compte la langue courante dans le front office
	if (typeAide.indexOf('structure') != -1) {

	   	var indexSlash1 = typeAide.indexOf('/');
		var lg = '';
		var filtre = '';
		if (indexSlash1 != -1)
		{
			var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
			if (indexSlash2 != -1)
			{
				lg = typeAide.substring(indexSlash1 + 1, indexSlash2);
				filtre = typeAide.substring(indexSlash2 + 1);
			}
			else
			{
				lg = typeAide.substring(indexSlash1 + 1);
			}
		}
		sList = window.open('/adminsite/menu/menu.jsp?MODE=STRUCTURE&LANGUE='+lg+'&FILTRE='+filtre, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	//JSS 20040419 : affichage arbre structure en fonction du perimetre (back-office)
	else if (typeAide.indexOf('strbo/') != -1) {

		// formatte comme suit strbo/type/objet/action/langue
		var indexSlash1 = typeAide.indexOf('/');
		var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
		var indexSlash3 = typeAide.indexOf('/', indexSlash2 + 1);
		var indexSlash4 = typeAide.indexOf('/', indexSlash3 + 1);
		var indexSlash5 = typeAide.indexOf('/', indexSlash4 + 1);

		var permission = typeAide.substring(indexSlash1+1, indexSlash4);
		var lg = typeAide.substring(indexSlash4+1, indexSlash5);
		var filtre = typeAide.substring(indexSlash5+1, typeAide.length);

		sList = window.open('/adminsite/menu/menu.jsp?MODE=STRUCTURE&PERMISSION='+permission+'&LANGUE='+lg+'&FILTRE='+filtre, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	//FBI 20051110 : affichage arbre structure en front (filtre sur les structures non visibles)
	else if (typeAide.indexOf('strfo') != -1) {

	   	var indexSlash1 = typeAide.indexOf('/');
		var lg = '';
		var filtre = '';
		if (indexSlash1 != -1)
		{
			var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
			if (indexSlash2 != -1)
			{
				lg = typeAide.substring(indexSlash1 + 1, indexSlash2);
				filtre = typeAide.substring(indexSlash2 + 1);
			}
			else
			{
				lg = typeAide.substring(indexSlash1 + 1);
			}
		}
		sList = window.open('/adminsite/menu/menu.jsp?MODE=STRUCTURE&LANGUE='+lg+'&FILTRE='+filtre+'&FRONT=true', 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	else if (typeAide == 'rubrique' || typeAide.indexOf('rubrique') != -1) {
		if (typeAide == 'rubrique') {
			 sList = window.open('/adminsite/menu/menu.jsp?MODE=RUBRIQUE', 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
		}
		else {
			 var lg = typeAide.substring(typeAide.indexOf('rubrique')+8,typeAide.length);
			 if (lg != null && lg.length > 0)
				 sList = window.open('/adminsite/menu/menu.jsp?MODE=RUBRIQUE&LANGUE='+lg, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
			 else
				 sList = window.open('/adminsite/menu/menu.jsp?MODE=RUBRIQUE', 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
		 }
	}
	//JSS 20040419 : affichage arbre rubrique en fonction du perimetre (back-office)
	else if (typeAide.indexOf('rubbo/') != -1)	{
		// formatte comme suit rubbo/type/objet/action

		var indexSlash1 = typeAide.indexOf('/');
		var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
		var indexSlash3 = typeAide.indexOf('/', indexSlash2 + 1);

		var permission = typeAide.substring(indexSlash1+1,typeAide.length);
		sList = window.open('/adminsite/menu/menu.jsp?MODE=RUBRIQUE&PERMISSION='+permission, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}
/* FBI : utiliser 'saisie_annuaire'
	else if (typeAide == 'annuaire') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_ANNUAIRE&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "annuaire2", "width=500,height=400,top=210,left=310,scrollbars=yes,resizable=yes, status=yes");
	}
*/
	else if (typeAide.indexOf('fichefil') != -1) {
		var proc = typeAide.substring(typeAide.indexOf('fichefil')+8,typeAide.length).toUpperCase();
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC="+proc+"&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE", "fichefil", "width=500,height=500,top=210,left=310,scrollbars=yes, status=yes");
	}

	else if (typeAide == 'pagelibre') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PAGELIBRE&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=0", "pagelibre", "width=500,height=330,top=210,left=310,scrollbars=yes, status=yes");
	}

	/* AM 200309 creation de page libre */
	else if (typeAide == ('pagelibre_creation')){
		 field2="LIBELLE_CODE_PAGE_TETE";
		 sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_PAGELIBRE&ACTION=AJOUTER&LANGUE=0&CODE_RUBRIQUE="+f2, "pagelibre_creation", "width=500,height=330,top=210,left=310,scrollbars=yes, status=yes");
	}

	// JSS 20040419 : arbre des groupes
	else if (typeAide == 'groupe_dsi') {
		sList = window.open('/adminsite/menu/menu.jsp?MODE=GROUPE', 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320,resizable=yes,status=yes');
	}

	//JSS 20040419 : affichage arbre groupe en fonction du perimetre (back-office)
	else if (typeAide.indexOf('groupebo/') != -1)	{
		// formatte comme suit groupebo/type/objet/action

		var indexSlash1 = typeAide.indexOf('/');
		var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
		var indexSlash3 = typeAide.indexOf('/', indexSlash2 + 1);

		var permission = typeAide.substring(indexSlash1+1,typeAide.length);
		sList = window.open('/adminsite/menu/menu.jsp?MODE=GROUPE&PERMISSION='+permission, 'menu2', 'scrollbars=yes,,resizable=yes,width=350,height=210,top=320,left=320, resizable=yes,status=yes');
	}

	else if (typeAide == 'public_vise_dsi') {
		sList = window.open('/adminsite/menu/menu.jsp?MODE=GROUPE&PUBLIC_VISE=1', 'menu2', 'scrollbars=yes,width=420,height=210,top=320,left=320, resizable=yes,status=yes');
	}

	// JSS 20040419 : arbre des groupes
	else if (typeAide.indexOf('publicbo/') != -1)	{
		// formatte comme suit publicbo/type/objet/action

		var indexSlash1 = typeAide.indexOf('/');
		var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
		var indexSlash3 = typeAide.indexOf('/', indexSlash2 + 1);

		var permission = typeAide.substring(indexSlash1+1,typeAide.length);
		sList = window.open('/adminsite/menu/menu.jsp?MODE=GROUPE&PUBLIC_VISE=1&PERMISSION='+permission, 'menu2', 'scrollbars=yes,width=420,height=210,top=320,left=320, resizable=yes,status=yes');
	}

	else if (typeAide == 'utilisateur') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=RECHERCHE_UTILISATEUR&ACTION=RECHERCHER", "annuaire2", "width=450,height=500,top=210,left=290,scrollbars=yes,resizable=yes,status=yes");
	}
/* FBI : utiliser 'saisie_formation'
	else if (typeAide == 'formation') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_FORMATION&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "formation", "width=500,height=330,top=150,left=150,scrollbars=yes, status=yes");
	}
/* FBI : utiliser 'saisie_ueup'
	else if (typeAide == 'ueup') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_UEUP&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "ueup", "width=500,height=330,top=150,left=150,scrollbars=yes, status=yes");
	}
*/
	else if (typeAide == 'parcours') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_UEUP&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&TYPE=PARCOURS&LANGUE_ARTICLE=-1", "parcours", "width=500,height=330,top=150,left=150,scrollbars=yes, status=yes");
	}

	else if (typeAide.indexOf('parcoursM') != -1) {
		var codeUe = typeAide.substring(9);
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_PARCOURS&ACTION=MODIFIER&CODE_UEUP_PARCOURS="+codeUe+"&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "parcours", "width=500,height=330,top=150,left=150,scrollbars=yes, status=yes");
	}
/* FBI : utiliser 'saisie_cours'
	else if (typeAide == 'cours') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_COURS&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "ueup", "width=500,height=330,top=150,left=150,scrollbars=yes, status=yes");
	}
*/
	else if (typeAide == 'photo') {
		indice='';
		if (f1=='' && f2=='')
		{
			indice = window.document.forms[indiceForm].NB_FICHIER_JOINT.value;
			eval('window.document.forms[indiceForm].NO_FICHIER_JOINT.value = '+indice+'');
		}
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PHOTO&ACTION=RECHERCHER&MODE_PHOTOTHEQUE=SELECTION&NO_FICHIER_JOINT="+indice, "photo", "width=650,height=535,top=20,left=100,scrollbars=yes, status=yes");
	}

	else if (typeAide == 'image') {
       sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PHOTO&ACTION=RECHERCHER&MODE_PHOTOTHEQUE=SAISIE", "photo", "width=650,height=535,top=20,left=100,scrollbars=yes, status=yes");
	}

	else if (typeAide == 'document') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_DOCUMENT&ACTION=INSERER", "document", "width=400, height=200, top=20, left=100, scrollbars=yes, status=yes, status=yes");
	}

	else if (typeAide == 'documentfront') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_DOCUMENT_FRONT&ACTION=INSERER&SAISIE_FRONT=true", "document", "width=400, height=130, top=20, left=100, scrollbars=yes, status=yes");
	}
/* FBI : 20060109 : @deprecated
	else if (typeAide == 'evenements')
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_EVENEMENTS&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "evenements", "width=350,height=300,top=150,left=150,scrollbars=yes, status=yes");
*/
/* FBI : utiliser 'saisie_actualite'
	else if (typeAide == 'actualites') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_ACTUALITE&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "actualites", "width=400,height=380,top=150,left=150,scrollbars=yes, status=yes");
	}
/* FBI : 20060109 : @deprecated
	else if (typeAide == 'sites')
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_SITESLIEUX&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "sites", "width=350,height=300,top=150,left=150,scrollbars=yes, status=yes");
*/
	else if (typeAide == 'pagetete') {
		sList = window.open("/adminsite/toolbox/choix_objet.jsp?TOOLBOX=PAGE_TETE", "list", "width=500,height=330,top=100,left=100,scrollbars=yes,status=yes");
		pageTete = true;
	}

	else if (typeAide == 'commentaire') {
    		sList = window.open("/adminsite/toolbox/choix_objet.jsp?TOOLBOX=COMMENTAIRE", "list", "width=500,height=330,top=100,left=100,scrollbars=yes,status=yes");
		pageTete = true;
	}

	else if (typeAide == 'requete') {
		field1 = "";
		field2 = f2;
		nomForm = "";
		fieldRequete = f1;

		if (field2 == 'STATS') {
			field2 = "";
			sList = window.open("/adminsite/toolbox/choix_objet.jsp?TOOLBOX=LIEN_REQUETE&RESTRICTION=STATS", "list", "width=500,height=330,top=100,left=100,scrollbars=yes,status=yes");
		}
		else {
			field2 = "";
			sList = window.open("/adminsite/toolbox/choix_objet.jsp?TOOLBOX=LIEN_REQUETE&RESTRICTION=XML", "list", "width=500,height=330,top=100,left=100,scrollbars=yes,status=yes");
		}
	}
}


/* Traitement des donnees resultats renvoyees par la fenetre mere */
function saveField(objet, code, libelle) {

	/* Cas de l'administration */
	if (inBackOffice())	{
		if (!pageTete) {
				/* Cas de l'administration */
				if (field1 != "")
					eval( "window.document.forms[0]."+field1+".value = code;");
				if (field2 != "")
					eval( "window.document.forms[0]."+field2+".value = libelle;");
				
				//AM 200501: parcours LMD
				if(ajoutAuto != ""){
					eval("ajouter"+ajoutAuto+"();");
					ajoutAuto = "";
				}
				//AM 200501: parcours LMD
				if(modifAuto != ""){
					eval("validmodif"+modifAuto+"();");
					modifAuto = "";
				}
				
			}else{
				/* Cas d'une page de tete : on ajoute le type d'objet au code*/
				if (field1 != "")
					eval( "window.document.forms[0]."+field1+".value = code+',TYPE='+objet;");
				if (field2 != "")
					eval( "window.document.forms[0]."+field2+".value = objet + ' : ' +libelle;");
			}

	} else	{
		/* Cas particulier du WEB */
			var formCourant = "RECHERCHE_WEB";
			if( nomForm.length > 0)
				formCourant = nomForm;

		if (field1 != "")
			eval( "window.document."+formCourant+"."+field1+".value = code;");
		if (field2 != "")
			eval( "window.document."+formCourant+"."+field2+".value = libelle;");
	}
	
	if( fieldRequete != "") {
		chaine = "\"OBJET="+objet;
		if( code.length > 0)
		{
			chaine = chaine +"&"+code;
		}
		chaine = chaine +"\"";

		eval( "window.document.forms[0]."+fieldRequete+".value = "+ chaine );
	}

  field1 = "";
  field2 = "";

  nomForm = "";

  fieldRequete = "";

  numToolbox = "";

  texte = "";

  nomApplet = "";
  
  // JSS 20020612-001 Type d'insertion (liste)
  typeInsertion="";	
	
}


function inBackOffice () {

	for (i = 0; i < window.document.forms.length; i++)	{
		if ( (window.document.forms[i].name == 'RECHERCHE_WEB' || window.document.forms[i].name == nomForm )
			&& window.document.forms[i].name != "")
			return false;
	}
	return true;
}


/* Affichage d'un calendrier pour les formulaires avec recherche par date */
function affiche_calendrier(nom, form) {
	if (document.getElementById) {
		document.write("<a href=\"#\" onclick=\"window.open('/adminsite/calendrier/calendrierjs.html?champ=" + nom + "&form=" + form +"', 'calendrier', 'width=135, height=138, toolbar=no, location=no, status=yes, resizable=yes'); return false;\"><img src=\"/images/calendrier.png\" border=\"0\"></a>");
	}
}


/* Effacement du libelle d'un champ de recherche */
function effacerTextField (zoneSaisie, zoneLibelle, value, libelle)	{

	if (inBackOffice() )	{
		/* Cas de l'administration */
		eval( "window.document.forms[0]."+zoneSaisie+".value = value;");
		eval( "window.document.forms[0]."+zoneLibelle+".value = libelle;");
	} else	{
		eval( "window.document.RECHERCHE_WEB."+zoneSaisie+".value = value;");
		eval( "window.document.RECHERCHE_WEB."+zoneLibelle+".value = libelle;");
	}
}

/* Activation du service selectionné dans la liste des services */
function activerService() {

	var index = window.document.getElementById('selectservices').selectedIndex;
	if( index == 0)
		return;
	var url = window.document.getElementById('selectservices').options[index].value;

	/* Analyse target */
	var indexTarget = url.indexOf(';');
	if (indexTarget > 0) {
		var target =  url.substring(0,indexTarget);
		url = url.substring(indexTarget + 1);
		window.open(url, target);
	} else {
		window.location.href=url.substring(1);
	}
}

/* Affichage d'une image dans une popup */
function afficheImage(source) {
	// Ouverture du pop-up
	window.open(source,'pop','status=no,directories=no,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');
}

function atteindreAncre(ancre) {
	if (ancre != 'null'){
		window.location.href += '#' + ancre;
	}
}

/* Fonction utilisée dans la recherche avancée pour réinitialiser les formulaires */
function viderFormulaire(criteres) {
	criteres = criteres.split(";");
	var champReinit = "";
	var valeurChamp = "";
	
	for (var i=0; i < (criteres.length); i++) {
		champReinit = eval("document.RECHERCHE_WEB." + criteres[i].substring(0, criteres[i].indexOf("=")));
		valeurChamp = criteres[i].substring(criteres[i].indexOf("=")+1);
		
		champReinit.value = valeurChamp
	}
}


function afficherBoutonImprimer(intitule) {
	document.write('<span id="imprimer" onclick="window.print(); return false;">' + intitule + '</span>');
}

/* fonction permettant d'afficher ou de cacher un element par id (specific à la fiche formation) */
function montrerCacher_div(intitule) {
	var oDiv = document.getElementById(intitule);
	var oSpan =  document.getElementById(intitule + '_s');
	var blksem = intitule.substr(0,6);
	
	if (oDiv != null){
		if (oDiv.style.display == 'none'){
			oDiv.style.display = 'block';
			if (oSpan != null){
				
				if (blksem == 'blksem'){
					oSpan.className = 'titre_ouvert_vert';
				} else {
					oSpan.className = 'titre_ouvert';
				}
				oSpan.title='Masquer les infos';
			}
		} else if (oDiv.style.display == 'block'){
			oDiv.style.display = 'none';
			if (oSpan != null){
				if (blksem == 'blksem'){
					oSpan.className = 'titre_cache_vert';
				} else {
					oSpan.className = 'titre_cache';
				}
				oSpan.title='Afficher les infos';
			}
		}
		
	}
}

/*
 * Cache tous les divs ayant le même préfixe
 */
 function closeOpenAll() {
	 var ouverture = true;
	 var verifEtat = document.getElementById('tout_derouler');
	 if (verifEtat !=null ){
		 if (verifEtat.className == 'tout_derouler'){
			 ouverture = true;
		 } else {
			 ouverture = false;
		 } 
		 var contenu_deco = document.getElementById('contenu_deco');
	
	   	 // on prend tous les fils 
	   	 var filsContenu_deco = contenu_deco.getElementsByTagName("*");
	   	 if (ouverture == true){
			 for(var i=0; i<filsContenu_deco.length; i++){
				if (filsContenu_deco[i].className == 'cache' || filsContenu_deco[i].className == 'ouvert' ){
					filsContenu_deco[i].style.display = 'block';
					filsContenu_deco[i].className = 'ouvert';
					
					
				} 
				if (filsContenu_deco[i].className == 'titre_cache'){
					filsContenu_deco[i].className = 'titre_ouvert'
					filsContenu_deco[i].title = 'Masquer les infos';
				}
				verifEtat.className = 'tout_fermer';
				verifEtat.innerHTML = 'Masquer toutes les infos';
				verifEtat.title = 'Masquer toutes les infos';
			 }
	   	 } else {
	   		 for(var i=0; i<filsContenu_deco.length; i++){
				 if (filsContenu_deco[i].className == 'cache' || filsContenu_deco[i].className == 'ouvert' ){
					filsContenu_deco[i].style.display = 'none';
					filsContenu_deco[i].className = 'cache';
				}
				 if (filsContenu_deco[i].className == 'titre_ouvert'){
						filsContenu_deco[i].className = 'titre_cache';
						filsContenu_deco[i].title = 'Afficher les infos';
				}
				 verifEtat.className = 'tout_derouler';
				 verifEtat.innerHTML = 'Afficher toutes les infos';
				 verifEtat.title = 'Afficher toutes les infos';
			 }
	   	 }
	 }
  }
 
 /* fonction permettant d'affiche une combo specific à la rechercher fiche formation */
 function affiner_recherche() {
	 var oAffinerRech2 = document.getElementById('affiner_recherche_2');
	 var oAffinerRech3 = document.getElementById('affiner_recherche_3');
	 
 	if (oAffinerRech2 != null && oAffinerRech2.style.display == 'none'){
 		oAffinerRech2.style.display = 'block';
 	} else if (oAffinerRech3 != null && oAffinerRech3.style.display == 'none'){
 		oAffinerRech3.style.display = 'block';
	} else {
		alert('3 débouchés naturels maximum')
	}
 		
}

 
