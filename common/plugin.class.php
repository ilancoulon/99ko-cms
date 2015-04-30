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
 * classe plugin
 *
 */

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
	private $dataPath;
	private $publicTemplate;
	private $adminTemplate;
	private $initConfig;
	private $navigation;
	private $adminTabs;
	private $langFile;
	private $lang;
	private $publicCssFile;
	private $publicJsFile;
	private $adminCssFile;
	private $adminJsFile;

	public function __construct($name, $config = array(), $infos = array(), $hooks = array(), $initConfig = array()){
		// nom simplifie du plugin
		$this->name = $name;
		// configuration du plugin
		$this->config = $config;
		// informations relatives au plugin
		$this->infos = $infos;
		// liste des hooks du plugins
		$this->hooks = $hooks;
		// validite du plugin (si false l'etat ou la configuration du plugin ne doit pas etre sauvegarde)
		$this->isValid = true;
		// ce plugin est-il le plugin par defaut specifie dans la configuration du core ?
		$this->isDefaultPlugin = ($name == DEFAULT_PLUGIN) ? true : false;
		// on defini la meta title
		$this->setTitleTag($infos['name']);
		// on defini le titre de page
		$this->setMainTitle($infos['name']);
		// chemin vers le fichier principal du plugin
		$this->libFile = (file_exists(PLUGINS .$this->name.'/'.$this->name.'.php')) ? PLUGINS .$this->name.'/'.$this->name.'.php' : false;
		// chemin vers le fichier langue du plugin
		$this->langFile = (file_exists(PLUGINS .$this->name.'/lang/'.getCoreConf('siteLang').'.json')) ? PLUGINS .$this->name.'/lang/'.getCoreConf('siteLang').'.json' : false;
		// tableau lang
		$this->lang = ($this->langFile) ? utilReadJsonFile($this->langFile) : array();
		// chemin vers le controlleur en mode public
		$this->publicFile = (file_exists(PLUGINS .$this->name.'/public.php')) ? PLUGINS .$this->name.'/public.php' : false;
		// chemin vers le controlleur en mode admin
		$this->adminFile = (file_exists(PLUGINS .$this->name.'/admin.php')) ? PLUGINS .$this->name.'/admin.php' : false;
		// chemin vers le fichier css du plugin
		$this->cssFile = (file_exists(PLUGINS .$this->name.'/other/'.$this->name.'.css')) ? PLUGINS .$this->name.'/other/'.$this->name.'.css' : false; // déprécié
		$this->publicCssFile = (file_exists(PLUGINS .$this->name.'/other/public.css')) ? PLUGINS .$this->name.'/other/public.css' : false;
		$this->adminCssFile = (file_exists(PLUGINS .$this->name.'/other/admin.css')) ? PLUGINS .$this->name.'/other/admin.css' : false;
		// chemin vers le fichier js du plugin
		$this->jsFile = (file_exists(PLUGINS .$this->name.'/other/'.$this->name.'.js')) ? PLUGINS .$this->name.'/other/'.$this->name.'.js' : false; //déprécié
		$this->publicJsFile = (file_exists(PLUGINS .$this->name.'/other/public.js')) ? PLUGINS .$this->name.'/other/public.js' : false;
		$this->adminJsFile = (file_exists(PLUGINS .$this->name.'/other/admin.js')) ? PLUGINS .$this->name.'/other/admin.js' : false;
		// chemin vers le dossier data du plugin
		$this->dataPath = (is_dir(DATA_PLUGIN .$this->name)) ? DATA_PLUGIN .$this->name.'/' : false;
		// template en mode public (peut etre la template par defaut ou une template personalisee presente dans le dossier du theme)
		if(file_exists('theme/'.getCoreConf('theme').'/'.$this->name.'.php')) $this->publicTemplate = 'theme/'.getCoreConf('theme').'/'.$this->name.'.php';
		elseif(file_exists(PLUGINS .$this->name.'/template/public.php')) $this->publicTemplate = PLUGINS .$this->name.'/template/public.php';
		else $this->publicTemplate = false;
		// template en mode admin (peut etre string si une seule template ou array si la navigation par tabs existe pour ce plugin)
		$this->adminTemplate = (file_exists(PLUGINS .$this->name.'/template/admin.php')) ? PLUGINS .$this->name.'/template/admin.php' : false;
		// configuration "d'uzine" du plugin
		$this->initConfig = $initConfig;
		// initialisation des items de navigation
		$this->navigation = array();
		// tabs admin
		$this->adminTabs = array();
		if(isset($this->config['adminTabs']) && $this->config['adminTabs'] != '') $this->adminTabs = explode(',', $this->config['adminTabs']);
		// templates si la navigation par tabs sont actives pour ce plugin
		foreach($this->adminTabs as $k=>$v){
			if(file_exists(PLUGINS .$this->name.'/template/admin-tab-'.$k.'.php')){
				if(!is_array($this->adminTemplate)) $this->adminTemplate = array();
				$this->adminTemplate[] = PLUGINS .$this->name.'/template/admin-tab-'.$k.'.php';
			}
		}
	}

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
	
	public function getPublicCssFile(){
		return $this->publicCssFile;
	}
	
	public function getAdminCssFile(){
		return $this->adminCssFile;
	}
	
	public function getJsFile(){
		return $this->jsFile;
	}
	
	public function getPublicJsFile(){
		return $this->publicJsFile;
	}
	
	public function getAdminJsFile(){
		return $this->adminJsFile;
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

	// permet de modifier une valeur de config
	public function setConfigVal($k, $v){
		$this->config[$k] = $v;
		if($k == 'activate' && $v < 1 && $this->isDefaultPlugin) $this->isValid = false;
	}
	
	// permet de surcharger la meta title
	public function setTitleTag($val){
		if($this->isDefaultPlugin) $val = getCoreConf('siteName').' | '.trim($val);
		else $val = $val.' | '.getCoreConf('siteName');
		if(mb_strlen($val) > 50) $val = mb_strcut($val, 0, 50).'...';
		$this->titleTag = $val;
	}
	
	// permet de surcharger la meta description
	public function setMetaDescriptionTag($val){
		$val = trim($val);
		if(mb_strlen($val) > 150) $val = mb_strcut($val, 0, 150).'...';
		$this->metaDescriptionTag = $val;
	}
	
	// permet de surcharger le titre de page
	public function setMainTitle($val){
		$val = trim($val);
		$this->mainTitle = $val;
	}
	
	// ajoute un item menu
	function addToNavigation($label, $target, $targetAttribut = '_self'){
		$this->navigation[] = array('label' => $label, 'target' => $target, 'targetAttribut' => $targetAttribut);
	}
	
	// supprime un item menu
	function removeToNavigation($k){
		unset($this->navigation[$k]);
	}

	// initialise les items menu
	function initNavigation(){
		$this->navigation = array();
	}

	// determine si le plugin est installe ou si le fichier config est coherent avec la config uzine
	public function isInstalled(){
		$currentConfig = implode(',', array_keys($this->config));
		$initConfig = implode(',', array_keys($this->initConfig));
		if(count($this->config) < 1 || $currentConfig != $initConfig) return false;
		elseif(isset($currentConfig['adminTabs'])){
			if($currentConfig['adminTabs'] != $initConfig['adminTabs']) return false;
		}
		return true;
	}
}
?>
