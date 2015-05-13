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


// sauvagarde la configuration du core (prise en charge de nouvelles valeures via $append)
/*function saveConfig($val, $append = array()){
	$config = utilReadJsonFile(DATA.'config.txt', true);   
	$config = array_merge($config, $append);
	foreach($config as $k=>$v) if(isset($val[$k])) $config[$k] = $val[$k];
	return utilWriteJsonFile(DATA.'config.txt', $config);
}*/

// hash une chaine
/*function encrypt($data){
	return hash_hmac('sha1', $data, KEY);
}*/

// Retourne une erreur 404 Document non trouvé
function error404(){
	$core = core::getInstance();
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	include_once(THEMES.$core->getConfigVal('theme').'/404.php');	
	die();
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