   <?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<br />
   <?php showMsg(lang("Do not change advanced settings if you're not on what you're doing."), "info"); ?>   
   <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("URL of the site (no trailing slash)"); ?></label>
      <input type="text" name="siteUrl" value="<?php echo $config['siteUrl']; ?>" />
    </div>
  </div>  

  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Gzip compression"); ?></label>
      <input <?php if($config['gzip']){ ?>checked<?php } ?> type="checkbox" name="gzip" /> <label for="gzip"><?php echo lang("Enable"); ?></label> 
    </div>
  </div> 
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("URL rewriting"); ?></label>
      <input id="urlRewriting" type="checkbox" onclick="updateHtaccess('<?php echo $rewriteBase; ?>');" <?php if($config['urlRewriting']){ ?>checked<?php } ?> name="urlRewriting" /> <label for="urlRewriting"><?php echo lang("Enable"); ?></label>
    </div>
  </div> 
         
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo lang(".htaccess"); ?></label>
      <textarea id="htaccess" name="htaccess"><?php echo $htaccess; ?></textarea>
    </div>
  </div>
            
  <button type="submit" class="button success radius"><?php echo lang("Save"); ?></button>
</form>