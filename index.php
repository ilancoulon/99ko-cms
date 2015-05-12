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
$time = microtime(true);
define('ROOT', './');
include_once(ROOT.'common/common.php');
## Hook
eval($core->callHook('startFrontIncludePluginFile'));
## On inclut le fichier public et la template du plugin en cours d'execution
if($runPlugin->getPublicFile()){
	include($runPlugin->getPublicFile());
	include($runPlugin->getPublicTemplate());
	// Gestion du cache HTML (bêta)
	if(CACHE_TIME > 0 && count($_POST) == 0) addToCache();
}
## Hook
eval($core->callHook('endFrontIncludePluginFile'));
?>