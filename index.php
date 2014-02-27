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

$time = microtime(true);
define('ROOT', './');
include_once(ROOT.'common/common.php');
/*
** Hook
*/
eval(callHook('startFrontIncludePluginFile'));
// includes plugin courant
if($runPlugin->getPublicFile()){
	include($runPlugin->getPublicFile());
	// sidebar theme ?
	$sidebar = false;
	foreach($pluginsManager->getPlugins() as $k=>$plugin) if($plugin->getConfigval('activate') == 1){
		if($plugin->getConfigVal('sidebarTitle') != '' && $plugin->getConfigVal('sidebarCallFunction') != ''){
			$sidebar = true;
		}
	}
	include($runPlugin->getPublicTemplate());
}
/*
** Fin hook
*/
eval(callHook('endFrontIncludePluginFile'));
?>