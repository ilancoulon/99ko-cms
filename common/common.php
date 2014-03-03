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

if(DEBUG) error_reporting(E_ALL);
else error_reporting(E_ALL ^ E_NOTICE);
session_start();
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'common/constants.php');
include_once(COMMON.'core.lib.php');
utilSetMagicQuotesOff();
// plugin par defaut
define('DEFAULT_PLUGIN', getCoreConf('defaultPlugin'));
// on check l'existence du fichier de configuration
if(!file_exists(DATA. 'config.txt')){
	header('location:' .ROOT. 'install.php');
	die();
}
// fuseau horaire par defaut
if (function_exists('date_default_timezone_set')) date_default_timezone_set(getCoreConf('siteTimezone')); 
else putenv('TZ='.getCoreConf('siteTimezone'));
// tableau des hooks a apeller
$hooks = array();
// tableau de config du core
$coreConf = getCoreConf();
// tableaux de parametres URL ($_GET)
$urlParams = getUrlParams();
// liste des themes
$themes = listThemes();
// liste es timezones
$timezones = listTimezones();
// liste des langues
$langs = listLangs();
// tableau langue courante
$lang = array();
// donnees langue core
$lang = utilReadJsonFile(LANG .getCoreConf('siteLang'). '.json');
// donnees langue du theme courant
if(file_exists(THEMES .getCoreConf('theme'). '/lang/' .getCoreConf('siteLang'). '.json')) $lang = array_merge($lang, utilReadJsonFile(THEMES .getCoreConf('theme'). '/lang/' .getCoreConf('siteLang'). '.json'));
// creation du pluginManager
$pluginsManager = pluginsManager::getInstance();
// on boucle les plugins
foreach($pluginsManager->getPlugins() as $plugin){
	// on inclu le fichier principal
	include_once($plugin->getLibFile());
	// on installe le plugin si besoin
	if(!$plugin->isInstalled()) $pluginsManager->installPlugin($plugin->getName());
	// on alimente le tableau de la langue courante
	if($plugin->getLang() != false) $lang = array_merge($lang, $plugin->getLang());
	// on alimente le tableau des hooks
	if($plugin->getConfigVal('activate')){
		foreach($plugin->getHooks() as $hookName=>$function) $hooks[$hookName][] = $function;
	}
}
// hook
eval(callHook('startCreatePlugin'));
// creation de le l'instance du plugin en cours d'execution
$runPlugin = $pluginsManager->getPlugin((isset($_GET['p'])) ? $_GET['p'] : DEFAULT_PLUGIN);
// erreur 404
if(!$runPlugin || $runPlugin->getConfigVal('activate') < 1) error404();
// hook
eval(callHook('endCreatePlugin'));
// compression gzip
if(!DEBUG && getCoreConf('gzip')){
    if(!ob_start("ob_gzhandler")) ob_start();
    else ob_start();
}

?>