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
// on declare ROOT
define('ROOT', '../');
// on inclu le fichier common
include_once(ROOT.'common/common.php');
// on genere le jeton
if(!isset($_SESSION['token'])) $_SESSION['token'] = sha1(uniqid(mt_rand()));
// on check le jeton
if(in_array(ACTION, array('delinstallfile', 'save', 'del', 'saveconfig', 'saveplugins', 'login', 'logout')) && $_REQUEST['token'] != $_SESSION['token']){	
	include_once('login.php');
	die();
}
// Variables de template
$msg = '';
$msgType = '';
$config = $coreConf;
$data['msg'] = ''; // retro compatibilité
$version = VERSION;
$token = $_SESSION['token'];
$data['token'] = $token; // retro compatibilité
$pluginName = $runPlugin->getName();
$data['pluginName'] = $pluginName; // retro compatibilité
$navigation[-1]['label'] = lang('Home');
$navigation[-1]['url'] = './';
$navigation[-1]['isActive'] = (!isset($_GET['p'])) ? true : false;
foreach($pluginsManager->getPlugins() as $k=>$v) if($v->getConfigVal('activate') && $v->getAdminFile()){
	$navigation[$k]['label'] = $v->getInfoVal('name');
	$navigation[$k]['url'] = 'index.php?p='.$v->getName();
	$navigation[$k]['isActive'] = (isset($_GET['p']) && $_GET['p'] == $v->getName()) ? true : false;
}
$pluginConfigTemplate = (!isset($_GET['p'])) ? false :$runPlugin->getConfigTemplate();
$pageTitle = (!isset($_GET['p'])) ? lang('Welcome to 99ko') : $runPlugin->getInfoVal('name');
$tabs = array();
foreach($runPlugin->getAdminTabs() as $k=>$v){
	$tabs[$k]['label'] = $v;
	$tabs[$k]['url'] = '#tab-'.$k;
}
if(count($tabs) == 0 || !isset($_GET['p'])) $tabs = false;
// Actions
if(ACTION == 'login'){
	// hook
	eval(callHook('startAdminLogin'));
	if(isset($_SESSION['msg_install'])) unset($_SESSION['msg_install']);
	$loginAttempt = (isset($_SESSION['loginAttempt'])) ? $_SESSION['loginAttempt'] : 0;
	$loginAttempt++;
	$_SESSION['loginAttempt'] = $loginAttempt;
	if($loginAttempt > 4 || !isset($_SESSION['loginAttempt'])) $msg = lang('Please wait before retrying');
	else{
		if(encrypt(trim($_POST['adminPwd'])) == $coreConf['adminPwd'] && mb_strtolower($_POST['adminEmail']) == mb_strtolower($coreConf['adminEmail'])){
			$_SESSION['admin']        = $coreConf['adminPwd'];
			$_SESSION['loginAttempt'] = 0;
			$_SESSION['token']        = sha1(uniqid(mt_rand()));
			$_SESSION['timeout']      = time();
			header('location:index.php');
			die();
		}
		else $msg = lang('Incorrect password');
	}
	// hook
	eval(callHook('endAdminLogin'));
}
elseif(ACTION == 'logout'){
	session_destroy();
	header('location:index.php');
	die();
}
elseif(ACTION == 'delinstallfile') @unlink('../install.php');
// Login mode
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != $coreConf['adminPwd']){
	include_once('login.php');
}
// Homepage mode
elseif(!isset($_GET['p'])){
	if(!file_exists('../.htaccess')) $msg.= lang('The .htaccess file is missing !')."\n";
	if(file_exists('../install.php')) $msg.= lang('The install.php file must be deleted !')."&nbsp;&nbsp;&nbsp;<a class=\"label secondary round\" href=\"index.php?action=delinstallfile&token=".$token."\">&#10007;&nbsp;".lang('Delete')."</a>\n";
	$checkSite = getCoreConf('checkUrl');
	$newVersion = newVersion(getCoreConf('checkUrl'));
	include_once('home.php');
}
// Plugin mode
elseif(isset($_GET['p']) && $runPlugin->getAdminFile()){
	// hook
	eval(callHook('startAdminIncludePluginFile'));
	include($runPlugin->getAdminFile());
	// mode standard
	if(!is_array($runPlugin->getAdminTemplate())) include($runPlugin->getAdminTemplate());
	// mode tabs
	if(is_array($runPlugin->getAdminTemplate())){
		include_once(ROOT.'admin/header.php');
		foreach($runPlugin->getAdminTemplate() as $k=>$v){
			echo '<div class="tab" id="tab-'.$k.'">';
			echo '<h3>'.lang($tabs[$k]['label']).'</h3>';
			include_once($v);
			echo '</div>';
		}
		include_once(ROOT.'admin/footer.php');
	}
	// hook
	eval(callHook('endAdminIncludePluginFile'));
}
?>