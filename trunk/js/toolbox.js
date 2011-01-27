var field1 = "";
var field2 = "";
var fieldRequete = "";
var texte = "";
var nomApplet = "";
var nomForm = "";
var pageTete = false;
//AM200501 : parcours LMD
var ajoutAuto="", modifAuto="";

// JSS 20020612-001 Type d'insertion (liste)
var typeInsertion="";

/* ouverture d'une fenêtre centrée */
function ouvrirPhoto(urlPhoto,largeur,hauteur) {
  x = (screen.availWidth - largeur)/2;
  y = (screen.availHeight - 30 - hauteur)/2;
  attrs = "height="+ hauteur +", width="+ largeur +", left="+ x +", top="+ y;
  if (y<0)
  {
	 attrs += ",scrollbars=yes"
  }
  fenetre = window.open(urlPhoto,'photo',attrs);
}

/* Demande d'affichage d'une fenetre au niveau du front office */
function ouvrirFenetrePlan(url, nom) {
   window.open(url, nom, "width=520,height=500,scrollbars=yes, status=yes, resizable=1");
}

/* Affichage de la phototheque */
function showPhototheque( ) {
        //EL 20051221 rajout resizable=yes
   window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PHOTO&ACTION=RECHERCHER&MODE_PHOTOTHEQUE=ADMINISTRATION", "photo", "width=650,height=535,top=20,left=100,scrollbars=yes, status=yes,resizable=yes");
}


function showMessageField(typeAide, f1, f2) {
	showMessageField2(typeAide, f1, f2, '');
}

