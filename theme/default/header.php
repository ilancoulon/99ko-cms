<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php show::showSiteLang(); ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php show::showTitleTag(); ?></title>
	<base href="<?php show::showSiteUrl(); ?>/" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
	<meta name="description" content="<?php show::showMetaDescriptionTag(); ?>" />
	<link rel="icon" href="theme/<?php show::showTheme("[id]"); ?>/flower.png" />
	<?php show::showLinkTags(); ?>
	<?php show::showScriptTags(); ?>
	<?php eval(callHook('endFrontHead')); ?>
</head>
<body>
<div id="container">
	<div id="header">
		<div id="header_content">
			<p id="siteName"><a title="<?php show::showSiteDescription(); ?>" href="<?php show::showSiteUrl(); ?>"><?php show::showSiteName(); ?></a></p>
		</div>
		<div id="banner"></div>
	</div>
	<div id="body">
		<div id="sidebar">
			<ul id="navigation">
				<?php show::showMainNavigation(); ?>
			</ul>
		</div>
		<div id="content" class="<?php show::showPluginId(); ?>">
			<h1><?php show::showMainTitle(); ?></h1>