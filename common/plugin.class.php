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
/************************************************
** Classes responsables de la gestion des plugins
************************************************/

class pluginsManager{

	private $plugins; // liste des plugins (alimentée par la méthode loadPlugin)
	private static $instance = null;
	
	/*
	** Constructeur
	*/
	public function __construct(){
		$this->plugins = $this->listPlugins();
	}
	
	/*
	** Retourne la liste des plugins
	** Si la liste est vide (plugins non chargés) la méthode listPlugins est appelée
	** @return : array (objets plugins)
	*/
	public function getPlugins(){
		return $this->plugins;
	}
	
	/*
	** Retourne un plugin
	** @return : object (plugin)
	*/
	public function getPlugin($name){
		foreach($this->plugins as $plugin){
			if($plugin->getName() == $name) {
				return $plugin;
			}
		}
		return false;
	}
	
	/*
	** Sauvegarde la configuration d'un plugin
	** @param : object (plugin)
	** @return: true / false
	*/
	public function savePluginConfig($obj){
		if($obj->getIsValid() && $path = $obj->getDataPath()){
		    return utilWriteJsonFile($path.'config.txt', $obj->getConfig());
			//if(@file_put_contents($path.'config.txt', json_encode($obj->getConfig()), 0666)) return true;
		}
		//return false;
	}
	
	/*
	** Créée un plugin et alimente le tableau des plugins
	** Cette méthode est appelée durant la phase de chargement / installation des plugins
	** Il n'est pas nécessaire de la rappeler !!!!
	** @param : string (nom du plugin), array (configuration du plugin)
	*/
	public function loadPlugin($name){
		$this->plugins[] = $this->createPlugin($name);
	}

	/*
	** Installe un plugin
	** Cette méthode est appelée durant la phase de chargement / installation des plugins
	** Il n'est pas nécessaire de la rappeler !!!!
	** @param : string (nom du plugin)
	** @return : true / false
	*/
	public function installPlugin($name){
		@mkdir(DATA_PLUGIN .$name.'/', 0777);
		@chmod(DATA_PLUGIN .$name.'/', 0777);
		@file_put_contents(DATA_PLUGIN .$name.'/config.txt', file_get_contents(PLUGINS .$name.'/param/config.json'), 0666);
		@chmod(DATA_PLUGIN .$name.'/config.txt', 0666);
		if(function_exists($name.'Install')) call_user_func($name.'Install');
		if(!file_exists(DATA_PLUGIN .$name.'/config.txt')) return false;
		return true;
	}
	
	/*
	** Liste le répertoire des plugins et retourne une liste d'objets plugins
	** Les plugins créés sont incomplets (valeurs de configuration uniquement)
	** Cette méthode est appellée par la méthode getPlugins
	** @return : array (objets plugins)
	*/
	private function listPlugins(){
		$data = array();
		$dataNotSorted = array();
		$items = utilScanDir(PLUGINS);
		
		foreach($items['dir'] as $dir){
			// les plugins non installés ont une priorité faible
			if(file_exists(DATA_PLUGIN .$dir. '/config.txt')) $dataNotSorted[$dir] = utilReadJsonFile(DATA_PLUGIN .$dir. '/config.txt', true);
			//if(file_exists(DATA_PLUGIN .$dir. '/config.txt')) $dataNotSorted[$dir] = json_decode(@file_get_contents(DATA_PLUGIN .$dir. '/config.txt'), true);
			else $dataNotSorted[$dir]['priority'] = '10';
		}
		$dataSorted = utilSort2DimArray($dataNotSorted, 'priority', 'num');
		foreach($dataSorted as $plugin=>$config){
			$data[] = $this->createPlugin($plugin);
		}
		return $data;
	}
	
	/*
	** Crée un objet plugin
	** Cette méthode est appellée par la méthode listPlugins ou loadPlugin
	** @param : string (nom du plugin), array (configuration du plugin)
	*/
	private function createPlugin($name){
		$infos = utilReadJsonFile(PLUGINS .$name. '/param/infos.json');
		$config = utilReadJsonFile(DATA_PLUGIN .$name. '/config.txt');
		$hooks = utilReadJsonFile(PLUGINS .$name. '/param/hooks.json');
		$initConfig = utilReadJsonFile(PLUGINS .$name. '/param/config.json');
		if(!is_array($config)) $config = array();
		if(!is_array($hooks)) $hooks = array();
		$plugin = new plugin($name, $config, $infos, $hooks, $initConfig);
		if(!$plugin->isInstalled()) {
			$this->installPlugin($plugin->getName());
		}
		return $plugin;
	}
	
