<!DOCTYPE html>
<html lang="<?php showSiteLang(); ?>">
    <head>
        <meta charset="utf-8" />
	    <title><?php showTitleTag(); ?></title>
        <meta name="description" content="<?php showMetaDescriptionTag(); ?>" />
	    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
	    <base href="<?php showSiteUrl(); ?>/" />
	    <link rel="stylesheet" type="text/css" href="theme/<?php echo getCoreConf("theme"); ?>/normalize.css" />
	    <?php showLinkTags(); ?>
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->	    
	    <?php showScriptTags(); ?>
	    <?php eval(callHook('endFrontHead')); ?>
    </head>
    <body>
        <div id="container">
            <header id="header">
		<div id="header_content">
		    <p id="siteName"><a title="<?php showSiteDescription(); ?>" href="<?php showSiteUrl(); ?>"><?php showSiteName(); ?></a></p>
		</div>
	    </header>
	    <div id="body">
		<section id="content" class="<?php showPluginId(); ?>">
		<ul id="breadcrumb">
		    <?php showBreadcrumb(); ?>
		</ul>
		    <?php showMainTitle(); ?>