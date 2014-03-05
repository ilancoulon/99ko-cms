<?php
defined('ROOT') OR exit('No direct script access allowed');

/*
** Exécute du code lors de l'installation
** Le code présent dans cette fonction sera exécuté lors de l'installation
** Le contenu de cette fonction est facultatif
*/
function extrasInstall(){
}

/********************************************************************************************************************
** Code relatif au plugin
** La partie ci-dessous est réservé au code du plugin 
** Elle peut contenir des classes, des fonctions, hooks... ou encore du code à exécutter lors du chargement du plugin
********************************************************************************************************************/

function extrasStartShowScriptTags(){
    $temp = "\$data.= str_replace('[file]', PLUGINS. 'extras/other/jquery.min.js?v=2.0.3', \$format);";
    $temp.= "\$data.= str_replace('[file]', PLUGINS. 'extras/other/modernizr.js?v=2.6.2', \$format);";
    return $temp;
}
?>