<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<br />		  
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo $core->lang("Admin mail"); ?></label>
      <input type="email" name="adminEmail" value="<?php echo $core->getConfigVal('adminEmail'); ?>" />
    </div>
  </div>  

  <div class="row">
    <div class="large-6 columns">
      <label><?php echo $core->lang("New admin password"); ?></label>
      <input type="password" name="adminPwd" value="" autocomplete="off" style="display: none;" />
      <input type="password" name="_adminPwd" value="" autocomplete="off" />
    </div>
    <div class="large-6 columns">
      <label><?php echo $core->lang("Confirmation"); ?></label>
      <input type="password" name="_adminPwd2" value="" autocomplete="off" />
    </div>
  </div>
  
  <button type="submit" class="button success radius"><?php echo $core->lang("Save"); ?></button>