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

define('ROOT', '../');
include_once(ROOT.'common/common.php');
// on genere le jeton
//$token = util::generateToken();
// on check le jeton
//$array_actions = array('delinstallfile', 'save', 'del', 'saveconfig', 'saveplugins', 'login', 'logout');
//if(isset($_GET['action']) && in_array($_GET['action'], $array_actions) && !util::checkToken($token)){	
	//include_once('login.php');
	//die();
//}
// cache
//clearCache();
// variables de template
//$msg = '';
//$msgType = '';
//$version = VERSION;
//$pluginName = $runPlugin->getName();
//$navigation[-1]['label'] = $core->lang('Home');
//$navigation[-1]['url'] = './';
//$navigation[-1]['isActive'] = (!isset($_GET['p'])) ? true : false;
//foreach($pluginsManager->getPlugins() as $k=>$v) if($v->getConfigVal('activate') && $v->getAdminFile()){
	//$navigation[$k]['label'] = $v->getInfoVal('name');
	//$navigation[$k]['url'] = 'index.php?p='.$v->getName();
	//$navigation[$k]['isActive'] = (isset($_GET['p']) && $_GET['p'] == $v->getName()) ? true : false;
//}
//$pageTitle = (!isset($_GET['p'])) ? $core->lang('Welcome to 99ko') : $runPlugin->getInfoVal('name');
//$tabs = array();
//foreach($runPlugin->getAdminTabs() as $k=>$v){
	//$tabs[$k]['label'] = $v;
	//$tabs[$k]['url'] = '#tab-'.$k;
//}
//if(count($tabs) == 0 || !isset($_GET['p'])) $tabs = false;
// notifications
//$nbNotifs = 0;
//if(!file_exists('../.htaccess')) {
	//$notif1 = $core->lang('The .htaccess file is missing !')."\n";
	//$notifsType = 'warning';
	//$nbNotifs++;
//}
//if(file_exists('../install.php')) {
	//$notif2 = $core->lang('The install.php file must be deleted !')."&nbsp;&nbsp;&nbsp;<a class=\"label secondary round\" href=\"index.php?action=delinstallfile&token=".$token."\">&#10007;&nbsp;".$core->lang('Delete')."</a>\n";
	//$notif2Type = 'error';
	//$nbNotifs++;
//}
//$newVersion = $core->detectNewVersion();
//if (!ini_get('allow_url_fopen')){
	//$notif3 = $core->lang("Unable to check for updates as 'allow_url_fopen' is disabled on this system.");
	//$notif3Type = "error";
	//$nbNotifs++;
//}
//if($newVersion){
	//$notif4 = $core->lang("A new version of 99ko is available"). ' : <b>' .$newVersion. '</b>';
	//$notif4Type = "success";
	//$nbNotifs++;
//}
//if($core->getConfigVal('debug')){
	//$notif5 = $core->lang("The debug mode is activated!");
	//$notif5Type = "info";
	//$nbNotifs++;
//}
$msg = '';
$msgType = '';
$version = VERSION;
$pageTitle = (!isset($_GET['p'])) ? $core->lang('Welcome to 99ko') : $runPlugin->getInfoVal('name');
// actions
if(isset($_GET['action']) && $_GET['action'] == 'login'){
	// hook
	eval($core->callHook('startAdminLogin'));
	//if(isset($_SESSION['msg_install'])) unset($_SESSION['msg_install']);
	//$loginAttempt = (isset($_SESSION['loginAttempt'])) ? $_SESSION['loginAttempt'] : 0;
	//$loginAttempt++;
	//$_SESSION['loginAttempt'] = $loginAttempt;
	//if($loginAttempt > 4 || !isset($_SESSION['loginAttempt'])) $msg = $core->lang('Please wait before retrying');
	//else{
		if(encrypt(trim($_POST['adminPwd'])) == $core->getConfigVal('adminPwd') && mb_strtolower($_POST['adminEmail']) == mb_strtolower($core->getConfigVal('adminEmail'))){
			$_SESSION['admin']        = $core->getConfigVal('adminPwd');
			$_SESSION['loginAttempt'] = 0;
			header('location:index.php');
			die();
		}
		else $msg = $core->lang('Incorrect password');
	//}
	// hook
	eval($core->callHook('endAdminLogin'));
}
elseif(isset($_GET['action']) && $_GET['action'] == 'logout'){
	session_destroy();
	header('location:index.php');
	die();
}
elseif(isset($_GET['action']) && $_GET['action'] == 'delinstallfile') @unlink('../install.php');
// login mode
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != $core->getConfigVal('adminPwd')){
	include_once('login.php');
}
// homepage mode
elseif(!isset($_GET['p'])){
	include_once('home.php');
}
// plugin mode
elseif(isset($_GET['p']) && $runPlugin->getAdminFile()){
	// hook
	eval($core->callHook('startAdminIncludePluginFile'));
	include($runPlugin->getAdminFile());
	// mode standard
	if(!is_array($runPlugin->getAdminTemplate())) include($runPlugin->getAdminTemplate());
	// mode tabs
	if(is_array($runPlugin->getAdminTemplate())){
		include_once(ROOT.'admin/header.php');
		foreach($runPlugin->getAdminTemplate() as $k=>$v){
			echo '<div class="tab" id="tab-'.$k.'">';
			echo '<h3>'.$core->lang($tabs[$k]['label']).'</h3>';
			include_once($v);
			echo '</div>';
		}
		include_once(ROOT.'admin/footer.php');
	}
	// hook
	eval($core->callHook('endAdminIncludePluginFile'));
}
?>