	/*
	** Static
	** Singleton pluginsManager
	*/
	public static function getInstance(){
		if(is_null(self::$instance)) {
			self::$instance = new pluginsManager();
		}
		return self::$instance;
	}
	
	/*
	** Static
	** Retourne la valeur de configuration ciblée d'un plugin
	*/
	public static function getPluginConfVal($pluginName, $kConf){
		$instance = self::getInstance();
		$plugin = $instance->getPlugin($pluginName);
		return $plugin->getConfigVal($kConf);
	}
	
	/*
	** Static
	** Détermine si le plugin ciblé est présent et actif
	** @param : string (nom du plugin)
	*/
	public static function isActivePlugin($pluginName){
		$instance = self::getInstance();
		$plugin = $instance->getPlugin($pluginName);
		if($plugin && $plugin->isInstalled() && $plugin->getConfigval('activate')) return true;
		return false;
	}

}

class plugin{
	private $infos;
	private $config;
	private $name;
	private $hooks;
	private $isValid;
	private $isDefaultPlugin;
	private $titleTag;
	private $metaDescriptionTag;
	private $mainTitle;
	private $libFile;
	private $publicFile;
	private $adminFile;
	private $cssFile;
	private $jsFile;
	private $breadcrumb;
	private $dataPath;
	private $publicTemplate;
	private $adminTemplate;
	private $configTemplate;
	private $initConfig;
	private $navigation;
	private $adminTabs;
	private $langFile;
	private $lang;

	/*
	** Constructeur
	*/
	public function __construct($name, $config = array(), $infos = array(), $hooks = array(), $initConfig = array()){
		$this->name = $name;
		$this->config = $config;
		$this->infos = $infos;
		$this->hooks = $hooks;
		$this->isValid = true;
		$this->isDefaultPlugin = ($name == DEFAULT_PLUGIN) ? true : false;
		$this->setTitleTag($infos['name']);
		$this->setMainTitle($infos['name']);
		$this->libFile = (file_exists(PLUGINS .$this->name.'/'.$this->name.'.php')) ? PLUGINS .$this->name.'/'.$this->name.'.php' : false;
		$this->langFile = (file_exists(PLUGINS .$this->name.'/lang/'.getCoreConf('siteLang').'.json')) ? PLUGINS .$this->name.'/lang/'.getCoreConf('siteLang').'.json' : false;
		$this->lang = ($this->langFile) ? utilReadJsonFile($this->langFile) : array();
		$this->publicFile = (file_exists(PLUGINS .$this->name.'/public.php')) ? PLUGINS .$this->name.'/public.php' : false;
		$this->adminFile = (file_exists(PLUGINS .$this->name.'/admin.php')) ? PLUGINS .$this->name.'/admin.php' : false;
		$this->cssFile = (file_exists(PLUGINS .$this->name.'/other/'.$this->name.'.css')) ? PLUGINS .$this->name.'/other/'.$this->name.'.css' : false;
		$this->jsFile = (file_exists(PLUGINS .$this->name.'/other/'.$this->name.'.js')) ? PLUGINS .$this->name.'/other/'.$this->name.'.js' : false;
		$this->addToBreadcrumb($infos['name'], 'index.php?p='.$this->name);
		if($this->isDefaultPlugin) $this->initBreadcrumb();
		$this->dataPath = (is_dir(DATA_PLUGIN .$this->name)) ? DATA_PLUGIN .$this->name.'/' : false;
		if(file_exists('theme/'.getCoreConf('theme').'/'.$this->name.'.php')) $this->publicTemplate = 'theme/'.getCoreConf('theme').'/'.$this->name.'.php';
		elseif(file_exists(PLUGINS .$this->name.'/template/public.php')) $this->publicTemplate = PLUGINS .$this->name.'/template/public.php';
		else $this->publicTemplate = false;
		$this->adminTemplate = (file_exists(PLUGINS .$this->name.'/template/admin.php')) ? PLUGINS .$this->name.'/template/admin.php' : false;
		$this->configTemplate = (file_exists(PLUGINS .$this->name.'/template/config.php')) ? PLUGINS .$this->name.'/template/config.php': false;
		$this->initConfig = $initConfig;
		$this->navigation = array();
		// tabs
		$this->adminTabs = array();
		if(isset($this->config['adminTabs']) && $this->config['adminTabs'] != '') $this->adminTabs = explode(',', $this->config['adminTabs']);
		// admin multi templates (tabs)
		foreach($this->adminTabs as $k=>$v){
			if(file_exists(PLUGINS .$this->name.'/template/admin-tab-'.$k.'.php')){
				if(!is_array($this->adminTemplate)) $this->adminTemplate = array();
				$this->adminTemplate[] = PLUGINS .$this->name.'/template/admin-tab-'.$k.'.php';
			}
		}
	}

