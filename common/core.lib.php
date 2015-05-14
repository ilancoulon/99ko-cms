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

// Retourne une erreur 404 Document non trouvé
function error404(){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	include_once(THEMES.getCoreConf('theme').'/404.php');	
	die();
}

// detecte si une nouvelle version du core existe en ligne
function newVersion($url){
	if($last = trim(@file_get_contents($url))) if($last != VERSION) return $last;
	return false;
}

// cache
function addToCache(){
	global $urlParams;
	if(!$data = util::readJsonFile(DATA.'cache.json', true)){
		$data = array();
		util::writeJsonFile(DATA. 'cache.json', $data);
	}
	$content = preg_replace(array('/ {2,}/', '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'), array(' ', ''), ob_get_contents());
	$key = $urlParams[0].'_'.md5(implode(',', array_values($urlParams)));
	$time = time();
	if(isset($data[$key])){
		$data[$key]['expire'] = time() + CACHE_TIME;
		$data[$key]['content'] = $content;
	}
	else{
		$data[$key]['expire'] = time() + CACHE_TIME;
		$data[$key]['content'] = $content;
	}
	return util::writeJsonFile(DATA. 'cache.json', $data);
}

function readCache(){
	global $urlParams;
	if($data = util::readJsonFile(DATA.'cache.json', true)){
		$key = $urlParams[0].'_'.md5(implode(',', array_values($urlParams)));
		if(!isset($data[$key])){
			return -1;
		}
		if(time() > $data[$key]['expire']){
			return 0;
		}
		return $data[$key]['content'];
	}
	return -1;
}

function clearCache(){
	util::writeJsonFile(DATA. 'cache.json', array());
}
?>