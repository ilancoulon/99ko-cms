<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(ROOT.'admin/header.php') ?>
<?php eval(callHook('startAdminHome')); ?>

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