	/*
	** getters
	*/
	public function getConfigVal($val){
		if(isset($this->config[$val])) return $this->config[$val];
	}
	public function getConfig(){
		return $this->config;
	}
	public function getInfoVal($val){
		return $this->infos[$val];
	}
	public function getName(){
		return $this->name;
	}
	public function getHooks(){
		return $this->hooks;
	}
	public function getIsDefaultPlugin(){
		return $this->isDefaultPlugin;
	}
	public function getTitleTag(){
		return $this->titleTag;
	}
	public function getMetaDescriptionTag(){
		return $this->metaDescriptionTag;
	}
	public function getMainTitle(){
		return $this->mainTitle;
	}
	public function getLibFile(){
		return $this->libFile;
	}
	public function getPublicFile(){
		return $this->publicFile;
	}
	public function getAdminFile(){
		return $this->adminFile;
	}
	public function getCssFile(){
		return $this->cssFile;
	}
	public function getJsFile(){
		return $this->jsFile;
	}
	public function getBreadcrumb(){
		return $this->breadcrumb;
	}
	public function getDataPath(){
		return $this->dataPath;
	}
	public function getPublicTemplate(){
		return $this->publicTemplate;
	}
	public function getAdminTemplate(){
		return $this->adminTemplate;
	}
	public function getConfigTemplate(){
		return $this->configTemplate;
	}
	public function getIsValid(){
		return $this->isValid;
	}
	public function getNavigation(){
		return $this->navigation;
	}
	public function getAdminTabs(){
		return $this->adminTabs;
	}
	public function getLangFile(){
		return $this->langFile;
	}
	public function getLang(){
		return $this->lang;
	}

	/*
	** setters
	*/
	public function setConfigVal($k, $v){
		$this->config[$k] = $v;
		if($k == 'activate' && $v < 1 && $this->isDefaultPlugin) $this->isValid = false;
	}
	public function setTitleTag($val){
		if($this->isDefaultPlugin) $val = getCoreConf('siteName').' | '.trim($val);
		else $val = $val.' | '.getCoreConf('siteName');
		if(mb_strlen($val) > 50) $val = mb_strcut($val, 0, 50).'...';
		$this->titleTag = $val;
	}
	public function setMetaDescriptionTag($val){
		$val = trim($val);
		if(mb_strlen($val) > 150) $val = mb_strcut($val, 0, 150).'...';
		$this->metaDescriptionTag = $val;
	}
	public function setMainTitle($val){
		$val = trim($val);
		$this->mainTitle = $val;
	}

	/*
	** Ajoute un élément au fil d'Ariane
	** @param : string (intitulé du lien), string (URL du lien)
	*/
	function addToBreadcrumb($label, $target){
		$this->breadcrumb[] = array('label' => $label, 'target' => $target);
	}

	/*
	** Supprime un élément du fil d'Ariane
	** @param : int (clé à supprimer)
	*/
	function removeToBreadcrumb($k){
		unset($this->breadcrumb[$k]);
	}

	/*
	** Initialise le fil d'Ariane
	*/
	function initBreadcrumb(){
		$this->breadcrumb = array();
	}
	
	/*
	** Ajoute un élément dans la navigation
	** @param : string (intitulé du lien), string (URL du lien), string (attribut target)
	*/
	function addToNavigation($label, $target, $targetAttribut = '_self'){
		$this->navigation[] = array('label' => $label, 'target' => $target, 'targetAttribut' => $targetAttribut);
	}
	
	/*
	** Supprime un élément de la navigation
	** @param : int (clé à supprimer)
	*/
	function removeToNavigation($k){
		unset($this->navigation[$k]);
	}

	/*
	** Initialise la navigation
	*/
	function initNavigation(){
		$this->navigation = array();
	}

	/*
	** Détermine si le plugin est installé / updaté
	** @return : true / false
	*/
	public function isInstalled(){
		$currentConfig = implode(',', array_keys($this->config));
		$initConfig = implode(',', array_keys($this->initConfig));
		if(count($this->config) < 1 || $currentConfig != $initConfig) return false;
		return true;
	}
}
?>