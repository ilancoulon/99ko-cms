   <?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<br />
   <?php show::msg($core->lang("Do not change advanced settings if you're not on what you're doing."), "info"); ?>
   
     <div class="row">
    <div class="large-6 columns">
      <input <?php if($core->getConfigVal('debug')){ ?>checked<?php } ?> type="checkbox" name="debug" /> <label for="debug"><?php echo $core->lang("Debug Mod"); ?></label> 
    </div>
  </div>
     
   <div class="row">
    <div class="large-12 columns">
      <label><?php echo $core->lang("URL of the site (no trailing slash)"); ?></label>
      <input type="text" name="siteUrl" value="<?php echo $core->getConfigVal('siteUrl'); ?>" />
    </div>
  </div>  
  
  <div class="row">
    <div class="large-12 columns">
      <input id="urlRewriting" type="checkbox" onclick="updateHtaccess('<?php echo $rewriteBase; ?>');" <?php if($core->getConfigVal('urlRewriting')){ ?>checked<?php } ?> name="urlRewriting" /> <label for="urlRewriting"><?php echo $core->lang("URL rewriting"); ?></label>
    </div>
  </div> 
           
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo $core->lang(".htaccess"); ?></label>
      <textarea id="htaccess" name="htaccess"><?php echo $htaccess; ?></textarea>
    </div>
  </div>
            
  <button type="submit" class="button success radius"><?php echo $core->lang("Save"); ?></button>
</form>