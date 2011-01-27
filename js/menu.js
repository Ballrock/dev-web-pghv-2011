/*
	ED - 12.07.2006
	
	Script pour gerer les menus deroulants structures comme des listes <ul> imbriquees.
	Les listes <ul> parentes (ou le menu de plus haut niveau) doient avoir une classe dont
	la valeur est definie ici par la variable : classeMenuDeroulant
	
	initMenus() parcour le document a la recherche des listes <ul> possedant cette classe
	et attache des gestionnaires d evenements aux <li> qui contiennent des sous menus
	pour les faire apparaitre et disparaitre au survol
	
	Attention: la fonction addEvent() definie dans defaut.js est requise !

*/
var classeMenuDeroulant = /menu_deroulant/;

/*
	Attache les gestionnaires d evenements aux lis qui ont des sous menus
*/
function initMenus() {
	var menu, menus, lis, liSousMenus;
	if(document.getElementById && document.getElementsByTagName){
			menus = document.getElementsByTagName("ul");
			if(menus.length > 0 ){
				for(var j=0; j<menus.length; j++){
					if(menus[j].className.match(classeMenuDeroulant)){
						menu = menus[j];
						lis = menu.getElementsByTagName("li");
						for(var i=0; i<lis.length; i++){
							liSousMenus = lis[i].getElementsByTagName("ul");
							if(liSousMenus.length > 0){
								// a un sous-menu
								addEvent(lis[i],"mouseover", montrePremierSousMenu);
								addEvent(lis[i],"focus", montrePremierSousMenu);
								addEvent(lis[i],"mouseout", cachePremierSousMenu);	
								addEvent(lis[i],"blur", cachePremierSousMenu);	
							}
						}
					} 
				}
			}
	}
}

/*
	Montre et cache les sous menus
*/
function montrePremierSousMenu(){
	this.getElementsByTagName("ul")[0].style.display = "block";
	/*this.style.backgroundColor = "#EDF4F9";*/
}

function cachePremierSousMenu(){
	this.getElementsByTagName("ul")[0].style.display = "none";
	/*this.style.backgroundColor = "#fff";*/
}

/*
	Appelle initMenus() au chargement de la page
*/
addEvent(window,"load", initMenus);