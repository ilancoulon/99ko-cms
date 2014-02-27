<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php showSiteLang(); ?>" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
  <head>
    <meta charset="utf-8" />
	<title><?php showTitleTag(); ?></title>
    <meta name="description" content="<?php showMetaDescriptionTag(); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
	<link rel="icon" type="image/x-icon" href="theme/<?php echo getCoreConf("theme"); ?>/favicon.ico" />
	<base href="<?php showSiteUrl(); ?>/" />
	<?php
	      showLinkTags();            // Charge automatiquement les feuilles de style (thème et plugins)
	      showScriptTags();          // Charge automatiquement les fichiers javascript (thème et plugins)
	      eval(callHook('endFrontHead'));  // Appel du hook pour les plugins dans la balise head
	?>
	<style type="text/css">.<?php showPluginId(); ?>{padding-top: 80px;}</style>
  </head>
  <body>
  
  <!-- Navigation -->     
  <nav class="top-bar" data-topbar>
    <ul class="title-area">
      <!-- Logo & Titre -->
      <li class="name">
        <h1>
          <a title="<?php showSiteDescription(); ?>" href="<?php showSiteUrl(); ?>">
            <?php showSiteName(); ?>
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
        <?php showMainNavigation('<li><a href="[target]">[label]</a></li><li class="divider"></li>'); ?>
      </ul>
    </section>
  </nav>
  <!-- Navigation Fin -->
  
  <!-- Contenu et Colonne de droite -->
  <div class="row <?php showPluginId(); ?>">

    <div class="large-<?php if($sidebar){ ?>9<?php } else{ ?>12<? } ?> columns">	
	   <?php showMainTitle(); ?>