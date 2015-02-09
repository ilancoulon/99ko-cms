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

/**
 * Charge les fichiers javascript en pied de page du thème admin
 */
function extrasEndAdminBody(){
    $temp = "\t".'<script src="'.PLUGINS.'extras/other/foundation.min.js?v=5.2.2"></script>'."\n";
    $temp.= "\t".'<script>$(document).foundation();</script>'."\n"; 
    echo $temp;
}
?>