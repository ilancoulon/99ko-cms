<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<br />
<form id="configForm" method="post" action="index.php?p=configmanager&action=save" autocomplete="off">
  <?php show::adminTokenField(); ?>
    
  <div class="row">
    <div class="large-12 columns">
      <input <?php if($core->getConfigVal('hideTitles')){ ?>checked<?php } ?> type="checkbox" name="hideTitles" /> <label for="hideTitles"><?php echo $core->lang("Hide pages titles"); ?>
    </div>
    <div class="large-4 columns">
      <label><?php echo $core->lang("Lang"); ?></label>
      <select name="lang">
	    <?php foreach($core->getLangs() as $k=>$v){ ?>
	    <option <?php if($v == $core->getConfigVal('siteLang')){ ?>selected<?php } ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
	    <?php } ?>
      </select>
    </div>
    <div class="large-4 columns">
      <label><?php echo $core->lang("Default plugin"); ?> (public)</label>
      <select name="defaultPlugin">
	    <?php foreach($pluginsManager->getPlugins() as $plugin) if($plugin->getAdminFile() && $plugin->getConfigVal('activate') && $plugin->getPublicFile()){ ?>
	    <option <?php if($plugin->getIsDefaultPlugin()){ ?>selected<?php } ?> value="<?php echo $plugin->getName(); ?>"><?php echo $plugin->getInfoVal('name'); ?></option>
	    <?php } ?>
      </select>
    </div>
	<div class="large-4 columns">
      <label><?php echo $core->lang("Default plugin"); ?> (admin)</label>
      <select name="defaultAdminPlugin">
		<option value=""><?php echo $core->lang("None"); ?></option>
	    <?php foreach($pluginsManager->getPlugins() as $k=>$v) if($v->getConfigVal('activate') && $v->getAdminFile()){ ?>
	    <option <?php if($v->getName() == DEFAULT_ADMIN_PLUGIN){ ?>selected<?php } ?> value="<?php echo $v->getName(); ?>"><?php echo $v->getInfoVal('name'); ?></option>
	    <?php } ?>
      </select>
    </div>
  </div> 
  
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo $core->lang("Site name"); ?></label>
      <input type="text" name="siteName" value="<?php echo $core->getConfigVal('siteName'); ?>" required />
    </div>	    
  </div>
  
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo $core->lang("Site description"); ?></label>
      <input type="text" name="siteDescription" value="<?php echo $core->getConfigVal('siteDescription'); ?>" required />
    </div>
  </div>
    
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo $core->lang("Theme"); ?></label>
      <ul class="no-bullet">
      <?php foreach($core->getThemes() as $k=>$v){ ?>
	    <li><input type="radio" name="theme" <?php if($k == $core->getConfigVal('theme')){ ?>checked<?php } ?> value="<?php echo $k; ?>" /> <label for="theme"><?php echo $v['name']; ?> <a class="label secondary round" target="_blank" href="<?php echo $v['authorWebsite']; ?>"><?php echo $v['authorWebsite']; ?></a></label></li>
	    <?php } ?>
      </ul>	    
    </div>
  </div>
  
  <button type="submit" class="button success radius"><?php echo $core->lang("Save"); ?></button>