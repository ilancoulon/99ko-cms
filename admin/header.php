<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php show::siteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php show::siteLang(); ?>">
  <head>
	<?php eval($core->callHook('adminHead')); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">	
	<title>99ko - <?php echo $core->lang('Backend'); ?></title>	
	<link rel="icon" href="assets/favicon.gif">
	<?php show::linkTags(); ?>
	<link rel="stylesheet" href="assets/css/99ko.css" media="all">
	<?php show::scriptTags(); ?>
	<?php eval($core->callHook('endAdminHead')); ?>	
  </head>
  
  <body class="antialiased hide-extras">

    <div class="nav off-canvas-wrap">
      <div class="inner-wrap">

<!-- TOP BAR -->
<nav class="top-bar docs-bar hide-for-small" data-topbar>
  <ul class="title-area">
    <li class="name">
      <h1><a href="./"><?php show::siteName(); ?></a></h1>
    </li>
  </ul>
  <!-- RETOUR SITE & DECONNEXION -->
  <section class="top-bar-section">
    <ul class="right">
	  <li class="divider notifsNumber"></li>
	  <!-- notifications -->
	  <li class="notifsNumber">
		<a href="#" data-reveal-id="notifs">
		   <?php echo $core->lang('Notifications'); ?> <span class="notif round label">1</span>
		</a>
	  </li>
	  <li class="divider"></li>
      <li>
        <a href="index.php?action=logout&token=<?php echo administrator::getToken(); ?>">
           <?php echo $core->lang('Logout'); ?>
        </a>
      </li>
      <li class="divider"></li>
      <li class="has-form">
        <a href="../" class="tiny button" onclick="window.open(this.href);return false;"><?php echo $core->lang('Back to website'); ?></a>
      </li>
    </ul>
  </section>
</nav>

<!-- NAVIGATION MOBILE -->
<nav class="tab-bar show-for-small">
  <a class="left-off-canvas-toggle menu-icon">
    <span><?php show::siteName(); ?></span>
  </a>
</nav>

<aside class="nav-left-off-canvas-menu">
  <ul class="off-canvas-list">
    <li><label class="first"><?php show::siteName(); ?></label></li>
  </ul>

  <hr>
  <ul class="off-canvas-list">
    <li><label><?php echo $core->lang('Navigation'); ?></label></li>
	<!--<li><a href="./"><?php echo $core->lang('Home'); ?></a></li>-->
              	  <?php foreach($pluginsManager->getPlugins() as $k=>$v) if($v->getConfigVal('activate') && $v->getAdminFile()){ ?>
              	  <li><a class="" href="index.php?p=<?php echo $v->getName(); ?>"><?php echo $core->lang($v->getInfoVal('name')); ?></a></li>
              	  <?php } ?>
	<!-- notifications mobile -->
	<li class="notifsNumber">
		<a href="#" data-reveal-id="notifs"><?php echo $core->lang('Notifications'); ?> <span class="notif round label"></span></a>
	</li>
    <li><a href="index.php?action=logout&token=<?php echo administrator::getToken(); ?>" class="tiny button alert"><?php echo $core->lang('Logout'); ?></a></li>
    <li><a href="../" class="tiny button" onclick="window.open(this.href);return false;"><?php echo $core->lang('Back to website'); ?></a></li>	
  </ul>
</aside>

<a class="exit-off-canvas"></a>

        <!-- CONTENU & SIDEBAR NAVIGATION PRINCIPALE -->
        <section role="main" class="<?php echo $runPlugin->getName(); ?>-admin">        
          <div class="row">
            
            <!-- SIDEBAR -->
            <div class="large-3 medium-4 columns">
              <div class="hide-for-small">
              <div class="sidebar">
                <p class="text-center">
                   <img src="assets/logo.png" alt="logo" />
                </p>
                
                <!-- NAVIGATION PRINCIPALE -->
                <nav>
                  <ul class="side-nav">
                    <li class="heading"><?php echo $core->lang('Navigation'); ?></li>
		    <!--<li><a href="./"><?php echo $core->lang('Home'); ?></a></li>-->
              	  <?php foreach($pluginsManager->getPlugins() as $k=>$v) if($v->getConfigVal('activate') && $v->getAdminFile()){ ?>
              	  <li><a class="" href="index.php?p=<?php echo $v->getName(); ?>"><?php echo $core->lang($v->getInfoVal('name')); ?></a></li>
              	  <?php } ?>

                    <li class="divider"></li>
                  </ul>
                </nav>
                
                <a title="<?php echo $core->lang("NoDB CMS"); ?>" onclick="window.open(this.href);return false;" href="http://99ko.hellojo.fr" class="copyright button expand"><?php echo $core->lang("Just using <b>99ko</b>"); ?> <?php echo VERSION; ?></a>

              </div>  <!-- /sidebar -->
              </div> <!-- /hide-for-small -->
            </div> <!-- /large-3 medium-4 columns -->
            
            
            <!-- CONTENU -->          
            <div class="large-9 medium-8 columns">
        <br><br>
		        <h2><?php echo $core->lang($pageTitle); ?></h2>
		        <hr><br><br>
		        <?php show::msg($msg, $msgType); // Affichage de toutes les Notifications ?>		        
		          <?php if($runPlugin->useAdminTabs()){ ?>
                      <dl class="radius tabs" data-tab>
           	          <?php foreach($runPlugin->getAdminTabs() as $k=>$v){ ?>
			            <dd><a href="#tab-<?php echo $k; ?>"><?php echo $core->lang($v); ?></a></dd>
			          <?php } ?>
                      </dl>
                      <div class="tabs-content">
                         <div class="panel radius active">
		          <?php } ?>
