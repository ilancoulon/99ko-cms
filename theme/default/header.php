<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php show::showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php show::showSiteLang(); ?>" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="dns-prefetch" href="<?php show::showSiteUrl(); ?>" />	
    <title><?php show::showTitleTag(); ?></title>
    <meta name="description" content="<?php show::showMetaDescriptionTag(); ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
    <link rel="icon" type="image/x-icon" href="theme/default/favicon.ico" />
    <base href="<?php show::showSiteUrl(); ?>/" />
    <?php
	show::showLinkTags();            // Charge automatiquement les feuilles de style (thème et plugins)
	show::showScriptTags();          // Charge automatiquement les fichiers javascript (thème et plugins)
	eval(callHook('endFrontHead'));  // Appel du hook pour les plugins dans la balise head
    ?>
    <link type="text/css" rel="stylesheet" href="theme/<?php echo getCoreConf("theme"); ?>/99ko.css">
    <style type="text/css">.<?php show::showPluginId(); ?>{padding-top: 40px;}</style>
  </head>
  <body>
  
  <!-- Navigation -->     
  <nav class="top-bar" data-topbar>
    <ul class="title-area">
      <!-- Logo & Titre -->
      <li class="name">
        <h1>
          <a title="<?php show::showSiteDescription(); ?>" href="<?php show::showSiteUrl(); ?>">
            <?php show::showSiteName(); ?>
          </a>
        </h1>
      </li>
      <!-- Affiche le bouton menu en version mobile -->
      <li class="toggle-topbar menu-icon"><a href="#"><span><?php echo lang('menu') ?></span></a></li>
    </ul>
 
    <section class="top-bar-section">   
      <!-- Affichage Menu à droite (class="left" pour placer à gauche) -->
      <ul class="right">
        <li class="divider"></li>
        <?php show::showMainNavigation(); ?>
      </ul>
    </section>
  </nav>
  <!-- Navigation Fin -->
  
  <!-- Contenu et Colonne de droite -->
  <div class="row <?php show::showPluginId(); ?>">

    <div class="large-<?php if(useSidebar()){ ?>9<?php } else{ ?>12<?php } ?> columns <?php show::showPluginId(); ?>">	
	   <?php show::showMainTitle(); ?>
