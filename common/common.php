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
 * @copyright   2015 Jonathan Coulet (j.coulet@gmail.com)  
 * @copyright   2013-2014 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com) / Frédéric Kaplon (frederic.kaplon@me.com)
 * @copyright   2010-2012 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2010 Jonathan Coulet (j.coulet@gmail.com)  
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

## Préchauffage...
session_start();
defined('ROOT') OR exit('No direct script access allowed');
define('VERSION', '2.0 b');
define('COMMON',  ROOT.'common/');
define('LANG', COMMON.'lang/');
define('DATA', ROOT.'data/');
define('UPLOAD', ROOT.'data/upload/');
define('DATA_PLUGIN', ROOT.'data/plugin/');
define('THEMES', ROOT.'theme/');
define('PLUGINS', ROOT.'plugin/');
define('ADMIN_PATH', ROOT.'admin/');
define('CACHE_TIME', 0);
if(file_exists(DATA.'key.php')) include(DATA.'key.php');
include_once(COMMON.'core.lib.php');
include_once(COMMON.'util.class.php');
include_once(COMMON.'core.class.php');
include_once(COMMON.'pluginsManager.class.php');
include_once(COMMON.'plugin.class.php');
include_once(COMMON.'show.class.php');
## Création de l'instance core
$core = core::getInstance();
## Plugin par défaut du mode public
define('DEFAULT_PLUGIN', $core->getConfigVal('defaultPlugin'));
// else...
## Si le core n'est pas installé on redirige vers le script d'installation
if(!$core->isInstalled()){
	header('location:' .ROOT. 'install.php');
	die();
}
## Gestion du cache HTML (bêta)
if(CACHE_TIME > 0 && ROOT == './'){
	$isInCache = readCache();
	if(!is_numeric($isInCache)){
		echo $isInCache;
		die();
	}
}
## Création de l'istance pluginsManager
$pluginsManager = pluginsManager::getInstance();
## On boucle sur les plugins
foreach($pluginsManager->getPlugins() as $plugin){
	// On inclut le fichier PHP principal
	include_once($plugin->getLibFile());
	// Le core charge le fichier langue du plugin
	$core->loadPluginLang($plugin->getName());
	// Le core alimente le tableau des hooks
	if($plugin->getConfigVal('activate')){
		foreach($plugin->getHooks() as $name=>$function){
			$core->addHook($name, $function);
		}
	}
}
## Hook
eval($core->callHook('startCreatePlugin'));
## Création de l'instance runPlugin, objet qui représente le plugin en cours d'execution
$runPlugin = $pluginsManager->getPlugin($core->getPluginToCall());
## Gestion des erreurs 404
if(ROOT == './' && (!$runPlugin || $runPlugin->getConfigVal('activate') < 1)) error404();
## Hook
eval($core->callHook('endCreatePlugin'));
?>