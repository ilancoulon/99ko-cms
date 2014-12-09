<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<br />
<form id="configForm" method="post" action="index.php?p=configmanager&action=save">
  <?php showAdminTokenField(); ?>
    
  <div class="row">
    <div class="large-2 columns">
      <label><?php echo lang("Lang"); ?></label>
      <select name="lang">
	    <?php foreach($langs as $k=>$v){ ?>
	    <option <?php if($v == $config['siteLang']){ ?>selected<?php } ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
	    <?php } ?>
      </select>
    </div>
    <div class="large-2 columns">
      <label><?php echo lang("Default plugin"); ?></label>
      <select name="defaultPlugin">
	    <?php foreach($pluginsManager->getPlugins() as $plugin) if($plugin->getAdminFile() && $plugin->getConfigVal('activate') && $plugin->getPublicFile()){ ?>
	    <option <?php if($plugin->getIsDefaultPlugin()){ ?>selected<?php } ?> value="<?php echo $plugin->getName(); ?>"><?php echo $plugin->getInfoVal('name'); ?></option>
	    <?php } ?>
      </select>
    </div>  
    <div class="large-8 columns">
      <label><?php echo lang("Title"); ?></label>
      <input <?php if($config['hideTitles']){ ?>checked<?php } ?> type="checkbox" name="hideTitles" /> <label for="hideTitles"><?php echo lang("Hide pages titles"); ?></label>           
    </div>      
  </div> 
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Site name"); ?></label>
      <input type="text" name="siteName" value="<?php echo $config['siteName']; ?>" required />
    </div>	    
  </div>
  
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo lang("Site description"); ?></label>
      <input type="text" name="siteDescription" value="<?php echo $config['siteDescription']; ?>" required />
    </div>
  </div>
    
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo lang("Theme"); ?></label>
      <ul class="no-bullet">
      <?php foreach($themes as $k=>$v){ ?>
	    <li><input type="radio" name="theme" <?php if($k == $config['theme']){ ?>checked<?php } ?> value="<?php echo $k; ?>" /> <label for="theme"><?php echo $v['name']; ?><br>
	    <?php echo utilHideEmail($v['authorEmail']); ?> <a class="label secondary round" href="<?php echo $v['authorWebsite']; ?>" onclick="window.open(this.href);return false;"><?php echo $v['authorWebsite']; ?></a></label></li>
	    <?php } ?>
      </ul>	    
    </div>
  </div>
  
  <button type="submit" class="button success radius"><?php echo lang("Save"); ?></button>