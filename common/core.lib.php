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

defined('ROOT') OR exit('No direct script access allowed');

/*
 * lib core
 * fonctions diversses
 *
 */

// includes
include_once('util.class.php');
include_once('pluginsManager.class.php');
include_once('plugin.class.php');
include_once('show.class.php');
include_once('alias.lib.php');

// retourne le tableau de configuration du core (complet ou une valeur sivant le parametre $k)
function getCoreConf($k = ''){
	global $coreConf;
	$data = ($coreConf) ? $coreConf : utilReadJsonFile(DATA.'config.txt', true);
	if($k != '') return $data[$k];
	else return $data;
}

// sauvagarde la configuration du core (prise en charge de nouvelles valeures via $append)
function saveConfig($val, $append = array()){
	$config = utilReadJsonFile(DATA.'config.txt', true);   
	$config = array_merge($config, $append);
	foreach($config as $k=>$v) if(isset($val[$k])) $config[$k] = $val[$k];
	return utilWriteJsonFile(DATA.'config.txt', $config);
}

// appelle un hook
function callHook($hookName){
	global $hooks;
	$return = '';
	if(isset($hooks[$hookName])) foreach($hooks[$hookName] as $function) $return.= call_user_func($function);
	return $return;
}

// ajoute un hook a appeller
function addHook($hookName, $function){
	global $hooks;
	$hooks[$hookName][] = $function;
}

// retourne la liste des themes
function listThemes(){
	$data = array();
	$items = utilScanDir(THEMES);
	foreach($items['dir'] as $file){
		$data[$file] = getThemeInfos($file);
		$screenshot = THEMES.$file.'/screenshot.jpg';
		if(!file_exists($screenshot)) $screenshot = '';	
		$data[$file]['screenshot'] = $screenshot;
	}
	return $data;
}

// detecte l'url de base
function getSiteUrl(){
        $siteUrl = str_replace(array('install.php', '/admin/index.php'), array('', ''), $_SERVER['SCRIPT_NAME']);
        $isSecure = false;
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') $isSecure = true;
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') $isSecure = true;
        $REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';
        $siteUrl = $REQUEST_PROTOCOL.'://'.$_SERVER['HTTP_HOST'].$siteUrl;
        $pos = mb_strlen($siteUrl)-1;
        if($siteUrl[$pos] == '/') $siteUrl = substr($siteUrl, 0, -1);
        return $siteUrl;
}

// retourne les infos d'un theme
function getThemeInfos($name){
    return utilReadJsonFile(THEMES.$name.'/infos.json', true);
}

// reecris une url ou retourne l'url originale suivant l'etat d'activation de l'url rewriting
function rewriteUrl($plugin, $params = array()){
	if(getCoreConf('urlRewriting') == 1){
		$url = $plugin.'/';
		if(count($params) > 0){
			foreach($params as $k=>$v) $url.= utilStrToUrl($v).',';
			$url = trim($url, ',');
			$url.= '.html';
		}
	}
	else{
		$url = 'index.php?p='.$plugin;
		foreach($params as $k=>$v) $url.= '&amp;'.$k.'='.utilStrToUrl($v);
	}
	return $url;
}

// retourne les parametres de l'url ($_GET)
function getUrlParams(){
	$data = array();
	if(getCoreConf('urlRewriting') == 1){
		if(isset($_GET['param'])) $data = explode(',', $_GET['param']);
	}
	else{
		foreach($_GET as $k=>$v) if($k != 'p'){
			$data[] = $v;
		}
	}
	return $data;
}

// hash une chaine
function encrypt($data){
	return hash_hmac('sha1', $data, KEY);
}

// retourne la liste des langues
function listLangs(){
	$data = array('en');
	$items = utilScanDir(LANG);
	foreach($items['file'] as $k=>$v) $data[] = substr($v, 0, 2);
	return $data;
}

// formate une phrase suivant la lang
function lang($k){
	global $lang;
	if(getCoreConf('siteLang') == 'en') return $k;
	elseif (is_array($lang) && array_key_exists($k, $lang)) return $lang[$k];
	else return $k;
}

// retourne la page d'erreur 404
function error404(){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	$url = getCoreConf('siteUrl');
	$lang = getCoreConf('siteLang');
	$msg = lang("The requested page does not exist.", "core");
	$back = lang("Back to website", "core");
	echo '<!DOCTYPE html>
	<html lang="'.$lang.'">
	<head>
	<meta charset="utf-8" />
	<title>404</title>
	</head>
	<body>
	<p>'.$msg.'<br /><< <a href="'.$url.'">'.$back.'</a></p>
	</body>
	</html>';
	die();
}

// detecte si une nouvelle version du core existe en ligne
function newVersion($url){
	if($last = @file_get_contents($url)) if($last != VERSION) return $last;
	return false;
}

// retourne la liste des timezones
function listTimeZones(){
	return utilReadJsonFile(TIMEZONES);
}

// determine si il faut afficher la sidebar dans le theme
function useSidebar(){
	global $pluginsManager;
	$sidebar = false;
	foreach($pluginsManager->getPlugins() as $k=>$plugin) if($plugin->getConfigval('activate') == 1){
		if($plugin->getConfigVal('sidebarTitle') != '' && $plugin->getConfigVal('sidebarCallFunction') != ''){
			$sidebar = true;
		}
	}
	return $sidebar;
}

// affiche le gravatar
function profil_img($email, $size, $default, $rating) {	
   $pic = explode('@',$email);
   # Récupère l'image en cache du profil.
   $profile_image = UPLOAD.$pic[0].'.jpg';
	
   # On met en cache l'image si elle n'existe pas !
   if (!file_exists($profile_image)) {
    	 $image_url = 'https://secure.gravatar.com/avatar/' .md5(strtolower(trim($email))). '&default='.$default.'&size='.$size.'&rating='.$rating;
    	 $image = file_get_contents($image_url);
    	 file_put_contents(UPLOAD.$pic[0].'.jpg', $image);
   }	
   # Retourne l'image.
   return '<img src="' .$profile_image. '" class="th radius" width="'.$size.'" height="'.$size.'" alt="profil" />';
}
?>