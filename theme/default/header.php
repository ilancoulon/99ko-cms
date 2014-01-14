<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php showSiteLang(); ?>" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
  <head>
    <meta charset="utf-8" />
	<title><?php showTitleTag(); ?></title>
    <meta name="description" content="<?php showMetaDescriptionTag(); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
	<base href="<?php showSiteUrl(); ?>/" />
	<?php showLinkTags(); ?>
	<?php showScriptTags(); ?>
	<?php eval(callHook('endFrontHead')); ?>
  </head>
  <body>
    
<!-- Navigation -->
 
  <nav class="top-bar" data-topbar>
    <ul class="title-area">
      <!-- Title Area -->
      <li class="name">
        <h1>
          <a title="<?php showSiteDescription(); ?>" href="<?php showSiteUrl(); ?>">
            <?php showSiteName(); ?>
          </a>
        </h1>
      </li>
      <li class="toggle-topbar menu-icon"><a href="#"><span><?php echo lang('menu') ?></span></a></li>
    </ul>
 
    <section class="top-bar-section">
      <!-- Right Nav Section -->
      <ul class="right">
        <li class="divider"></li>
        <?php showMainNavigation('<li><a target="[targetAttribut]" href="[target]">[label]</a></li><li class="divider"></li>'); ?>
      </ul>
    </section>
  </nav>
 
  <!-- End Top Bar -->
 
  
  <div class="row <?php showPluginId(); ?>">  
    <div class="large-12 columns">  
		
	   <?php showMainTitle(); ?>