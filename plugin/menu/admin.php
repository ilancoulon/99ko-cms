<?php

defined('ROOT') OR exit('No direct script access allowed');

$data['menuMode'] = '';

$action = (isset($_GET['action'])) ? $_GET['action'] : '';

switch ($action) {
	case 'save':
		if($administrator->isAuthorized()){
			$links = array();
			for ($i = 0; $i < $_POST['number']; $i += 1) {
				if (!isset($_POST['deleted'.$i])) {
					if ($_POST['id'.$i] == -1) {
						$link = menu::createLink($_POST['label'.$i], $_POST['url'.$i], 'menu', $_POST['target'.$i]);
						$_POST['id'.$i] = $link->getId();
					} else if ($_POST['plugin'.$i] === 'menu') {
						$link = menu::updateLink($_POST['id'.$i], $_POST['label'.$i], $_POST['url'.$i], 'menu', $_POST['target'.$i]);
					}
					$links[] = array(
						'id' => $_POST['id'.$i],
						'plugin' => $_POST['plugin'.$i]
					);
				}
			}
			$index = util::readJsonFile(MENU_LINKS.'index.json');
			$index['links'] = $links;
			util::writeJsonFile(MENU_LINKS.'index.json', $index);
			menu::saveMenu();
			header('location:index.php?p=menu');
			die();
		}
		break;
	default:
		$data['menuMode'] = 'list';
		$data['menuLinks'] = menu::getLinks();
		break;
}

?>
