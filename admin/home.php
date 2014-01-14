<?php include_once(ROOT.'admin/header.php') ?>
	<?php showMsg($msg, 'error'); ?>
	<p class="panel"><?php echo lang('You are using the version'); ?> <span class="label success round"><?php echo $version; ?></span><br />
        <?php echo lang('Download a more recent version, plugins and themes on the site official.'); ?><br />
	<?php echo lang('In case of problem with 99ko, go to the support forum.'); ?></p>
	<ul class="button-group">
	    <li><a class="button radius secondary" href="http://99ko.tuxfamily.org" target="_blank"><?php echo lang('Official site'); ?></a></li> 
	    <li><a class="button radius secondary" href="http://99ko.tuxfamily.org/forum" target="_blank"><?php echo lang('Board support'); ?></a></li>
   </ul>
<?php include_once(ROOT.'admin/footer.php') ?>