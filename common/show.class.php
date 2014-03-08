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
 * @copyright   2013-2014 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com) / Frédéric Kaplon (frederic.kaplon@me.com)
 * @copyright   2010-2012 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2010 Jonathan Coulet (j.coulet@gmail.com)  
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

defined('ROOT') OR exit('No direct script access allowed');

/*
 * classe show
 * methodes d'affichages
 *
 */

class show{
    
     // affiche un message d'alerte (admin + theme)
     public static function showMsg($msg, $type) {
     	$class = array(
     		'error'   => 'alert',
     		'success' => 'success',
     		'info'    => 'info',
     		'warning' => 'warning',
     	);
     	$data = '';
     	eval(callHook('startShowMsg'));
     	if($msg != '') $data = '<div data-alert class="alert-box '.$class[$type].' radius">
     	                                <h6>'.nl2br($msg).'</h6><a href="#" class="close">&times;</a>
     	                        </div>';
     	eval(callHook('endShowMsg'));
     	echo $data;
     }

     // affiche les balises "link" type css (admin + theme)
     public static function showLinkTags($format = '<link href="[file]" rel="stylesheet" type="text/css" />'){
     	global $pluginsManager;
     	$data = '';
     	eval(callHook('startShowLinkTags'));
     	foreach($pluginsManager->getPlugins() as $k=>$plugin) if($plugin->getConfigval('activate') == 1){
     		if($plugin->getConfigVal('activate') && $plugin->getCssFile()) $data.= str_replace('[file]', $plugin->getCssFile(), $format);
     	}
     	if(ROOT == './') $data.= str_replace('[file]', getCoreConf('siteUrl').'/'.'theme/'.getCoreConf('theme').'/styles.css', $format);
     	eval(callHook('endShowLinkTags'));
     	echo $data;
     }

     // affiche les balises "script" type javascript (admin + theme)
     public static function showScriptTags($format = '<script type="text/javascript" src="[file]"></script>') {
     	global $pluginsManager;
     	$data = '';
     	eval(callHook('startShowScriptTags'));
     	foreach($pluginsManager->getPlugins() as $k=>$plugin) if($plugin->getConfigval('activate') == 1){
     		if($plugin->getConfigVal('activate') && $plugin->getJsFile()) $data.= str_replace('[file]', $plugin->getJsFile(), $format);
     	}
     	if(ROOT == './') $data.= str_replace('[file]', getCoreConf('siteUrl').'/'.'theme/'.getCoreConf('theme').'/scripts.js', $format);
     	eval(callHook('endShowScriptTags'));
     	echo $data;
     }

     // affiche une balise textarea (admin)
     public static function showAdminEditor($name, $content, $id='editor', $class='editor') {
     	eval(callHook('startShowAdminEditor'));
     	$data = '<textarea name="'.$name.'" id="'.$id.'" class="'.$class.'">'.$content.'</textarea>';
     	eval(callHook('endShowAdminEditor'));
     	echo $data;
     }

     // affiche un input hidden contenant le token (admin)
     public static function showAdminTokenField() {
     	eval(callHook('startShowAdminTokenField'));
     	$output = '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
     	eval(callHook('endShowAdminTokenField'));
     	echo $output;
     }
   
     // affiche le contenu de la meta title (theme)
     public static function showTitleTag() {
     	global $runPlugin;
     	eval(callHook('startShowtitleTag'));
     	$data = $runPlugin->getTitleTag();
     	eval(callHook('endShowtitleTag'));
     	echo $data;
     }

     // affiche le contenu de la meta description (theme)
     public static function showMetaDescriptionTag() {
     	global $runPlugin;
     	eval(callHook('startShowMetaDescriptionTag'));
     	$data = $runPlugin->getMetaDescriptionTag();
     	eval(callHook('endShowMetaDescriptionTag'));
     	echo $data;
     }

     // affiche le titre de page (theme)
     public static function showMainTitle($format = '<h1>[mainTitle]</h1>') {
     	global $runPlugin;
     	eval(callHook('startShowMainTitle'));
     	if(getCoreConf('hideTitles') == 0 && $runPlugin->getMainTitle() != ''){
     		$data = $format;
     		$data = str_replace('[mainTitle]', $runPlugin->getMainTitle(), $data);
     	}
     	else $data = '';
     	eval(callHook('endShowMainTitle'));
     	echo $data;
     }

