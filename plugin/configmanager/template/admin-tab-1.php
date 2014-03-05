<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<br />		  
  <div class="row">
    <div class="large-6 columns">
      <a onclick="window.open(this.href);return false;" href="http://gravatar.com" data-tooltip class="has-tip tip-top" title="<?php echo lang('To view your profile image, create an account on gravatar.com'); ?>">
          <label><?php echo lang("Gravatar?"); ?></label>
          <?php echo profil_img(getCoreConf('adminEmail'), '100', '', 'G'); ?>
      </a>
    </div>  
    <div class="large-6 columns">
      <label><?php echo lang("Admin mail"); ?></label>
      <input type="email" name="adminEmail" value="<?php echo $config['adminEmail']; ?>" />
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