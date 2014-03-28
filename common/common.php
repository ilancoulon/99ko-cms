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
session_start();
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'common/constants.php');
include_once(COMMON.'core.lib.php');
utilSetMagicQuotesOff();
# Gestion des erreurs PHP (Dev Mod)
if(DEBUG) error_reporting(E_ALL);
else error_reporting(E_ALL ^ E_NOTICE);
# Plugin par défaut
define('DEFAULT_PLUGIN', getCoreConf('defaultPlugin'));
# Vérifie la présence du fichier de configuration
if(!file_exists(DATA. 'config.txt')){
	header('location:' .ROOT. 'install.php');
	die();
}
# Fuseau horaire par défaut
if (function_exists('date_default_timezone_set')) date_default_timezone_set(getCoreConf('siteTimezone')); 
else putenv('TZ='.getCoreConf('siteTimezone'));
# Tableau des hooks à appeler
$hooks = array();
# Tableau de config du core
$coreConf = getCoreConf();
# Tableaux des paramètres d'URL ($_GET)
$urlParams = getUrlParams();
# Liste des thèmes
$themes = listThemes();
# Liste des fuseaux horaires
$timezones = listTimezones();
# Liste des langues
$langs = listLangs();
# Tableau langue courante
$lang = array();
# Données langue du core
$lang = utilReadJsonFile(LANG .getCoreConf('siteLang'). '.json');
# Données langue du thème courant
if(file_exists(THEMES .getCoreConf('theme'). '/lang/' .getCoreConf('siteLang'). '.json')) $lang = array_merge($lang, utilReadJsonFile(THEMES .getCoreConf('theme'). '/lang/' .getCoreConf('siteLang'). '.json'));
# Création du pluginManager
$pluginsManager = pluginsManager::getInstance();
# On boucle les plugins
foreach($pluginsManager->getPlugins() as $plugin){
	# On inclut le fichier principal
	include_once($plugin->getLibFile());
	# On installe le plugin si besoin
	if(!$plugin->isInstalled()) $pluginsManager->installPlugin($plugin->getName());
	# On alimente le tableau de la langue courante
	if($plugin->getLang() != false) $lang = array_merge($lang, $plugin->getLang());
	# On alimente le tableau des hooks
	if($plugin->getConfigVal('activate')){
		foreach($plugin->getHooks() as $hookName=>$function) $hooks[$hookName][] = $function;
	}
}
# Début d'appel du Hook
eval(callHook('startCreatePlugin'));
# Création de le l'instance du plugin en cours d'exécution
$runPlugin = $pluginsManager->getPlugin((isset($_GET['p'])) ? $_GET['p'] : DEFAULT_PLUGIN);
# Erreur 404
if(!$runPlugin || $runPlugin->getConfigVal('activate') < 1) error404();
# Fin d'appel du hook
eval(callHook('endCreatePlugin'));
# Compression GZIP
if(!DEBUG && getCoreConf('gzip')){
    if(!ob_start("ob_gzhandler")) ob_start();
    else ob_start();
}

?>
