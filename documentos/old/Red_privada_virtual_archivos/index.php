/* generated javascript */var skin = 'monobook';
var stylepath = '/skins-1.5';/* MediaWiki:Monobook */
/*
<pre>
*/

/* tooltips and access keys */
ta = new Object();
ta['pt-userpage'] = new Array('.','Mi página de usuario'); 
ta['pt-anonuserpage'] = new Array('.','La página de usuario de la IP desde la que editas'); 
ta['pt-mytalk'] = new Array('n','Mi página de discusión'); 
ta['pt-anontalk'] = new Array('n','Discusión sobre ediciones hechas desde esta dirección IP'); 
ta['pt-preferences'] = new Array('','Mis preferencias'); 
ta['pt-watchlist'] = new Array('l','La lista de páginas para las que estás vigilando los cambios'); 
ta['pt-mycontris'] = new Array('y','Lista de mis contribuciones'); 
ta['pt-login'] = new Array('o','Te animamos a registrarte antes de editar, aunque no es obligatorio'); 
ta['pt-anonlogin'] = new Array('o','Te animamos a registrarte antes de editar, aunque no es obligatorio'); 
ta['pt-logout'] = new Array('o','Salir de la sesión'); 
ta['ca-talk'] = new Array('t','Discusión acerca del artículo'); 
ta['ca-edit'] = new Array('e','Puedes editar esta página. Por favor, usa el botón de previsualización antes de grabar.'); 
ta['ca-addsection'] = new Array('+','Añadir un comentario a esta discusión'); 
ta['ca-viewsource'] = new Array('e','Esta página está protegida, sólo puedes ver su código fuente'); 
ta['ca-history'] = new Array('h','Versiones anteriores de esta página y sus autores'); 
ta['ca-protect'] = new Array('=','Proteger esta página'); 
ta['ca-delete'] = new Array('d','Borrar esta página'); 
ta['ca-undelete'] = new Array('d','Restaurar las ediciones hechas a esta página antes de que fuese borrada'); 
ta['ca-move'] = new Array('m','Trasladar (renombrar) esta página'); 
ta['ca-nomove'] = new Array('','No tienes los permisos necesarios para trasladar esta página'); 
ta['ca-watch'] = new Array('w','Añadir esta página a tu lista de seguimiento'); 
ta['ca-unwatch'] = new Array('w','Borrar esta página de tu lista de seguimiento'); 
ta['search'] = new Array('f','Buscar en este wiki'); 
ta['p-logo'] = new Array('','Portada'); 
ta['n-mainpage'] = new Array('z','Visitar la Portada'); 
ta['n-portal'] = new Array('','Acerca del proyecto, qué puedes hacer, dónde encontrar información'); 
ta['n-currentevents'] = new Array('','Información de contexto sobre acontecimientos actuales'); 
ta['n-recentchanges'] = new Array('r','La lista de cambios recientes en el wiki'); 
ta['n-randompage'] = new Array('x','Cargar una página aleatoriamente'); 
ta['n-help'] = new Array('','El lugar para aprender'); 
ta['n-sitesupport'] = new Array('','Respáldanos'); 
ta['t-whatlinkshere'] = new Array('j','Lista de todas las páginas del wiki que enlazan con ésta'); 
ta['t-recentchangeslinked'] = new Array('k','Cambios recientes en las páginas que enlazan con esta otra'); 
ta['feed-rss'] = new Array('','Sindicación RSS de esta página'); 
ta['feed-atom'] = new Array('','Sindicación Atom de esta página'); 
ta['t-contributions'] = new Array('','Ver la lista de contribuciones de este usuario'); 
ta['t-emailuser'] = new Array('','Enviar un mensaje de correo a este usuario'); 
ta['t-upload'] = new Array('u','Subir imágenes o archivos multimedia'); 
ta['t-specialpages'] = new Array('q','Lista de todas las páginas especiales'); 
ta['ca-nstab-main'] = new Array('c','Ver el artículo'); 
ta['ca-nstab-user'] = new Array('c','Ver la página de usuario'); 
ta['ca-nstab-media'] = new Array('c','Ver la página de multimedia'); 
ta['ca-nstab-special'] = new Array('','Esta es una página especial, no se puede editar la página en sí'); 
ta['ca-nstab-wp'] = new Array('a','Ver la página de proyecto'); 
ta['ca-nstab-image'] = new Array('c','Ver la página de la imagen'); 
ta['ca-nstab-mediawiki'] = new Array('c','Ver el mensaje de sistema'); 
ta['ca-nstab-template'] = new Array('c','Ver la plantilla'); 
ta['ca-nstab-help'] = new Array('c','Ver la página de ayuda'); 
ta['ca-nstab-category'] = new Array('c','Ver la página de categoría');

 // adds show/hide-button to navigation bars
 function createNavigationBarToggleButton()
 {
    var indexNavigationBar = 0;
    // iterate over all <div>-elements
    for(
            var i=0; 
            NavFrame = document.getElementsByTagName("div")[i]; 
            i++
        ) {
        // if found a navigation bar
        if (NavFrame.className == "NavFrame") {

            indexNavigationBar++;
            var NavToggle = document.createElement("a");
            NavToggle.className = 'NavToggle';
            NavToggle.setAttribute('id', 'NavToggle' + indexNavigationBar);
            NavToggle.setAttribute('href', 'javascript:toggleNavigationBar(' + indexNavigationBar + ');');

            var NavToggleText = document.createTextNode(NavigationBarShow);
            NavToggle.appendChild(NavToggleText);

            // add NavToggle-Button as first div-element 
            // in <div class="NavFrame">
            NavFrame.insertBefore(
                NavToggle,
                NavFrame.firstChild
            );
            NavFrame.setAttribute('id', 'NavFrame' + indexNavigationBar);
        }
    }
    // if less o equal Navigation Bars found than Default: show all
    if (NavigationBarShowDefault >= indexNavigationBar) {
        for(
                var i=1; 
                i<=indexNavigationBar; 
                i++
        ) {
            toggleNavigationBar(i);
        }
    }
    
 }

 if (window.addEventListener) window.addEventListener("load",createNavigationBarToggleButton,false);
 else if (window.attachEvent) window.attachEvent("onload",createNavigationBarToggleButton);


