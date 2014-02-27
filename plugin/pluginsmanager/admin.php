<?php
defined('ROOT') OR exit('No direct script access allowed');

$msg = (isset($_GET['msg'])) ? urldecode($_GET['msg']) : '';
$msgType = (isset($_GET['msgType'])) ? $_GET['msgType'] : '';

switch(ACTION){
	case '':
		$plugins = array();
		foreach($pluginsManager->getPlugins() as $k=>$v){
			$plugins[$k]['id'] = $v->getName();
			$plugins[$k]['locked'] = ($v->getIsDefaultPlugin() || $v->getName() == 'pluginsmanager') ? true : false;
			$plugins[$k]['name'] = $v->getInfoVal('name');
			$plugins[$k]['description'] = $v->getInfoVal('description');
			$plugins[$k]['target'] = ($v->getAdminFile() && $v->getName() != 'pluginsmanager') ? 'index.php?p='.$v->getName() : false;
			$plugins[$k]['activate'] = ($v->getConfigVal('activate')) ? true : false;
			$plugins[$k]['priority'] = $v->getConfigVal('priority');
			$plugins[$k]['version'] = $v->getInfoVal('version');
			$plugins[$k]['author'] = $v->getInfoVal('author');
			$plugins[$k]['authorEmail'] = $v->getInfoVal('authorEmail');
			$plugins[$k]['authorWebsite'] = $v->getInfoVal('authorWebsite');
			$plugins[$k]['frontFile'] = $v->getPublicFile();
		}
		$priority = array(
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5,
			6 => 6,
			7 => 7,
			8 => 8,
			9 => 9,
		);
		break;
	case 'save':
		foreach($pluginsManager->getPlugins() as $k=>$v) {
			if(!$v->getIsDefaultPlugin()){
				if(isset($_POST['activate'][$v->getName()])){
					$v->setConfigVal('activate', 1);
				}else {
					$v->setConfigVal('activate', 0);
				}
			}
			$v->setConfigVal('priority', intval($_POST['priority'][$v->getName()]));
			if(!$pluginsManager->savePluginConfig($v)){
				$msg = lang('An error occured while saving your modifications.');
				$msgType = 'error';
			}
			else{
				$msg = lang("The changes have been saved.");
				$msgType = 'success';
			}
		}
		header('location:index.php?p=pluginsmanager&msg='.urlencode($msg).'&msgType='.$msgType);
		die();
		break;
}
?>