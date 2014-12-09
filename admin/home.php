<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(ROOT.'admin/header.php') ?>
<?php eval(callHook('startAdminHome')); ?>

	<?php
	# On test si la directive allow_url_fopen est disponible
    if (!ini_get('allow_url_fopen')) echo showMsg(lang("Unable to check for updates as 'allow_url_fopen' is disabled on this system."), "alert");
    if(!$newVersion){	         
             echo showMsg(lang("You are using the latest version of 99ko"). '&nbsp;&nbsp;&nbsp;<b>' .$version. '</b>', "info");
          } else {
             echo showMsg(lang("A new version of 99ko is available"). '&nbsp;&nbsp;&nbsp;<b>' .$newVersion. '</b>', "warning");
    } 
    ?>
	<div class="panel"> 
	   <h3 class="subheader">
          <?php echo lang('Download a more recent version, plugins and themes on the site official.'); ?><br />
	      <?php echo lang('In case of problem with 99ko, go to the support forum.'); ?>
	   </h3>
	</div>
	<ul class="button-group radius">
	    <li><a class="button secondary" href="http://99ko.hellojo.fr" onclick="window.open(this.href);return false;"><?php echo lang('Official site'); ?></a></li> 
	    <li><a class="button" href="http://99ko.hellojo.fr/forum" onclick="window.open(this.href);return false;"><?php echo lang('Board support'); ?></a></li>
   </ul>
   <?php eval(callHook('endAdminHome')); ?>
<?php include_once(ROOT.'admin/footer.php') ?>
