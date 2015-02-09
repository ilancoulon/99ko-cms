<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
		</div>
	</div>
	<div id="footer">
		<p>
                  <?php echo lang("<a target='_blank' href='http://99ko.hellojo.fr'>Just using 99ko</a>") ?> - <?php echo lang("Theme") ?> <?php sow:showTheme(); ?> - <a rel="nofollow" href="<?php echo ADMIN_PATH ?>"><?php echo lang('Administration') ?></a>
                </p>
	</div>
</div>
<?php eval(callHook('endFrontBody')); ?>
</body>
</html>