     // affiche le nom du site (theme)
     public static function showSiteName() {
     	eval(callHook('startShowSiteName'));
     	$data = getCoreConf('siteName');
     	eval(callHook('endShowSiteName'));
     	echo $data;
     }

     // affiche la escription du site (theme)
     public static function showSiteDescription() {
     	eval(callHook('startShowSiteDescription'));
     	$data = getCoreConf('siteDescription');
     	eval(callHook('endShowSiteDescription'));
     	echo $data;
     }

     // affiche l'url du site (theme)
     public static function showSiteUrl() {
     	eval(callHook('startShowSiteUrl'));
     	$data = getCoreConf('siteUrl');
     	eval(callHook('endShowSiteUrl'));
     	echo $data;
     }

     // affiche la langue courante (theme)
     public static function showSiteLang() {
     	eval(callHook('startShowSiteLang'));
     	$data = getCoreConf('siteLang');
     	eval(callHook('endShowSiteLang'));
     	echo $data;
     }

     // affiche le temps d'execution (theme)
     public static function showExecTime() {
     	global $time;
     	eval(callHook('startShowExecTime'));
     	$data = round(microtime(true) - $time, 3);
     	eval(callHook('endShowExecTime'));
     	echo $data;
     }

     // affiche la navigation principale (theme)
     public static function showMainNavigation($format = '<li><a href="[target]">[label]</a></li><li class="divider"></li>') {
     	global $pluginsManager;
     	$data = '';
     	eval(callHook('startShowMainNavigation'));
     	foreach($pluginsManager->getPlugins() as $k=>$plugin) if($plugin->getConfigval('activate') == 1){
     		foreach($plugin->getNavigation() as $k2=>$item){
     			$temp = $format;
     			$temp = str_replace('[target]', $item['target'], $temp);
     			$temp = str_replace('[label]', $item['label'], $temp);
     			$temp = str_replace('[targetAttribut]', $item['targetAttribut'], $temp);
     			$data.= $temp;
     		}
     	}
     	eval(callHook('endShowMainNavigation'));
     	echo $data;
     }

     // affiche le theme courant (theme)
     public static function showTheme($format = '<a onclick="window.open(this.href);return false;" href="[authorWebsite]">[name]</a>') {
     	global $themes;
     	eval(callHook('startShowTheme'));
     	$data = $format;
     	$data = str_replace('[authorWebsite]', $themes[getCoreConf('theme')]['authorWebsite'], $data);
     	$data = str_replace('[author]', $themes[getCoreConf('theme')]['author'], $data);
     	$data = str_replace('[name]', $themes[getCoreConf('theme')]['name'], $data);
     	eval(callHook('endShowTheme'));
     	echo $data;
     }

     // affiche le contenu de la sidebar (theme)
     public static function showSidebarItems($format = '<div class="panel" id="[id]"><h2>[title]</h2>[content]</div>') {
     	global $pluginsManager;
     	$data = '';
     	eval(callHook('startShowSidebarItems'));
     	foreach($pluginsManager->getPlugins() as $k=>$plugin) if($plugin->getConfigval('activate') == 1){
     		if($plugin->getConfigVal('sidebarTitle') != '' && $plugin->getConfigVal('sidebarCallFunction') != ''){
     			$temp = $format;
     			$temp = str_replace('[id]', 'sidebaritem-'.$plugin->getName(), $temp);
     			$temp = str_replace('[title]', $plugin->getConfigVal('sidebarTitle'), $temp);
     			$temp = str_replace('[content]', call_user_func($plugin->getConfigVal('sidebarCallFunction')), $temp);
     			$data.= $temp;
     		}
     	}
     	eval(callHook('endShowSidebarItems'));
     	echo $data;
     }

     // affiche l'identifiant du plugin courant (theme)
     public static function showPluginId(){
     	global $runPlugin;
     	eval(callHook('startShowPluginId'));
     	$data = $runPlugin->getName();
     	eval(callHook('endShowPluginId'));
     	echo $data;
     }
    
}

?>