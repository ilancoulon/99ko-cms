<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php showSiteLang(); ?>">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">	
	<title>99ko - <?php echo lang('Backend'); ?></title>	
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon">
	<?php showLinkTags(); ?>
	<link rel="stylesheet" href="assets/css/99ko.css" media="all">
	<?php showScriptTags(); ?>
	<?php eval(callHook('endAdminHead')); ?>	
  </head>
  
  <body class="antialiased hide-extras">

    <div class="nav off-canvas-wrap">
      <div class="inner-wrap">

<!-- TOP BAR -->
<nav class="top-bar docs-bar hide-for-small" data-topbar>
  <ul class="title-area">
    <li class="name">
      <h1><a href="./"><?php showSiteName(); ?></a></h1>
    </li>
  </ul>
  <!-- RETOUR SITE & DECONNEXION -->
  <section class="top-bar-section">
    <ul class="right">
	  <li class="divider notifsNumber"></li>
	  <!-- notifications -->
	  <li class="notifsNumber">
		<a href="#" data-reveal-id="notifs">
		   <?php echo lang('Notifications'); ?> <span class="notif round label">1</span>
		</a>
	  </li>
	  <li class="divider"></li>
      <li>
        <a href="index.php?action=logout&token=<?php echo $token; ?>">
           <?php echo lang('Logout'); ?>
        </a>
      </li>
      <li class="divider"></li>
      <li class="has-form">
        <a href="../" class="tiny button" onclick="window.open(this.href);return false;"><?php echo lang('Back to website'); ?></a>
      </li>
    </ul>
  </section>
</nav>

<!-- NAVIGATION MOBILE -->
<nav class="tab-bar show-for-small">
  <a class="left-off-canvas-toggle menu-icon">
    <span><?php showSiteName(); ?></span>
  </a>
</nav>

<aside class="nav-left-off-canvas-menu">
  <ul class="off-canvas-list">
    <li><label class="first"><?php showSiteName(); ?></label></li>
  </ul>

  <hr>
  <ul class="off-canvas-list">
    <li><label><?php echo lang('Navigation'); ?></label></li>
	<?php foreach($navigation as $k=>$v){ ?>
	<li><a class="<?php if($v['isActive']){ ?>current<?php } ?>" href="<?php echo $v['url']; ?>"><?php echo lang($v['label']); ?></a></li>
	<?php } ?>
	<!-- notifications mobile -->
	<li class="notifsNumber">
		<a href="#" data-reveal-id="notifs"><?php echo lang('Notifications'); ?> <span class="notif round label"></span></a>
	</li>
    <li><a href="index.php?action=logout&token=<?php echo $token; ?>" class="tiny button alert"><?php echo lang('Logout'); ?></a></li>
    <li><a href="../" class="tiny button" onclick="window.open(this.href);return false;"><?php echo lang('Back to website'); ?></a></li>	
  </ul>
</aside>

<a class="exit-off-canvas"></a>

        <!-- CONTENU & SIDEBAR NAVIGATION PRINCIPALE -->
        <section role="main" class="<?php echo $pluginName; ?>-admin">        
          <div class="row">
            
            <!-- SIDEBAR -->
            <div class="large-3 medium-4 columns">
              <div class="hide-for-small">
              <div class="sidebar">
                <!--form>
                  <label><?php echo lang('Search Filter'); ?></label>
                  <input tabindex="1" id="autocomplete" type="search" placeholder="<?php echo lang('Search'); ?>&hellip;">
                </form-->
                <p class="text-center">
                   <img src="assets/logo.png" alt="logo" />
                </p>
                
                <!-- NAVIGATION PRINCIPALE -->
                <nav>
                  <ul class="side-nav">
                    <li class="heading"><?php echo lang('Navigation'); ?></li>
              	  <?php foreach($navigation as $k=>$v){ ?>
              	  <li><a class="<?php if($v['isActive']){ ?>current<?php } ?>" href="<?php echo $v['url']; ?>"><?php echo lang($v['label']); ?></a></li>
              	  <?php } ?>

                    <li class="divider"></li>
                  </ul>
                </nav>
                
                <a title="<?php echo lang("NoDB CMS"); ?>" onclick="window.open(this.href);return false;" href="http://99ko.hellojo.fr" class="copyright button expand"><?php echo lang("Just using <b>99ko</b>"); ?> <?php echo $version; ?></a>

              </div>  <!-- /sidebar -->
              </div> <!-- /hide-for-small -->
            </div> <!-- /large-3 medium-4 columns -->
            
            
            <!-- CONTENU -->          
            <div class="large-9 medium-8 columns">
        <br><br>
		        <h2><?php echo lang($pageTitle); ?></h2>
		        <hr><br><br>
		        <?php showMsg($msg, $msgType); // Affichage de toutes les Notifications ?>
                <noscript>
                     <?php showMsg(lang("Javascript must be enabled in your browser to take full advantage of features 99ko."), "error"); ?> 
                </noscript> 		        
		          <?php if($tabs){ ?>
                      <dl class="radius tabs" data-tab>
           	          <?php foreach($tabs as $k=>$v){ ?>
			            <dd><a href="<?php echo $v['url']; ?>"><?php echo lang($v['label']); ?></a></dd>
			          <?php } ?>
                      </dl>
                      <div class="tabs-content">
                         <div class="panel radius active">
		          <?php } ?>
