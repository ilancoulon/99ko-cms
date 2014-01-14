<?php if(!defined('ROOT')) die(); ?>
<form id="configForm" method="post" action="index.php?p=configmanager&action=save">
    <?php showMsg($msg, 'error'); ?>
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
  </div> 
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Site name"); ?></label>
      <input type="text" name="siteName" value="<?php echo $config['siteName']; ?>" />
    </div>
    <div class="large-6 columns">
      <label><?php echo lang("Site description"); ?></label>
      <input type="text" name="siteDescription" value="<?php echo $config['siteDescription']; ?>" />
    </div>
  </div>
    
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Theme"); ?></label>
      <ul class="no-bullet">
      <?php foreach($themes as $k=>$v){ ?>
	    <li><input type="radio" name="theme" <?php if($v['selected']){ ?>checked<?php } ?> value="<?php echo $k; ?>" /> <label for="theme"><?php echo $v['name']; ?> <a href="#" data-reveal-id="<?php echo utilStrToUrl($v['name']); ?>" class="label radius"><?php echo lang("About"); ?></a></label></li>
	    <div id="<?php echo utilStrToUrl($v['name']); ?>" class="reveal-modal small" data-reveal>
		    <h2><?php echo lang("Theme"); ?> <?php echo $v['name']; ?></h2>
		    <p><?php echo lang("Author"); ?> :<?php echo $v['author']; ?></p>
		    <p><?php echo $v['authorEmail']; ?></p>
		    <p><a href="<?php echo $v['authorWebsite']; ?>" onclick="window.open(this.href);return false;"><?php echo $v['authorWebsite']; ?></a></p>
		    <a class="close-reveal-modal">&#215;</a>
	    </div>
	    <?php } ?>
      </ul>	    
    </div>
    <div class="large-6 columns">
      <label>Titres</label>
      <input <?php if($config['hideTitles']){ ?>checked<?php } ?> type="checkbox" name="hideTitles" /> <label for="hideTitles"><?php echo lang("Hide pages titles"); ?></label>
    </div>
  </div>
 
  <div class="row">
    <div class="large-2 columns">
      <label><?php echo lang("Default plugin"); ?></label>
      <select name="defaultPlugin">
	    <?php foreach($plugins as $k=>$v) if($v['target'] && $v['activate'] && $v['frontFile']){ ?>
	    <option <?php if($v['isDefaultPlugin']){ ?>selected<?php } ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
	    <?php } ?>
      </select>
    </div>
  </div> 
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Admin mail"); ?></label>
      <input type="text" name="adminEmail" value="<?php echo $config['adminEmail']; ?>" />
    </div>
  </div>  

  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("New admin password"); ?></label>
      <input type="password" name="adminPwd" value="" />
    </div>
    <div class="large-6 columns">
      <label><?php echo lang("Confirmation"); ?></label>
      <input type="password" name="adminPwd2" value="" />
    </div>
  </div>

  <button type="submit" class="button success radius"><?php echo lang("Save"); ?></button>