/* Demande d'affichage d'une fenetre par un champ */
function showMessageField2(typeAide, f1, f2, form) {
	nomForm = form;
	field1 = f1;
	field2 = f2;
	fieldRequete = '';
	texte = '';
	nomApplet = '';
	// Type d'insertion (liste)
	typeInsertion = '';

	var oForm;
	if (inBackOffice())	{
		oForm = document.forms[0];
	}
	else {
		if (form.length > 0) {
			oForm = document.forms[form];
		}
		else {
			oForm = document.forms['RECHERCHE_WEB'];
		}
	}
	var value = oForm.elements[f1].value;
	if (!value)
           value="";

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
		sList = window.open('/adminsite/menu/menu.jsp?MODE=STRUCTURE&CODE='+value+'&LANGUE='+lg+'&FILTRE='+filtre, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
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

		sList = window.open('/adminsite/menu/menu.jsp?MODE=STRUCTURE&CODE='+value+'&PERMISSION='+permission+'&LANGUE='+lg+'&FILTRE='+filtre, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
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
		sList = window.open('/adminsite/menu/menu.jsp?MODE=STRUCTURE&CODE='+value+'&LANGUE='+lg+'&FILTRE='+filtre+'&FRONT=true', 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	else if (typeAide == 'rubrique' || typeAide.indexOf('rubrique') != -1) {
		var lg = '';
		var racine = '';
		if (typeAide != 'rubrique') {
			var indexSlash = typeAide.indexOf('/');
			if (indexSlash != -1) { //typeAide du type rubrique/racine ou rubriquelangue/racine
				racine = typeAide.substring(indexSlash + 1, typeAide.length);
				lg = typeAide.substring(typeAide.indexOf('rubrique')+8, indexSlash);
			}
			else { //typeAide du type rubriquelangue
				lg = typeAide.substring(typeAide.indexOf('rubrique')+8, typeAide.length);
			}
		}
		sList = window.open('/adminsite/menu/menu.jsp?MODE=RUBRIQUE&CODE='+value+'&LANGUE='+lg+'&RACINE='+racine, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	//JSS 20040419 : affichage arbre rubrique en fonction du perimetre (back-office)
	else if (typeAide.indexOf('rubbo/') != -1)	{
		// formatte comme suit rubbo/type/objet/action

		var indexSlash1 = typeAide.indexOf('/');
		var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
		var indexSlash3 = typeAide.indexOf('/', indexSlash2 + 1);
		var indexSlash4 = typeAide.indexOf('/', indexSlash3 + 1);

		var permission = '';
		var racine = '';
		if( indexSlash3 != -1 ){ //typeAide du type rubbo/FICHE/OO15/C/racine
			permission = typeAide.substring(indexSlash1+1,indexSlash4);
			racine = typeAide.substring(indexSlash4+1,typeAide.length);
		}
		else if( indexSlash2 != -1) { //typeAide du type rubbo//racine
			permission = typeAide.substring(indexSlash1+1,indexSlash2);
			racine = typeAide.substring(indexSlash2+1,typeAide.length);
		}
		else {
			permission = typeAide.substring(indexSlash1+1,typeAide.length);
		}

		sList = window.open('/adminsite/menu/menu.jsp?MODE=RUBRIQUE&CODE='+value+'&PERMISSION='+permission+'&RACINE='+racine, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	// JSS 20040419 : arbre des groupes
	else if (typeAide == 'groupe_dsi') {
		sList = window.open('/adminsite/menu/menu.jsp?MODE=GROUPE&CODE='+value, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	//JSS 20040419 : affichage arbre groupe en fonction du perimetre (back-office)
	else if (typeAide.indexOf('groupebo/') != -1)	{
		// formatte comme suit groupebo/type/objet/action

		var indexSlash1 = typeAide.indexOf('/');
		var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
		var indexSlash3 = typeAide.indexOf('/', indexSlash2 + 1);

		var permission = typeAide.substring(indexSlash1+1,typeAide.length);
		sList = window.open('/adminsite/menu/menu.jsp?MODE=GROUPE&CODE='+value+'&PERMISSION='+permission, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	else if (typeAide == 'public_vise_dsi') {
		sList = window.open('/adminsite/menu/menu.jsp?MODE=GROUPE&CODE='+value+'&PUBLIC_VISE=1', 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	// JSS 20040419 : arbre des groupes
	else if (typeAide.indexOf('publicbo/') != -1) {
		// formatte comme suit publicbo/type/objet/action

		var indexSlash1 = typeAide.indexOf('/');
		var indexSlash2 = typeAide.indexOf('/', indexSlash1 + 1);
		var indexSlash3 = typeAide.indexOf('/', indexSlash2 + 1);

		var permission = typeAide.substring(indexSlash1+1,typeAide.length);
		sList = window.open('/adminsite/menu/menu.jsp?MODE=GROUPE&CODE='+value+'&PUBLIC_VISE=1&PERMISSION='+permission, 'menu2', 'scrollbars=yes, resizable=yes, status=yes, width=600, height=400, top=320, left=320');
	}

	else if (typeAide.indexOf('fichefil') != -1) {
		var proc = typeAide.substring(typeAide.indexOf('fichefil')+8,typeAide.length).toUpperCase();
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC="+proc+"&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE", "fichefil", "width=500,height=500,top=210,left=310,scrollbars=yes, resizable=yes, status=yes");
	}

	else if (typeAide == 'pagelibre') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PAGELIBRE&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=0", "pagelibre", "width=500,height=330,top=210,left=310, scrollbars=yes, resizable=yes, status=yes");
	}

	/* AM 200309 creation de page libre */
	else if (typeAide == ('pagelibre_creation')){
		 field2="LIBELLE_CODE_PAGE_TETE";
		 sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_PAGELIBRE&ACTION=AJOUTER&LANGUE=0&CODE_RUBRIQUE="+f2, "pagelibre_creation", "width=500,height=330,top=210,left=310, scrollbars=yes, resizable=yes, status=yes");
	}

	else if (typeAide == 'utilisateur') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_UTILISATEUR&ACTION=RECHERCHER&MODE=RECHERCHE", "utilisateur", "width=550, height=500, top=210, left=290, scrollbars=yes, resizable=yes, status=yes");
	}

	else if (typeAide == 'phototheque') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PHOTO&ACTION=RECHERCHER&MODE_PHOTOTHEQUE=PHOTOTHEQUE", "photo", "width=650,height=535,top=20,left=100, scrollbars=yes, resizable=yes, status=yes");
	}

	else if (typeAide == 'photo') {
		indice='';
		if (f1=='' && f2=='')
		{
			indice = window.document.forms[indiceForm].NB_FICHIER_JOINT.value;
			eval('window.document.forms[indiceForm].NO_FICHIER_JOINT.value = '+indice+'');
		}
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PHOTO&ACTION=RECHERCHER&MODE_PHOTOTHEQUE=SELECTION&NO_FICHIER_JOINT="+indice, "photo", "width=650,height=535,top=20,left=100, scrollbars=yes, resizable=yes, status=yes");
	}

	else if (typeAide == 'image') {
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PHOTO&ACTION=RECHERCHER&MODE_PHOTOTHEQUE=SAISIE", "photo", "width=650,height=535,top=20,left=100, scrollbars=yes, resizable=yes, status=yes");
	}

	else if (typeAide == 'pagetete') {
		sList = window.open("/adminsite/toolbox/choix_objet.jsp?TOOLBOX=PAGE_TETE", "list", "width=520,height=440,top=10,left=100, scrollbars=yes, resizable=yes, status=yes");
		pageTete = true;
	}

	else if (typeAide == 'commentaire') {
    		sList = window.open("/adminsite/toolbox/choix_objet.jsp?TOOLBOX=COMMENTAIRE", "list", "width=500,height=330,top=100,left=100, scrollbars=yes, resizable=yes, status=yes");
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

/* Demande d'affichage d'une fenetre par un champ en front */

function showMessageChamp(typeAide, f1, f2, nomFormulaire)
{
	if (typeAide.indexOf('structure') != -1)
	{
		 typeAide = 'strfo' + typeAide.substring(typeAide.indexOf('structure')+9, typeAide.length);
	}
	showMessageField2 (typeAide, f1, f2, nomFormulaire);
}


/* Ouvre la popup de recherche d'un objet */
function ouvrirFenetreRechercheParProcessus(processus, f1, f2) {
	field1 = f1;
	field2 = f2;
	nomForm = "";
	fieldRequete = "";
	texte = "";
	nomApplet = "";
	typeInsertion="";
	nomFenetre ="";
	if (processus.indexOf('&')!=-1)
	{
		nomFenetre = processus.substring(0,processus.indexOf('&'));
	}
	sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC="+processus+"&ACTION=RECHERCHER&TOOLBOX=LIEN_INTERNE&LANGUE_ARTICLE=-1", "RECHERCHE_"+nomFenetre, "width=500, height=330, top=150, left=150, scrollbars=yes, resizable=yes, status=yes");
}


/* Demande d'affichage d'une fenetre par un textarea */
function showMessageTextArea (typeAide, langue, toolboxName) {
	
	nomApplet = "";
	// JSS 20020612-001 Type d'insertion (liste)
	typeInsertion="";
	texte = toolboxName;
	field1 = "";
	field2 = "";
	nomForm = "";
	fieldRequete = "";

	// JSS 20020612-001 Type d'insertion (liste)
	if (typeAide == 'liste') {
		sList =  window.open("/adminsite/toolbox/choix_objet.jsp?TOOLBOX=LIEN_REQUETE&LISTE_INCLUSE=1", "list", "width=500,height=330,top=100,left=100,scrollbars=yes,status=yes");
		typeInsertion = "liste";
	}

	if (typeAide == 'lien')
		sList = window.open("/adminsite/toolbox/choix_lien.jsp?LANGUE_ARTICLE="+langue, "list", "width=500,height=330,top=100,left=100,scrollbars=yes,status=yes");
	if (typeAide == 'mailto')
		sList = window.open("/adminsite/toolbox/mailto.jsp?LANGUE_ARTICLE="+langue, "list", "width=500,height=330,top=100,left=100,scrollbars=yes,status=yes");
	if (typeAide == 'image')
		sList = window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=SAISIE_PHOTO&ACTION=RECHERCHER&MODE_PHOTOTHEQUE=INSERTION", "photo", "width=650,height=535,top=20,left=100,scrollbars=yes");
}


function inBackOffice() {

	for (i = 0; i < window.document.forms.length; i++)	{
		if ( (window.document.forms[i].name == 'RECHERCHE_WEB' || window.document.forms[i].name == nomForm )
			&& window.document.forms[i].name != "")
			return false;
	}
	return true;
}


// JSS 20020612-001 Type d'insertion (liste)
/* Remplacement des & par des # (plantage NetWord) */
function conversionRequete (objet,  code)	{

	do	{
	  i =  code.indexOf('&');
	  if (i != -1)	{
		code = code.substring(0,i) + "#" + code.substring(i+1, code.length);
	  }
	}
	while (i != -1);

	param = "objet="+objet;
	if (code.length > 0)
	   param = param + "#" + code;

	return param;


}

/* Effacement du libelle d'un champ de recherche */
function effacerTextField (zoneSaisie, zoneLibelle, value, libelle)	{

	if (inBackOffice()) {
		/* Cas de l'administration */
		eval( "window.document.forms[0]."+zoneSaisie+".value = value;");
		eval( "window.document.forms[0]."+zoneLibelle+".value = libelle;");
		eval( "window.document.forms[0]."+zoneLibelle+".title = '';");
	}
	else {
		eval( "window.document.RECHERCHE_WEB."+zoneSaisie+".value = value;");
		eval( "window.document.RECHERCHE_WEB."+zoneLibelle+".value = libelle;");
		eval( "window.document.RECHERCHE_WEB."+zoneLibelle+".title = '';");
	}
}

/* Effacement du libelle d'un champ de recherche */
function effacerTextChamp( zoneSaisie, zoneLibelle, value, libelle, nomForm)	{
		eval( "window.document."+nomForm+"."+zoneSaisie+".value = value;");
		eval( "window.document."+nomForm+"."+zoneLibelle+".value = libelle;");
}

/* Renvoyer des valeurs a la fenetre fille */
function renvoyerNewLien(nouveauLien)	{

	window.opener.modifieLien(nouveauLien);
	window.close();

}

/* Renvoyer des valeurs a la fenetre fille */
function renvoyerValeurs(objet, code, libelle, sInfobulle)
{
	if (window.opener && ! window.opener.closed)
	{
		// cas d'une modification de lien
		if (window.opener.liendanskt)
		{
			window.opener.modifieLien(objet, code, libelle);
		}
		// cas d'un rattachement rubrique par exemple
		else if (window.opener.field1 != "" || window.opener.field2 != "" || window.opener.fieldRequete != "")
		{
			window.opener.saveField(objet, code, libelle, sInfobulle);
		}
		// cas d'un lien dans la toolbox
		else
		{
			window.opener.save(objet, code, libelle); // tag kportal dans la toolbox
		}
	}
	window.close();
}

/* Traitement des donnees resultats renvoyees par la fenetre mere */
function saveField(objet, code, libelle, sInfobulle) {

	/* Cas de l'administration */
	if (inBackOffice())	{
		if (! pageTete) {
			/* Cas de l'administration */
			if (field1 != "")
				eval( "window.document.forms[0]."+field1+".value = code;");
			if (field2 != "")
			{
				var oLabelField = window.document.forms[0].elements[field2];
				oLabelField.value = libelle;
				oLabelField.title = (sInfobulle ? sInfobulle : libelle);
			}

			/*AM 200501: parcours LMD
			if (ajoutAuto != "") {
				eval("ajouter"+ajoutAuto+"();");
				ajoutAuto = "";
			}
			//AM 200501: parcours LMD
			if (modifAuto != "") {
				eval("validmodif"+modifAuto+"();");
				modifAuto = "";
			}*/
		}
		else {
			/* Cas d'une page de tete : on ajoute le type d'objet au code */
			if (field1 != "")
				eval( "window.document.forms[0]."+field1+".value = code+',TYPE='+objet;");
			if (field2 != "")
				eval( "window.document.forms[0]."+field2+".value = objet + ' : ' +libelle;");
		}
	}
	else {
		/* Cas particulier du WEB */
			var formCourant = "RECHERCHE_WEB";
			if( nomForm.length > 0)
				formCourant = nomForm;

		if (field1 != "")
			eval( "window.document."+formCourant+"."+field1+".value = code;");
		if (field2 != "")
		{
			var oLabelField = window.document.forms[formCourant].elements[field2];
			oLabelField.value = libelle;
			/*if (sFilAriane)
			{
				oLabelField.title = sFilAriane;
			}*/
			oLabelField.title = (sInfobulle ? sInfobulle : libelle);
		}
	}
	
	if (fieldRequete != "") {
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

	texte = "";

	nomApplet = "";

	// JSS 20020612-001 Type d'insertion (liste)
	typeInsertion="";	
	
	pageTete = false;
}

/* Renvoyer des valeurs a la fenetre fille */
function renvoyerImage(id, height, width, alt, border, hspace, vspace, align)
{
	if (window.opener && ! window.opener.closed)
	{
		window.opener.renvoyerImagePopup( id, height, width, alt, border, hspace, vspace, align)
	}
	window.close();
}

function renvoyerFormulaire(code, style,element)
{
	if (window.opener && !window.opener.closed && window.opener.nomApplet != "")
	{
		window.opener.saveFormulaire(code,style,element);
	}	
	window.close();
}


function renvoyerPageLibre(code, titre, langue) {
	if (window.opener && !window.opener.closed)
		window.opener.savePageLibre(code, titre, langue);
	window.close();
}

function renvoyerDocument(id, titre, NOM_FICHIER_JOINT, POIDS_FICHIER_JOINT, FORMAT_FICHIER_JOINT, PATH_FICHIER_JOINT, NOMFORM)
{
	if (window.opener && ! window.opener.closed)
	{
		if (window.opener.liendanskt)
			window.opener.modifieLien("", id, "");
		else if (window.opener.nomApplet != "")
			window.opener.saveDocument(id, titre, NOM_FICHIER_JOINT, POIDS_FICHIER_JOINT, FORMAT_FICHIER_JOINT, PATH_FICHIER_JOINT, NOMFORM);
		else
			window.opener.saveFormDocument(id, titre, NOM_FICHIER_JOINT, POIDS_FICHIER_JOINT, FORMAT_FICHIER_JOINT, PATH_FICHIER_JOINT, NOMFORM);
	}
	window.close();
}

function saveFormDocument(id, titre, NOM_FICHIER_JOINT, POIDS_FICHIER_JOINT, FORMAT_FICHIER_JOINT, PATH_FICHIER_JOINT, NOMFORM)	{
	var nomForm = '0';
	if (NOMFORM)
		nomForm=NOMFORM;

	if (field1 != "") {
  		eval( "window.document.forms['"+nomForm+"']."+field1+".value = id;");
  		eval( "window.document.forms['"+nomForm+"']."+field2+".value = titre;");
  		eval( "window.document.forms['"+nomForm+"'].NOM_"+field1+".value = NOM_FICHIER_JOINT;");
  		eval( "window.document.forms['"+nomForm+"'].POIDS_"+field1+".value = POIDS_FICHIER_JOINT;");
  		eval( "window.document.forms['"+nomForm+"'].FORMAT_"+field1+".value = FORMAT_FICHIER_JOINT;");
  		eval( "window.document.forms['"+nomForm+"'].PATH_"+field1+".value = PATH_FICHIER_JOINT;");
	}

	if( texte != "") {
		var codeHtml = '<a';

		codeHtml += " href=\"[id-document];"+id+"[/id-document]\" >";
		codeHtml += titre+"</a>";

		insererTexte( texte, codeHtml);
	}

	field1 = "";
	field2 = "";
	nomForm = "";
	fieldRequete = "";
	texte = "";
	nomApplet = "";
}


/* Ouverture d'une nouvelle fenetre fille */
function ouvrir_fen (url) {

	Xmas95 =new Date();
	secs = Xmas95.getSeconds();
	var name = "win" + secs;
        //EL 20051221 rajout resizable=yes pour IE :
	window.open(url,name,'status=yes,toolbar=no,scrollbars=yes,width=600,height=550,resizable=yes');
}

function ouvrir_fen_web (url) {

	Xmas95 =new Date();
	secs = Xmas95.getSeconds();
	var name = "win" + secs;

	window.open(url,name,'status=yes,menubar=yes, toolbar=yes, resizable=yes, scrollbars=yes, width=600, height=400');
}

function ouvrir_fen_x_y (url, x, y) {

	Xmas95 =new Date();
	secs = Xmas95.getSeconds();
	var name = "win" + secs;

	window.open(url,name,'resizable=yes,status=yes,toolbar=no,scrollbars=yes,width='+x+',height='+y);
}

function ouvrir_fen_w_h_name(url, width, height, name){
	window.open(url,name,'status=yes,toolbar=no,scrollbars=yes,width='+width+',height='+height);
}


 /* Nettoyage du code HTML avant de l'envoyer dans l'url */
function nettoyerCodeHTML ( s) {

	/* Suppression des caracteres dont code > 255 : fait planter url 
	   (peuvent etre inseres par coller)
	*/
	s2 = s;
	for (i=0; i<s2.length;i++){
		var charCode = s2.charCodeAt ( i);
		if ( charCode > 255) {

			// Traitement special pour caractere 8217
			if( charCode == 8217)
				s2 = s2.substring( 0, i) + "'" + s2.substring( i+1, s2.length);
			else if( charCode == 8364)
				s2 = s2.substring( 0, i) + "&euro;" + s2.substring( i+1, s2.length);
			else if( charCode == 8211)
				s2 = s2.substring( 0, i) + "-" + s2.substring( i+1, s2.length);
			else if( charCode == 8230)
				s2 = s2.substring( 0, i) + "..." + s2.substring( i+1, s2.length);			
			else if( charCode == 339) 
				s2 = s2.substring( 0, i) + "&oelig;" + s2.substring( i+1, s2.length);
			else
				s2 = s2.substring( 0, i) + s2.substring( i+1, s2.length);

			//JSS 20020923-001
			i=i-1;
		}
	}
	if (s2 == '<p>&nbsp;</p>' || s2 == '<br />')
	{
		s2 = '';
	}
	return s2;
}


// RP 20041611 ajout fonctions collaboratif 

/* Gestion des fichiers joints */
var arrayFichiergw = new Array(); 
var arrayFichierJointUnique = new Array();
var modeFichier = "";
var espace = "";
var indiceForm = "";

// constructeur de la classe
function Fichiergw(p1, p2, p3, p4, p5, p6)
{
	this.id = p1;
	this.nom = p2;
	this.format = p3;
	this.version = p4;
	this.date = p5;
	this.poids = p6;
}

// ajout d'un fichier
// appel du processus TRAITEMENT_FICHIERGW_FRONT
function ajouterFichiergw(indice,saisieFront)
{
	if (saisieFront==null)
		 saisieFront= '';

	if (indice && indice!=''){
		eval( "window.document.forms[0].NO_FICHIER_JOINT.value = "+indice+"");
	}
	else{
		indice = window.document.forms[indiceForm].NB_FICHIER_JOINT.value;
		eval('window.document.forms[indiceForm].NO_FICHIER_JOINT.value = '+indice+'');
	}
	if (modeFichier.indexOf('document') !=-1){
		window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_FICHIERGW_FRONT&ACTION=INSERER"+saisieFront+"&NO_FICHIER_JOINT="+indice+"&MODE="+modeFichier+"&ESPACE="+espace+"", "fichiergw", "width=600, height=300, resizable=yes, scrollbars=yes, status=no");
	}
	else{
		window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_FICHIERGW_FRONT&ACTION=INSERER"+saisieFront+"&NO_FICHIER_JOINT="+indice+"&MODE="+modeFichier+"&ESPACE="+espace+"", "fichiergw", "width=600, height=300, resizable=yes, scrollbars=yes, status=no");
	}
}

// suppression d'un fichier uniquement javascript
// traitement physique a la validation
function supprimerFichiergw(indice){
	reponse=confirm("Supprimer définitivement le fichier?");
	if (reponse){
		
		//mise à jour du poids total des fichiers ajoutés
		if( window.document.forms[indiceForm].POIDS_TOTAL_FICHIERS) {
			var totalPoids = parseInt(window.document.forms[indiceForm].POIDS_TOTAL_FICHIERS.value)-parseInt(arrayFichiergw[indice].poids);
			eval('window.document.forms[indiceForm].POIDS_TOTAL_FICHIERS.value = '+totalPoids+'');
		}
		
		arrayFichiergw[indice] = null;
		preparerFichiergw();
	}
}

// renvoi du fichier a la fin du processus TRAITEMENT_FICHIERGW_FRONT
function renvoyerFichiergw(ID_FICHIER_JOINT, NOM_FICHIER_JOINT, FORMAT_FICHIER_JOINT, VERSION_FICHIER_JOINT, DATE_FICHIER_JOINT, NO_FICHIER_JOINT,MODE, POIDS_FICHIER) {
	window.opener.saveFormFichiergw(ID_FICHIER_JOINT, NOM_FICHIER_JOINT, FORMAT_FICHIER_JOINT, VERSION_FICHIER_JOINT, DATE_FICHIER_JOINT, NO_FICHIER_JOINT,MODE, POIDS_FICHIER);
	window.close();
}

function saveFormFichiergw(ID_FICHIER_JOINT, NOM_FICHIER_JOINT, FORMAT_FICHIER_JOINT, VERSION_FICHIER_JOINT, DATE_FICHIER_JOINT, NO_FICHIER_JOINT,MODE, POIDS_FICHIER)	{
		var fic = new Fichiergw(ID_FICHIER_JOINT,NOM_FICHIER_JOINT,FORMAT_FICHIER_JOINT,VERSION_FICHIER_JOINT,DATE_FICHIER_JOINT,POIDS_FICHIER);
		if (MODE.indexOf('simple') !=-1){
			arrayFichierJointUnique[NO_FICHIER_JOINT]=fic;
			preparerFichiergwUnique(NO_FICHIER_JOINT);
		}
		else{
			arrayFichiergw[NO_FICHIER_JOINT]=fic;
			preparerFichiergw();
			if( window.document.forms[indiceForm].NB_FICHIER_JOINT){
				t = parseInt(window.document.forms[indiceForm].NB_FICHIER_JOINT.value)+1;
				eval('window.document.forms[indiceForm].NB_FICHIER_JOINT.value = '+t+'');
			}
			
			//mise à jour du poids total des fichiers ajoutés
			if( window.document.forms[indiceForm].POIDS_TOTAL_FICHIERS){
				var totalPoids = parseInt(window.document.forms[indiceForm].POIDS_TOTAL_FICHIERS.value)+parseInt(POIDS_FICHIER);
				eval('window.document.forms[indiceForm].POIDS_TOTAL_FICHIERS.value = '+totalPoids+'');
			}
		}
}

// preparation pre-validation
// concatenation du tableau de fichiers pour sauvegarde
function preparerFichiergw(){
		var temp = '';
		for (i=0;i<arrayFichiergw.length;i++){	
			if(arrayFichiergw[i]){
				if (temp.length>0){
					temp += "|";
				}
				temp += arrayFichiergw[i].id+";"+arrayFichiergw[i].nom+";"+arrayFichiergw[i].format+";"+arrayFichiergw[i].version+";"+arrayFichiergw[i].date+";"+arrayFichiergw[i].poids;
			}
		}
		window.document.forms[indiceForm].TOTAL_FICHIER_JOINT.value = temp;
	affichageFichiergw();
}

// affichage des fichiers
// soit une liste si n fichiers
// soit un fichier unique (ex:logo)
function affichageFichiergw(){

	var temp = '';
	var div = document.getElementById('inner-fichier');
	if (modeFichier.indexOf('document') !=-1)
	{
		// specifique pour les fichiers avec gestion de version
		for (i=0;i<arrayFichiergw.length;i++){	
			if(arrayFichiergw[i]){
				temp += "<tr><td><input type=\"input\" id=\"version-fichier\" class=\"champ-saisie\" readonly=\"readonly\" name=\"VERSION_FICHIER_JOINT_"+i+"\" size=\"1\" value=\""+arrayFichiergw[i].version+"\" /></td>";
				temp += "<td><input type=\"input\" id=\"date-fichier\" class=\"champ-saisie\" readonly=\"readonly\" name=\"DATE_FICHIER_JOINT_"+i+"\" size=\"6\" value=\""+arrayFichiergw[i].date+"\" /></td>";
				temp += "<td><input type=\"input\" id=\"libelle-fichier\" class=\"champ-saisie\" readonly=\"readonly\" name=\"LIBELLE_FICHIER_JOINT_"+i+"\" size=\"30\" value=\""+arrayFichiergw[i].nom+"\" /></td>";
				temp += "<td><input type=\"button\" class=\"bouton\" value=\"Supprimer\" onclick=\"supprimerFichiergw('"+i+"');\" /></td></tr>";
			}
		}
	}
	else{
		// liste de fichiers par defaut
		for (i=0;i<arrayFichiergw.length;i++){	
			if(arrayFichiergw[i]){
				temp += "<tr><td><input type=\"input\" id=\"libelle-fichier\" class=\"champ-saisie\" readonly=\"readonly\" name=\"LIBELLE_FICHIER_JOINT_"+i+"\" size=\"30\" value=\""+arrayFichiergw[i].nom+"\" /></td>";
				temp += "<td><input type=\"button\" id=\"supprimer-fichier\" class=\"bouton\" value=\"Supprimer\" onclick=\"supprimerFichiergw('"+i+"');\" /></td></tr>";
			}
		}
	}
	if (is.ie){
		div.outerHTML = '<table id ="inner-fichier">'+temp.toString()+'</table>';
	}
	else{
		div.innerHTML = temp.toString();
	}
}

// preparation pre-validation
// concatenation du fichier joint
function preparerFichiergwUnique(indice){

	if (arrayFichierJointUnique[indice]){
		fichierJointUnique = arrayFichierJointUnique[indice];
		temp = fichierJointUnique.id+";"+fichierJointUnique.nom+";"+fichierJointUnique.format+";"+fichierJointUnique.version+";"+fichierJointUnique.date;
		zoneFichier = 'FICHIER_UNIQUE_'+indice;
		zoneLibelle = 'LIBELLE_FICHIER_'+indice;
		eval("window.document.forms[indiceForm]."+zoneFichier+".value = '"+temp+"';");
		eval("window.document.forms[indiceForm]."+zoneLibelle+".value = '"+fichierJointUnique.nom+"';");
}

	}

//specifique fichier unique ex:logo espace collaoboratif
// attention l'index du formulaire est variable selon les page
function effacerFichier(indice){
	if (arrayFichierJointUnique[indice]){
			arrayFichierJointUnique[indice]=null;
			zoneFichier = 'FICHIER_UNIQUE_'+indice;
			zoneLibelle = 'LIBELLE_FICHIER_'+indice;
			eval("window.document.forms[indiceForm]."+zoneFichier+".value = '';");
			eval("window.document.forms[indiceForm]."+zoneLibelle+".value = 'Cliquer sur parcourir';");
	}
}

/* Gestion des dossiers */

var arrayDossiergw = new Array(); 

//constructeur de la classe
function Dossiergw(p1, p2, p3, p4, p5)
{
	this.id = p1;
	this.code = p2;
	this.parent = p3;
	this.nom = p4;
	this.espace = p5;
}

function visualiserDossiergw(idfiche, typefiche, espace)
{
	window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_DOSSIERGW_FRONT&ACTION=VISUALISER&SAISIE_FRONT=true&ESPACE="+espace+"&ID_FICHE="+idfiche+"&TYPE_FICHE="+typefiche+"", "dossiergw", "width=400, height=400, scrollbars=yes, resizable=yes, status=no");
}

function ajouterDossiergw(nomForm)
{
	if (!nomForm && indiceForm){
		nomForm = indiceForm;
	}

	if (d.aNodes[d.selectedNode]){
		codeParent = d.aNodes[d.selectedNode].id;
		espace = '';
		if (document.forms[nomForm].ESPACE.value)
		{
			espace = document.forms[nomForm].ESPACE.value;
		}
		window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_DOSSIERGW_FRONT&ACTION=INSERER&SAISIE_FRONT=true&ESPACE="+espace+"&CODE_PARENT="+codeParent+"", "Dossiergw", "width=400, height=200, status=no");
	}else{
		alert("Veuillez sélectionner un emplacement!");
	}
}

function supprimerDossiergw(nomForm)
{
	if (!nomForm && indiceForm){
		nomForm = indiceForm;
	}

	if (d.aNodes[d.selectedNode]){
		code = d.aNodes[d.selectedNode].id;
		if (code==0){
			alert("Vous ne pouvez pas supprimer la racine!");
		}else{
			espace = '';
			if (document.forms[nomForm].ESPACE.value){
				espace = document.forms[nomForm].ESPACE.value;
			}
			idfiche = '';
			if (document.forms[nomForm].ID_FICHE.value)
			{
				idfiche = document.forms[nomForm].ID_FICHE.value;
			}
			typefiche = '';
			if (document.forms[nomForm].TYPE_FICHE.value)
			{
				typefiche = document.forms[nomForm].TYPE_FICHE.value;
			}
			window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_DOSSIERGW_FRONT&ACTION=SUPPRIMER&SAISIE_FRONT=true&ESPACE="+espace+"&CODE_DOSSIER="+code+"&ID_FICHE="+idfiche+"&TYPE_FICHE="+typefiche+"", "Dossiergw", "width=400, height=200, status=no"); 
		}
	}else{
		alert("Veuillez sélectionner un dossier!");
	}

}

function renommerDossiergw(nomForm)
{
	if (!nomForm && indiceForm){
		nomForm = indiceForm;
	}

	if (d.aNodes[d.selectedNode]){
		code = d.aNodes[d.selectedNode].id;
		if (code==0){
			alert("Vous ne pouvez pas modidier la racine!");
		}else{
			espace = '';
			if (document.forms[nomForm].ESPACE.value){
				espace = document.forms[nomForm].ESPACE.value;
			}
			window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_DOSSIERGW_FRONT&ACTION=MODIFIER&SAISIE_FRONT=true&ESPACE="+espace+"&CODE_DOSSIER="+code+"", "Dossiergw", "width=400, height=200, status=no"); 
		}
	}else{
		alert("Veuillez sélectionner un dossier!");
	}
}

function deplacerDossiergw(nomForm)
{
	if (!nomForm && indiceForm){
		nomForm = indiceForm;
	}

	if (d.aNodes[d.selectedNode]){
		code = d.aNodes[d.selectedNode].id;
		if (code==0){
			alert("Vous ne pouvez pas modidier la racine!");
		}else{
			espace = '';
			if (document.forms[nomForm].ESPACE.value){
				espace = document.forms[nomForm].ESPACE.value;
			}
			window.open("/servlet/com.jsbsoft.jtf.core.SG?PROC=TRAITEMENT_DOSSIERGW_FRONT&ACTION=DEPLACER&SAISIE_FRONT=true&ESPACE="+espace+"&CODE_DOSSIER="+code+"", "Dossiergw", "width=400, height=400, resizable=yes, status=no"); 
		}
	}else{
		alert("Veuillez sélectionner un dossier!");
	}
}

function synchroniserDossiergw(nomForm) 
{
	if (!nomForm && indiceForm){
		nomForm = indiceForm;
	}

	if (d.aNodes[d.selectedNode]){
		code =d.aNodes[d.selectedNode].id;
		window.opener.arrayDossiergw = arrayDossiergw;
		window.close();
		if (code==0){
			window.opener.document.forms[nomForm].LIBELLE_DOSSIER.value="Racine (par défaut)";
			window.opener.document.forms[nomForm].NOM_DOSSIER.value="";
			window.opener.document.forms[nomForm].DOSSIER.value="";
		}else{
			window.opener.document.forms[nomForm].DOSSIER.value=code;
			if (arrayDossiergw.length>0)
			{
				for (i=0;i<arrayDossiergw.length;i++)
				{
					if(arrayDossiergw[i])
					{
						if (arrayDossiergw[i].code==code)
						{
							window.opener.document.forms[nomForm].LIBELLE_DOSSIER.value=arrayDossiergw[i].nom;
							window.opener.document.forms[nomForm].NOM_DOSSIER.value=arrayDossiergw[i].nom;
						}
					}
				}
			}
		}
	}else{
		window.opener.arrayDossiergw = arrayDossiergw;
		window.close();
		window.opener.document.forms[nomForm].DOSSIER.value="";
		window.opener.document.forms[nomForm].LIBELLE_DOSSIER.value="Racine (par défaut)";
		window.opener.document.forms[nomForm].NOM_DOSSIER.value="";
	}
}

function fermerDossiergw(nomForm)
{
	if (!nomForm && indiceForm){
		nomForm = indiceForm;
	}
	window.opener.arrayDossiergw = arrayDossiergw;
	window.close();
	if (window.opener.document.forms[nomForm].NOM_DOSSIER.value=="")
	{
		window.opener.document.forms[nomForm].LIBELLE_DOSSIER.value="Racine (par défaut)";
		window.opener.document.forms[nomForm].NOM_DOSSIER.value="";
	}
}

function affichageDtreeDossiergw(url)
{
	if (url == '')
		url = '#';

	d = new dTree('d');		
	d.add(0,-1,'Racine',url,'','','/adminsite/utils/dtree/img/dd.gif','/adminsite/utils/dtree/img/dd.gif');
	if (arrayDossiergw.length>0)
	{
		for (i=0;i<arrayDossiergw.length;i++)
		{
			if(arrayDossiergw[i])
			{
				if (arrayDossiergw[i].parent != "")
				{
					d.add(arrayDossiergw[i].code,arrayDossiergw[i].parent,arrayDossiergw[i].nom,url,'','','/adminsite/utils/dtree/img/folder.gif','/adminsite/utils/dtree/img/folderopen.gif');
				}
				else
				{
					d.add(arrayDossiergw[i].code,0,arrayDossiergw[i].nom,url,'','','/adminsite/utils/dtree/img/folder.gif','/adminsite/utils/dtree/img/folderopen.gif');
				}
			}
		}
				}
	document.write(d);
	d.openAll();
}

/* Gestion de la palette des couleurs */

function popup_color_picker(nom1,nom2)
{
	titreCouleur = nom1;
	titreExemple = nom2;
	var width = 400;
	var height = 260;
	window.open('/adminsite/utils/colpick/color_picker.jsp?COULEUR='+titreCouleur+'&EXEMPLE='+titreExemple+'&FORM='+indiceForm+'', 'cp', 'resizable=no, location=no, width='
				+width+', height='+height+', menubar=no, status=yes, scrollbars=no, menubar=no');
}

function effacerCouleur(nom1,nom2)
{
	window.document.forms[indiceForm].elements[nom2].style.borderColor = '';
	window.document.forms[indiceForm].elements[nom2].style.backgroundColor = '';
	window.document.forms[indiceForm].elements[nom1].value = '';
}

/* Gestion des documents */

var arrayDocumentgw = new Array(); 

//constructeur de la classe
function Documentgw(p1, p2, p3, p4, p5)
{
	this.id = p1;
	this.code = p2;
	this.url = p3;
	this.libelle = p4;
	this.dossier = p5
}



function affichageDtreeDocumentgw(){
	ddoc = new dTree('ddoc');		
	ddoc.add(0,-1,'Liste des fichiers','#','','','','');

	// gestion des dossiers
	if (arrayDossiergw.length>0)
	{
		for (i=0;i<arrayDossiergw.length;i++)
		{
			if(arrayDossiergw[i])
			{
				if (arrayDossiergw[i].parent != "")
				{
					ddoc.add(arrayDossiergw[i].code,arrayDossiergw[i].parent,arrayDossiergw[i].nom,'#','','','/adminsite/utils/dtree/img/folder.gif','/adminsite/utils/dtree/img/folderopen.gif');
				}
				else
				{
					ddoc.add(arrayDossiergw[i].code,0,arrayDossiergw[i].nom,'#','','','/adminsite/utils/dtree/img/folder.gif','/adminsite/utils/dtree/img/folderopen.gif');
				}
			}
		}
	}

	// gestion des documents
	if (arrayDocumentgw.length>0)
	{
		for (i=0;i<arrayDocumentgw.length;i++)
		{
			if (arrayDocumentgw[i])
			{
				ddoc.add(arrayDocumentgw[i].code,arrayDocumentgw[i].dossier,arrayDocumentgw[i].libelle,arrayDocumentgw[i].url,'','','/adminsite/utils/dtree/img/page.gif','/adminsite/utils/dtree/img/page.gif');
			}
		}
	}


	document.write(ddoc);
	ddoc.openAll();
	
}

function afficher_calendrier(nom, form, url_image) {
	if (! url_image)
	{
		url_image = "/adminsite/images/calendrier.png";
	}
	if (document.getElementById) {
		document.write("<a href=\"#\" onclick=\"window.open('/adminsite/calendrier/calendrierjs.html?champ=" + nom + "&form=" + form +"', 'calendrier', 'width=135, height=138, toolbar=no, location=no, status=yes, resizable=yes'); return false;\"><img src=\""+url_image+"\" border=\"0\" alt=\"choisir une date\"></a>");
	}
}

function afficher_actions(){
	if (d.aNodes[d.selectedNode]){
		code =d.aNodes[d.selectedNode].id;
		if (code==0){
			window.document.getElementById('folder_links').style.display = 'none';
			window.document.getElementById('root_links').style.display = 'inline';
			
		}else{
			window.document.getElementById('root_links').style.display = 'none';
			window.document.getElementById('folder_links').style.display = 'inline';
		}
	}
}

function selectionner_dossier()
{
	oNode = d.aNodes[d.selectedNode];
	oForm = document.forms["RECHERCHE_WEB"];
	oForm.CODE_DOSSIER_PARENT.value = oNode.id;
	oForm.submit();
}

function replaceAll(str, search, repl) {
	while (str.indexOf(search) != -1)
		str = str.replace(search, repl);
	return str;
}


/* =============================================== */
/*   METHODES DE GESTION DES LISTES MULTIVALUEES   */
/* =============================================== */

var INPUT_FIELD = 0;
var COMBO_BOX = 1;
var ZONE_FIELD = 2;

function MultivalueFieldItem(sCode, sLabel, sTitle)
{
	this.sCode = sCode;
	if (sLabel == '')
	{
		this.sLabel = sCode;
	}
	else
	{
		this.sLabel = sLabel;
	}
	this.sTitle = sTitle;
	this.toString = function()
	{
		var s = 'sCode = ' + this.sCode;
		s += ', sLabel = ' + this.sLabel;
		if (this.sTitle)
		{
			s += ', sTitle = ' + this.sTitle;
		}
		return s;
	}
}

function MultivalueField(oForm, sName, iTypeField)
{
	//this.oForm = oForm;
	// verrue kdecole pour liste en front
	this.oForm = window.document.forms['RECHERCHE_WEB'] ? window.document.forms['RECHERCHE_WEB'] : oForm;
	this.sName = sName;
	this.iTypeField = iTypeField;
	this.aItemList = new Array();
	this.iSelectedItem = -1;

	// Initialise le champ de saisie multiple
	this.Init = function()
	{
		this.oCodesHiddenField = this.oForm.elements[sName];                 // champ caché contenant la liste des codes
		this.oLabelsHiddenField = this.oForm.elements['LIBELLE_' + sName];   // champ caché contenant la liste des libellés
		this.oTitlesHiddenField = this.oForm.elements['INFOBULLE_' + sName]; // champ caché contenant la liste des infobulles
		this.oField = this.oForm.elements['TMP_' + sName];                   // champ de saisie (input, combo, ou zone)
		if (this.iTypeField == ZONE_FIELD)
		{
			this.oLabelField = this.oForm.elements['LIBELLE_TMP_' + sName];  // champ contenant le libellé pour un champ zone
		}
		this.oSelect = this.oForm.elements['SELECT_' + sName];               // champ select multiple contenant les différentes valeurs
		this.LoadData(); // charge le contenu de la liste multivaluée
		if (this.aItemList.length > 0)
		{
			this.iSelectedItem = 0;
		}
		this.UpdateDisplay();
	}

	// Teste si l'élément est présent dans la liste
	this.ContainsItem = function(oItem)
	{
		// parcourt la liste
		var inList = false;
		for (var i = 0; i < this.aItemList.length; i++)
		{
			if (oItem.sCode == this.aItemList[i].sCode)
			{
				inList = true;
			}
		}
		return inList;
	}

	// Ajoute éventuellement un nouvel élément à la liste
	this.Add = function()
	{
		// lit la saisie ou l'élément sélectionné (suivant le type de champ)
		var sCode = ''; // TODO
		var sLabel = '';
		var sTitle;
		if (this.iTypeField == INPUT_FIELD) // champ de saisie
		{
			sCode = this.oField.value;
		}
		else if (this.iTypeField == COMBO_BOX) // combo box
		{
			if (this.oField.selectedIndex > 0) // on n'est pas sur le premier élément (code != '0000')
			{
				sCode = this.oField.value;
				sLabel = this.oField.options[this.oField.selectedIndex].text;
				if (sLabel.charAt(0) == '-')
				{
					sCode = '';
				}
				sTitle = sLabel;
			}
		}
		else if (this.iTypeField == ZONE_FIELD) // zone de saisie
		{
			sCode = this.oField.value;
			sLabel = this.oLabelField.value;
			sTitle = this.oLabelField.title;
		}
		if (sCode != '') // si il y a qqch à ajouter
		{
			var oItem = new MultivalueFieldItem(sCode, sLabel, sTitle);
			//alert(oItem);
			if (! this.ContainsItem(oItem)) // si l'élément n'est pas dans la liste
			{
				// ajoute l'élément à la fin de la liste
				this.aItemList[this.aItemList.length] = oItem;
				// sélectionne l'élément ajouté
				this.iSelectedItem = this.aItemList.length-1;
				// met à jour l'affichage
				this.UpdateDisplay();
				// met à jour le champ caché
				this.SaveData();
				// réinitialise le champ de saisie
				if (this.iTypeField == INPUT_FIELD) // champ de saisie
				{
					this.oField.value = '';
				}
				else if (this.iTypeField == COMBO_BOX) // combo box
				{
					this.oField.selectedIndex = 0;
				}
				/*else if (this.iTypeField == ZONE_FIELD) // zone de saisie
				{
					effacerTextField('TMP_' + this.sName, 'LIBELLE_TMP_' + this.sName, '', 'Cliquer sur parcourir');
				}*/
			}
			else
			{
				alert('Cette valeur a déjà été insérée.');
			}
		}
	}

	// Supprime l'élément sélectionné
	this.Remove = function()
	{
		if (this.aItemList.length > 0) // la liste n'est pas vide
		{
			if (this.iSelectedItem != -1) // un élément est sélectionné
			{
				// décale les éléments suivants
				for (var i = this.iSelectedItem; i < this.aItemList.length-1; i++)
				{
					this.aItemList[i] = this.aItemList[i+1];
				}
				// supprime le dernier élément en double
				//this.aItemList[this.aItemList.length-1] = null;
				this.aItemList.length--;
				// met à jour la sélection
				if (this.iSelectedItem == this.aItemList.length)
				{
					this.iSelectedItem--;
				}
				// met à jour l'affichage
				this.UpdateDisplay();
				// met à jour le champ caché
				this.SaveData();
			}
			else
			{
				alert('Sélectionnez la valeur à supprimer.');
			}
		}
	}

	// Modifie l'élément sélectionné ( !!!! spécifique pour chaque type d'élément)
	this.Modify = function()
	{
		if (this.aItemList.length > 0) // la liste n'est pas vide
		{
			if (this.iSelectedItem != -1) // un élément est sélectionné
			{
				specificModifyItem(this);
			}
			else
			{
				alert('Sélectionnez la valeur à modifier.');
			}
		}
	}

	// Met à jour l'élément sélectionné ( !!!! spécifique pour chaque type d'élément)
	this.UpdateItem = function(item)
	{
		if (this.aItemList.length > 0) // la liste n'est pas vide
		{
			if (this.iSelectedItem != -1) // un élément est sélectionné
			{
				// met à jour l'élément selectionné
				this.aItemList[this.iSelectedItem] = item;
				// met à jour l'affichage
				this.UpdateDisplay();
				// met à jour le champ caché
				this.SaveData();
			}
			else
			{
				alert('Sélectionnez la valeur à modifier.');
			}
		}
	}

	// Remonte l'élément sélectionné
	this.MoveUp = function()
	{
		if (this.aItemList.length > 1 && // la liste contient plusieurs éléments,
		    this.iSelectedItem != -1 &&  // un des éléments est sélectionné,
		    this.iSelectedItem > 0)      // ce n'est pas le premier élément de la liste
		{
			// intervertit l'élément avec son précédent
			var oItemTmp = this.aItemList[this.iSelectedItem];
			this.aItemList[this.iSelectedItem] = this.aItemList[this.iSelectedItem - 1];
			this.aItemList[this.iSelectedItem - 1] = oItemTmp;
			// met à jour la sélection
			this.iSelectedItem--;
			// met à jour l'affichage
			this.UpdateDisplay();
			// met à jour le champ caché
			this.SaveData();
		}
	}

	// Descend l'élément sélectionné
	this.MoveDown = function()
	{
		if (this.aItemList.length > 1 &&                    // la liste contient plusieurs éléments,
		    this.iSelectedItem != -1 &&                     // un des éléments est sélectionné,
		    this.iSelectedItem < this.aItemList.length - 1) // ce n'est pas le dernier élément de la liste
		{
			// intervertit l'élément avec son suivant
			var oItemTmp = this.aItemList[this.iSelectedItem];
			this.aItemList[this.iSelectedItem] = this.aItemList[this.iSelectedItem + 1];
			this.aItemList[this.iSelectedItem + 1] = oItemTmp;
			// met à jour la sélection
			this.iSelectedItem++;
			// met à jour l'affichage
			this.UpdateDisplay();
			// met à jour le champ caché
			this.SaveData();
		}
	}

	// Sélectionne un élément (à associer au onclick sur un élément)
	this.SelectItem = function()
	{
		if (this.aItemList.length == 0)
		{
			this.iSelectedItem = -1;
		}
		else
		{
			this.iSelectedItem = this.oSelect.selectedIndex;
		}
	}

	// Met à jour l'affichage HTML
	this.UpdateDisplay = function()
	{
		this.oSelect.options.length = 0;
		if (this.aItemList.length == 0)
		{
			this.oSelect.options[0] = new Option('--', -1);
			this.oSelect.selectedIndex = 0;
		}
		else
		{
			var oItem;
			for (var i = 0; i < this.aItemList.length; i++)
			{
				oItem = this.aItemList[i];
				this.oSelect.options[i] = new Option(oItem.sLabel);
				if (oItem.sTitle)
				{
					this.oSelect.options[i].title = oItem.sTitle;
				}
			}
			this.oSelect.selectedIndex = this.iSelectedItem;
		}
	}

	// Charge le contenu existant du champ
	this.LoadData = function()
	{
		var aCodes = this.oCodesHiddenField.value.split(';');
		var aLabels = this.oLabelsHiddenField.value.split(';');
		var aTitles;
		if (this.oTitlesHiddenField)
		{
			aTitles = this.oTitlesHiddenField.value.split(';');
		}
		for (var i = 0; i < aCodes.length; i++)
		{
			if (aCodes[i] != '' && aCodes[i] != '0000')
			{
				if (aTitles)
				{
					oItem = new MultivalueFieldItem(aCodes[i], aLabels[i], aTitles[i]);
				}
				else
				{
					oItem = new MultivalueFieldItem(aCodes[i], aLabels[i]);
				}
				//alert(oItem);
				if (! this.ContainsItem(oItem)) // si l'élément n'est pas dans la liste
				{
					// ajoute l'élément à la fin de la liste
					this.aItemList[this.aItemList.length] = oItem;
				}
			}
		}
	}

	// Sauve le contenu existant du champ
	this.SaveData = function()
	{
		this.oCodesHiddenField.value = '';
		this.oLabelsHiddenField.value = '';
		if (this.oTitlesHiddenField)
		{
			this.oTitlesHiddenField.value = '';
		}
		var oItem;
		for (var i = 0; i < this.aItemList.length; i++)
		{
			oItem = this.aItemList[i];
			if (i > 0)
			{
				this.oCodesHiddenField.value += ';';
				this.oLabelsHiddenField.value += ';';
				if (this.oTitlesHiddenField)
				{
					this.oTitlesHiddenField.value += ';';
				}
			}
			this.oCodesHiddenField.value += oItem.sCode;
			this.oLabelsHiddenField.value += oItem.sLabel;
			if (this.oTitlesHiddenField)
			{
				this.oTitlesHiddenField.value += oItem.sTitle;
			}
		}
	}

}

/* ============================================= */
/*   METHODES DE GESTION DES OBJETS TECHNIQUES   */
/* ============================================= */

function soumettreAjoutSousObjet(nomObjet) {
	nettoyerDonnees();
	window.document.forms[0].ACTION.value = 'NOCTRL_AJOUTER_' + nomObjet;
	window.document.forms[0].submit();
}
function soumettreModificationSousObjet(nomObjet, indice) {
	nettoyerDonnees();
	window.document.forms[0].ACTION.value = 'NOCTRL_MODIFIER_' + nomObjet + '#' + indice;
	window.document.forms[0].submit();
}
function soumettreSuppressionSousObjet(nomObjet, indice) {
	nettoyerDonnees();
	window.document.forms[0].ACTION.value = 'NOCTRL_SUPPRIMER_' + nomObjet + '#' + indice;
	window.document.forms[0].submit();
}
function soumettreValidationSousObjet(nomObjet) {
	nettoyerDonnees();
	window.document.forms[0].ACTION.value = 'VALIDER_' + nomObjet;
	window.document.forms[0].submit();
}
function soumettreAnnulationSousObjet(nomObjet) {
	nettoyerDonnees();
	window.document.forms[0].ACTION.value= 'NOCTRL_ANNULER_' + nomObjet;
	window.document.forms[0].submit();
}
