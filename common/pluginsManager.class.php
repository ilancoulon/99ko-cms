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
 * classe pluginsManager
 *
 */

class pluginsManager{

	private $plugins;
	private static $instance = null;
	
	// constructeur
	public function __construct(){
		// liste des plugins
		$this->plugins = $this->listPlugins();
	}
	
	// retourne la liste des plugins
	public function getPlugins(){
		return $this->plugins;
	}
	
	// retourne un objet "plugin"
	public function getPlugin($name){
		foreach($this->plugins as $plugin){
			if($plugin->getName() == $name) {
				return $plugin;
			}
		}
		return false;
	}
	
	// sauvegarde la configuration d'un plugin
	public function savePluginConfig($obj){
		// l'objet doit etre "valide" et son dossier data existant
		if($obj->getIsValid() && $path = $obj->getDataPath()){
		    return utilWriteJsonFile($path.'config.txt', $obj->getConfig());
		}
	}
	
	// alimente la liste des plugins en creant le plugin cible
	public function loadPlugin($name){
		$this->plugins[] = $this->createPlugin($name);
	}

	// installe un plugin
	public function installPlugin($name){
		// creation du dossier data
		@mkdir(DATA_PLUGIN .$name.'/', 0777);
		@chmod(DATA_PLUGIN .$name.'/', 0777);
		// creation du fichier de config
		@file_put_contents(DATA_PLUGIN .$name.'/config.txt', file_get_contents(PLUGINS .$name.'/param/config.json'), 0666);
		@chmod(DATA_PLUGIN .$name.'/config.txt', 0666);
		// appel de la fonction d'installation du plugin
		if(function_exists($name.'Install')) call_user_func($name.'Install');
		// check du fichier config avant retour
		if(!file_exists(DATA_PLUGIN .$name.'/config.txt')) return false;
		return true;
	}
	
	// genere la liste des plugins
	private function listPlugins(){
		$data = array();
		$dataNotSorted = array();
		$items = utilScanDir(PLUGINS);
		foreach($items['dir'] as $dir){
			// si le plugin est installe on recupere sa configuration
			if(file_exists(DATA_PLUGIN .$dir. '/config.txt')) $dataNotSorted[$dir] = utilReadJsonFile(DATA_PLUGIN .$dir. '/config.txt', true);
			// sinon on lui attribu une priorité faible
			else $dataNotSorted[$dir]['priority'] = '10';
		}
		// on tri les plugins par priorite
		$dataSorted = utilSort2DimArray($dataNotSorted, 'priority', 'num');
		foreach($dataSorted as $plugin=>$config){
			// creation de l'objet "plugin"
			$data[] = $this->createPlugin($plugin);
		}
		return $data;
	}
	
	// cree un objet "plugin"
	private function createPlugin($name){
		// infos du plugin
		$infos = utilReadJsonFile(PLUGINS .$name. '/param/infos.json');
		// configuration du plugin
		$config = utilReadJsonFile(DATA_PLUGIN .$name. '/config.txt');
		// hooks du plugin
		$hooks = utilReadJsonFile(PLUGINS .$name. '/param/hooks.json');
		// configuration "d'uzine"
		$initConfig = utilReadJsonFile(PLUGINS .$name. '/param/config.json');
		// derniers checks
		if(!is_array($config)) $config = array();
		if(!is_array($hooks)) $hooks = array();
		$plugin = new plugin($name, $config, $infos, $hooks, $initConfig);
		// si le plugin n'est pas installe on l'installe
		if(!$plugin->isInstalled()) {
			$this->installPlugin($plugin->getName());
		}
		return $plugin;
	}
	
	// singleton (static)
	public static function getInstance(){
		if(is_null(self::$instance)) {
			self::$instance = new pluginsManager();
		}
		return self::$instance;
	}
	
	// retourne une valeur de configuration d'un plugin (static)
	public static function getPluginConfVal($pluginName, $kConf){
		$instance = self::getInstance();
		$plugin = $instance->getPlugin($pluginName);
		return $plugin->getConfigVal($kConf);
	}
	
	// determine si le plugin cible existe et s'il est actif (static)
	public static function isActivePlugin($pluginName){
		$instance = self::getInstance();
		$plugin = $instance->getPlugin($pluginName);
		if($plugin && $plugin->isInstalled() && $plugin->getConfigval('activate')) return true;
		return false;
	}

}
?>