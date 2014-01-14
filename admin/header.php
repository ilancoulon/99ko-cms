<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php showSiteLang(); ?>">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">	
	<title>99ko - Administration</title>	
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
	<?php showLinkTags(); ?>
	<link rel="stylesheet" href="css/99ko.css?v1.0=" media="all">
	<?php showScriptTags(); ?>
	<?php eval(callHook('endAdminHead')); ?>	
  </head>
  
  <body class="antialiased hide-extras">

    <div class="marketing off-canvas-wrap">
      <div class="inner-wrap">


<nav class="top-bar docs-bar hide-for-small" data-topbar>
  <ul class="title-area">
    <li class="name">
      <h1><a href="./"><?php showSiteName(); ?></a></h1>
    </li>
  </ul>

  <section class="top-bar-section">
    <ul class="right">
      <li class="divider"></li>
      <li>
        <a href="index.php?action=logout&token=<?php echo $token; ?>">
           <?php echo show_gravatar($config['adminEmail'], '35', '', 'G'); ?>&nbsp;<?php echo lang('Logout'); ?>
        </a>
      </li>
      <li class="divider"></li>
      <li class="has-form">
        <a href="../" class="tiny button" onclick="window.open(this.href);return false;"><?php echo lang('Back to website'); ?></a>
    </ul>
  </section>
</nav>
<nav class="tab-bar show-for-small">
  <a class="left-off-canvas-toggle menu-icon">
    <span><?php showSiteName(); ?></span>
  </a>
</nav>

<aside class="marketing-left-off-canvas-menu">

  <ul class="off-canvas-list">
    <li><label class="first"><?php showSiteName(); ?></label></li>
  </ul>

  <hr>

  <ul class="off-canvas-list">
    <li><label>Navigation</label></li>
	<?php foreach($navigation as $k=>$v){ ?>
	<li><a class="<?php if($v['isActive']){ ?>current<?php } ?>" href="<?php echo $v['url']; ?>"><?php echo lang($v['label']); ?></a></li>
	<?php } ?>
  </ul>
</aside>

<a class="exit-off-canvas" href="#"></a>


        <section role="main" class="<?php echo $pluginName; ?>-admin">
        
          <div class="row">
            <div class="large-3 medium-4 columns">
              <div class="hide-for-small">
              <div class="sidebar">
  <form>
    <label>Filtre de Recherche</label>
    <input tabindex="1" id="autocomplete" type="search" placeholder="Rechercher">
  </form>

  <nav>
    <ul class="side-nav">
      <li class="heading">Navigation</li>

	  <?php foreach($navigation as $k=>$v){ ?>
	  <li><a class="<?php if($v['isActive']){ ?>current<?php } ?>" href="<?php echo $v['url']; ?>"><?php echo lang($v['label']); ?></a></li>
	  <?php } ?>

      <li class="divider"></li>
    </ul>
  </nav>

  <a onclick="window.open(this.href);return false;" href="http://99ko.tuxfamily.org/" class="download button expand">Just using <b>99ko</b> <span class="label"><?php echo $version; ?></span></a>

</div>  
              </div>
            </div>
            
            
            <!-- Content -->
            
            <div class="large-9 medium-8 columns">

		<h2><?php echo lang($pageTitle); ?></h2>
		<hr>
		<?php if($pluginConfigTemplate){ ?>
			<div id="pluginConfig">
				<?php include_once($pluginConfigTemplate); ?>
				<hr>
			</div>
		<?php } ?>
		<?php if($tabs){ ?>
        <dl class="radius tabs" data-tab>
           	<?php foreach($tabs as $k=>$v){ ?>
			<dd><a href="<?php echo $v['url']; ?>"><?php echo lang($v['label']); ?></a></dd>
			<?php } ?>
        </dl>
        <div class="tabs-content">
           <div class="content6">
		<?php } ?>