var NavigationBarHide = 'Plegar';
var NavigationBarShow = 'Desplegar';

var NavigationBarShowDefault = 0;

function toggleNavigationBar(indexNavigationBar)
{
    var NavToggle = document.getElementById("NavToggle" + indexNavigationBar);
    var NavFrame = document.getElementById("NavFrame" + indexNavigationBar);

    if (!NavFrame || !NavToggle) {
        return false;
    }

    // if shown now
    if (NavToggle.firstChild.data == NavigationBarHide) {
        for (
                var NavChild = NavFrame.firstChild;
                NavChild != null;
                NavChild = NavChild.nextSibling
            ) {
            if (NavChild.className == 'NavPic') {
                NavChild.style.display = 'none';
            }
            if (NavChild.className == 'NavContent') {
                NavChild.style.display = 'none';
            }
            if (NavChild.className == 'NavToggle') {
                NavChild.firstChild.data = NavigationBarShow;
            }
        }

    // if hidden now
    } else if (NavToggle.firstChild.data == NavigationBarShow) {
        for (
                var NavChild = NavFrame.firstChild;
                NavChild != null;
                NavChild = NavChild.nextSibling
            ) {
            if (NavChild.className == 'NavPic') {
                NavChild.style.display = 'block';
            }
            if (NavChild.className == 'NavContent') {
                NavChild.style.display = 'block';
            }
            if (NavChild.className == 'NavToggle') {
                NavChild.firstChild.data = NavigationBarHide;
            }
        }
    }
}

function LinkFA() 
{
   // iterate over all <span>-elements
   for(var i=0; a = document.getElementsByTagName("span")[i]; i++) {
      // if found a FA span
      if(a.className == "destacado") {
         // iterate over all <li>-elements
         for(var j=0; b = document.getElementsByTagName("li")[j]; j++) {
            // if found a FA link
            if(b.className == "interwiki-" + a.id) {
               b.style.padding = "0 0 0 16px";
               b.style.backgroundImage = "url('http://upload.wikimedia.org/wikipedia/en/6/60/LinkFA-star.png')";
               b.style.backgroundRepeat = "no-repeat";
               b.title = "Este artículo ha sido destacado en esta wiki";
            }
         }
      }
   }
}

if (window.addEventListener) window.addEventListener("load",LinkFA,false);
else if (window.attachEvent) window.attachEvent("onload",LinkFA);


function addLoadEvent(func) {
   if (window.addEventListener) {
       window.addEventListener("load", func, false);
   } else if (window.attachEvent) {
       window.attachEvent("onload", func);
   }
}

/*** Enlace directo al Upload de Commons traido de w:ca: */
function afegeix_lliga_x_a_carregar_a_commons()
{
    if (document.getElementById("carrega-a-commons")) return;
    var li_carrega = document.getElementById("t-upload");
    if (!li_carrega) return;
    var afegit = li_carrega.nextSibling;
    var ul_eines = li_carrega.parentNode;
    var li = document.createElement("li");
    li.id = "carrega-a-commons";
    li.innerHTML = '<a href="http://commons.wikimedia.org/wiki/Special:Upload">Subir a Commons</a>';
    if (afegit) ul_eines.insertBefore(li, afegit);
    else ul_eines.appendChild(li);
}

addLoadEvent(afegeix_lliga_x_a_carregar_a_commons);

/*** Fin del módulo del enlace a commons */


/*
</pre>
*/