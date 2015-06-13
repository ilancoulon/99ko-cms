<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(ROOT.'admin/header.php') ?>
<?php eval($core->callHook('startAdminHome')); ?>
	<div class="panel"> 
	   <h3 class="subheader">
          <?php echo $core->lang('Download a more recent version, plugins and themes on the site official.'); ?><br />
	      <?php echo $core->lang('In case of problem with 99ko, go to the support forum.'); ?>
	   </h3>
	</div>
	<ul class="button-group radius">
	    <li><a class="button secondary" href="http://99ko.hellojo.fr" onclick="window.open(this.href);return false;"><?php echo $core->lang('Official site'); ?></a></li> 
	    <li><a class="button secondary" href="http://99ko.hellojo.fr/forum" onclick="window.open(this.href);return false;"><?php echo $core->lang('Board support'); ?></a></li>
		<li><a class="button" href="https://www.facebook.com/pages/99ko-CMS/791174950978461" onclick="window.open(this.href);return false;"><?php echo $core->lang('Follow 99ko'); ?></a></li>
   </ul>
   <?php eval($core->callHook('endAdminHome')); ?>
<?php include_once(ROOT.'admin/footer.php') ?>
