<?php
defined('ROOT') OR exit('No direct script access allowed');
$data['pageMode'] = '';

$msg = (isset($_GET['msg'])) ? urldecode($_GET['msg']) : '';
$msgType = (isset($_GET['msgType'])) ? $_GET['msgType'] : '';
$error = false;

$data['pageChangeOrder'] = (pluginsManager::isActivePlugin('menu')) ? false : true;
$hideTitles = $runPlugin->getConfigVal('hideTitles');
switch(ACTION){
	case 'save':
		if($_POST['id'] != '') $pageItem = $page->create($_POST['id']);
		else $pageItem = new pageItem();
		$pageItem->setName($_POST['name']);
		$pageItem->setIsHomepage((isset($_POST['isHomepage'])) ? 1 : 0);
		if(!pluginsManager::isActivePlugin('menu')) $pageItem->setPosition($_POST['position']);
		$pageItem->setContent($_POST['content']);
		$pageItem->setFile($_POST['file']);
		$pageItem->setIsHidden((isset($_POST['isHidden'])) ? 1 : 0);
		$pageItem->setMainTitle($_POST['mainTitle']);
		$pageItem->setMetaDescriptionTag($_POST['metaDescriptionTag']);
		if($page->save($pageItem)){
			$msg = lang("The changes have been saved.");
			$msgType = 'success';
		}
		else{
			$msg = lang("An error occurred while saving the changes.");
			$msgType = 'error';
		}
		header('location:index.php?p=page&msg='.urlencode($msg).'&msgType='.$msgType);
		die();
		break;
	case 'saveconfig':
		$hideTitles = (isset($_POST['hideTitles'])) ? 1 : "0";
		$runPlugin->setConfigVal('hideTitles', $hideTitles);
		if($pluginsManager->savePluginConfig($runPlugin)){
			$msg = lang("The changes have been saved.");
			$msgType = 'success';
		}
		else{
			$msg = lang("An error occurred while saving the changes.");
			$msgType = 'error';
		}
		header('location:index.php?p=page&msg='.urlencode($msg).'&msgType='.$msgType);
		die();
		break;
	case 'edit':
		if(isset($_GET['id'])) $pageItem = $page->create($_GET['id']);
		else $pageItem = new pageItem();
		$data['pageId'] = $pageItem->getId();
		$data['pageName'] = $pageItem->getName();
		$data['pagePosition'] = $pageItem->getPosition();
		$data['pageIsHomepage'] = $pageItem->getIshomepage();
		$data['pageContent'] = $pageItem->getContent();
		$data['pageMode'] = 'edit';
		$data['pageIsHomepageChecked'] = ($pageItem->getIshomepage()) ? 'checked' : '';
		$data['pageFile'] = $pageItem->getFile();
		$data['pageIsHidden'] = $pageItem->getIsHidden();
		$data['pageFiles'] = $page->listFiles();
		$data['pageMainTitle'] = $pageItem->getMainTitle();
		$data['pageMetaDescriptionTag'] = $pageItem->getMetaDescriptionTag();
		$data['pageTheme'] = getCoreConf('theme');
		break;
	case 'del':
		$pageItem = $page->create($_GET['id']);
		if($page->del($pageItem)){
			$msg = lang("The changes have been saved.");
			$msgType = 'success';
		}
		else{
			$msg = lang("An error occurred while saving the changes.");
			$msgType = 'error';
		}
		header('location:index.php?p=page&msg='.urlencode($msg).'&msgType='.$msgType);
		die();
	default:
		$pageItems = $page->getItems();
		$data['pageMode'] = 'list';
		if(!$page->createHomepage()){
			$msg = lang("No homepage defined");
			$msgType = 'error';
		}
		$data['pageList'] = array();
		foreach($pageItems as $k=>$pageItem){
			$data['pageList'][$k]['id'] = $pageItem->getId();
			$data['pageList'][$k]['name'] = $pageItem->getName();
			$data['pageList'][$k]['position'] = $pageItem->getPosition();
			$data['pageList'][$k]['isHomepage'] = $pageItem->getIshomepage();
			$data['pageList'][$k]['content'] = $pageItem->getContent();
			$data['pageList'][$k]['isHidden'] = $pageItem->getIsHidden();
		}
}
?>