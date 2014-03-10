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
    
    <div class="large-6 columns">
      <label for="siteTimezone"><?php echo lang("Time zone"); ?></label>
      <div class="row collapse">
        <div class="small-9 columns">
           <select name="siteTimezone">
                <?php foreach($timezones as $k=>$v){ ?>
                <option <?php if($k == $config['siteTimezone']){ ?>selected="selected"<?php } ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php } ?>
           </select>        
        </div>
        <div class="small-3 columns">
          <span class="postfix radius">✓ <?php echo $config['siteTimezone']; ?></span>
        </div>
      </div>      
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
	    <li><input type="radio" name="theme" <?php if($k == $config['theme']){ ?>checked<?php } ?> value="<?php echo $k; ?>" /> <label for="theme"><?php echo $v['name']; ?></label> <a href="#" data-reveal-id="<?php echo $k; ?>" class="about label radius"><?php echo lang("About"); ?></a></li>
	    
	    <!-- Reveal Modals begin -->
	    <div id="<?php echo $k; ?>" class="reveal-modal small" data-reveal>
		    <h2><?php echo $v['name']; ?></h2>
		    <div class="row">
               <div class="large-3 columns">
                  <ul class="clearing-thumbs" data-clearing>
                       <li><a data-tooltip class="th has-tip tip-right" title="<?php echo lang("Click to enlarge"); ?>" href="<?php echo $v['screenshot']; ?>"><img data-caption="<?php echo $v['name']; ?> : <?php echo $v['author']; ?>" src="<?php echo $v['screenshot']; ?>" alt="screenshot" /></a></li>
                  </ul>             
               </div>
               <div class="large-9 columns">
		         <ul class="no-bullet">
		            <li><strong><?php echo lang("Author: "); ?></strong> <?php echo $v['author']; ?></li>
		            <?php
                      if(!empty($v['authorEmail'])){
                         echo '<li><strong>'.lang("Author Mail").'</strong> '.utilHideEmail($v['authorEmail']).'</li>';
                      }
                      if(!empty($v['authorWebsite'])){
                         echo '<li><strong>'.lang("Author Site").'</strong> <a class="label secondary round" href="'.$v['authorWebsite'].'" onclick="window.open(this.href);return false;">'.$v['authorWebsite'].'</a></li>';
                      }
                    ?>
		         </ul>	               
               </div>
            </div>
		    <a class="close-reveal-modal">&#215;</a>
	    </div>	
        <!-- Reveal Modals end -->
	    <?php } ?>
      </ul>	    
    </div>
  </div>
  
  <button type="submit" class="button success radius"><?php echo lang("Save"); ?></button>