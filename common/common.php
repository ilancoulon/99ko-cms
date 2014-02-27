<?php
/**
 * 99ko cms
 *
 * This source file is part of the 99ko cms. More information,
 * documentation and support can be found at http://99ko.hellojo.fr
 *
 * @package     99ko
 *
 * @author      Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2013-2014 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com) / Frédéric Kaplon (frederic.kaplon@me.com)
 * @copyright   2010-2012 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2010 Jonathan Coulet (j.coulet@gmail.com)  
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
//error_reporting(E_ALL);
defined('ROOT') OR exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * DEFINE CONSTANTS
 *---------------------------------------------------------------
 */
define('VERSION',            '1.4.2 b'); 
define('INACTIVITY_TIMEOUT',  1800); // Temps d'expiration d'une session en secondes (30 mins)
define('COMMON',       ROOT. 'common/');
define('LANG',       COMMON. 'lang/');
define('DATA',         ROOT. 'data/');
define('UPLOAD',       ROOT. 'data/upload/');
define('DATA_PLUGIN',  ROOT. 'data/plugin/');
define('THEMES',       ROOT. 'theme/');
define('PLUGINS',      ROOT. 'plugin/');
define('ADMIN_PATH',   ROOT. 'admin/'); // Path de l'administration
define('ACTION', ((isset($_GET['action'])) ? $_GET['action'] : '')); // inutile : voir $urlParams
/*
 *---------------------------------------------------------------
 * PRÉCHAUFFAGE
 *---------------------------------------------------------------
 */
session_start();
/**
 * On limite la durée de session active
 */
if(isset($_SESSION['timeout'])) {
    # On calcule le nombre de secondes depuis la dernière visite 
    # s'il est plus grand que le délai d'attente.
    $duration = time() - (int)$_SESSION['timeout'];
    if($duration > INACTIVITY_TIMEOUT) {
        # Si on dépasse le temps, on détruit la session et on la redémarre.
        session_destroy();
        #session_start();
    }
}
$_SESSION['timeout'] = time();

# on check le fichier de configuration
if(!file_exists(DATA. 'config.txt')){
	header('location:' .ROOT. 'install.php');
	die();
}

include(DATA. 'key.php');
# tableau des hooks
$hooks = array();
# on inclu les librairies
include_once(COMMON. 'core.lib.php');
# on charge la config du core
$coreConf = getCoreConf();
# on récupère les paramètres de l'URL
$urlParams = getUrlParams();
# Chargement des thèmes
$themes = listThemes();
# Chargement des langs
$langs = listLangs();
$lang = array();
# On charge la langue du core
$lang = utilReadJsonFile(LANG .getCoreConf('siteLang'). '.json');
if(file_exists(THEMES .getCoreConf('theme'). '/lang/' .getCoreConf('siteLang'). '.json')) $lang = array_merge($lang, utilReadJsonFile(THEMES .getCoreConf('theme'). '/lang/' .getCoreConf('siteLang'). '.json'));
# constantes
define('DEFAULT_PLUGIN', getCoreConf('defaultPlugin'));
define('PLUGIN', ((isset($_GET['p'])) ? $_GET['p'] : DEFAULT_PLUGIN)); // inutile : voir $runPlugin
/**
 * Compress HTML with gzip
 */
if (getCoreConf('gzip')) {
    if (!ob_start("ob_gzhandler")) ob_start(); $compressed = lang('Gzip compression on');
} else {
    ob_start();
}
# fix magic quotes
utilSetMagicQuotesOff();
/*
** Défini le fuseau horaire par défaut
*/
if (function_exists('date_default_timezone_set')) date_default_timezone_set(getCoreConf('siteTimezone')); 
else putenv('TZ='.getCoreConf('siteTimezone'));
/*
 *---------------------------------------------------------------
 * TRAITEMENT DES PLUGINS (CHARGEMENT, INSTALLATION, HOOKS...)
 *---------------------------------------------------------------
 */
# On créé le manager de plugins via la méthode getInstance (singleton)
$pluginsManager = pluginsManager::getInstance();

# on boucle les plugins pour charger les lib et les installer
foreach($pluginsManager->getPlugins() as $plugin){
	# on inclu la librairie
	include_once($plugin->getLibFile());
	# on inclu la langue
	if($plugin->getLang() != false) $lang = array_merge($lang, $plugin->getLang());
	# installation
	if(!$plugin->isInstalled()) $pluginsManager->installPlugin($plugin->getName());
	# on update le tableau des hooks
	if($plugin->getConfigVal('activate')){
		foreach($plugin->getHooks() as $hookName=>$function) $hooks[$hookName][] = $function;
	}
}
/*
 *---------------------------------------------------------------
 * CRÉATION DE L'OBJET $runPlugin (PLUGIN SOLICITÉ)
 *---------------------------------------------------------------
 */
# hook
eval(callHook('startCreatePlugin'));
# on cree l'instance du plugin solicite
$runPlugin = $pluginsManager->getPlugin(PLUGIN);
# erreur 404 si le plugin est introuvable ou inactif
if(!$runPlugin || $runPlugin->getConfigVal('activate') < 1) error404();
# hook
eval(callHook('endCreatePlugin'));
?>